<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\ReceiveItem;
use App\Models\Unit;
use Illuminate\Http\Request;

class ReceiveItemsController extends Controller
{
    protected $pathView = 'receive-items';

    public function index(Request $request)
    {
        $search = $request->search;
        $listView = $request->view ?? '';

        $data = ReceiveItem::with('purchaseOrder')->where(function ($q) use ($search) {
            if (isset($search)) {
                $q->where('code', 'like', "%$search%");
            }
        })->paginate(20)->appends(['search' => $search]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search', 'listView'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::with('vendor')->where('status', 'Confirmed')->orWhere('status', 'Done')->get();
        $products = Product::all();
        $units = Unit::all();

        return view($this->pathView.'.create', compact('purchaseOrders', 'products', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'code' => 'nullable|unique:receive_items,code',
            'trx_date' => 'required|date',
            'description' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Draft,Quotation,Confirmed,Done',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.received' => 'required|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.paid' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0',
            'items.*.tax_value' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        if (empty($validated['code'])) {
            $lastReceiveItem = ReceiveItem::latest('id')->first();
            $nextNumber = $lastReceiveItem ? ((int) substr($lastReceiveItem->code, 3)) + 1 : 1;
            $validated['code'] = 'RI-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        $validated['user_id'] = auth()->id();

        $receiveItem = ReceiveItem::create($validated);

        foreach ($request->items as $item) {
            $receiveItem->receiveItemDetails()->create([
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],
                'quantity' => $item['quantity'],
                'received' => $item['received'],
                'price' => $item['price'],
                'paid' => $item['paid'],
                'subtotal' => $item['subtotal'],
                'tax' => $item['tax'] ?? 0,
                'tax_value' => $item['tax_value'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('receive-items.index')->with('success', 'Receive Item created successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $receiveItem = ReceiveItem::with(['receiveItemDetails.product', 'receiveItemDetails.unit'])->findOrFail($id);
        $purchaseOrders = PurchaseOrder::with('vendor')->where('status', 'Confirmed')->orWhere('status', 'Done')->get();
        $products = Product::all();
        $units = Unit::all();

        return view($this->pathView.'.edit', compact('receiveItem', 'purchaseOrders', 'products', 'units'));
    }

    public function update(Request $request, string $id)
    {
        $receiveItem = ReceiveItem::findOrFail($id);

        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'code' => 'nullable|unique:receive_items,code,'.$id,
            'trx_date' => 'required|date',
            'description' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Draft,Quotation,Confirmed,Done',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.received' => 'required|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.paid' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0',
            'items.*.tax_value' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();

        $receiveItem->update($validated);

        $receiveItem->receiveItemDetails()->delete();

        foreach ($request->items as $item) {
            $receiveItem->receiveItemDetails()->create([
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],
                'quantity' => $item['quantity'],
                'received' => $item['received'],
                'price' => $item['price'],
                'paid' => $item['paid'],
                'subtotal' => $item['subtotal'],
                'tax' => $item['tax'] ?? 0,
                'tax_value' => $item['tax_value'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('receive-items.index')->with('success', 'Receive Item updated successfully!');
    }

    public function destroy(string $id)
    {
        $receiveItem = ReceiveItem::findOrFail($id);

        $receiveItem->receiveItemDetails()->delete();

        $receiveItem->delete();

        return redirect()->route('receive-items.index')->with('success', 'Receive Item deleted successfully!');
    }
}
