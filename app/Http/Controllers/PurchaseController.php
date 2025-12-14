<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $pathView = 'purchase-orders';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $listView = $request->view ?? '';

        $data = PurchaseOrder::with('vendor')->where(function ($q) use ($search) {
            if (isset($search)) {
                $q->where('code', 'like', "%$search%");
            }
        })->paginate(20)->appends(['search' => $search]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search', 'listView'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::all();
        $products = Product::all();
        $units = Unit::all();

        return view($this->pathView.'.create', compact('vendors', 'products', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:purchase_orders,code',
            'vendor_id' => 'required|exists:vendors,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Draft,Quotation,Confirmed,Done',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.tax' => 'required|numeric|min:0',
        ]);

        $code = $validated['code'] ?? 'PO-'.date('Ymd').'-'.str_pad(PurchaseOrder::count() + 1, 4, '0', STR_PAD_LEFT);

        $purchaseOrder = PurchaseOrder::create([
            'user_id' => auth()->id(),
            'code' => $code,
            'vendor_id' => $validated['vendor_id'],
            'total' => $validated['total'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            $subtotal = $item['quantity'] * $product->price;
            $taxValue = $subtotal * ($item['tax'] / 100);
            $itemTotal = $subtotal + $taxValue;

            PurchaseOrderDetail::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
                'tax' => $item['tax'],
                'tax_value' => $taxValue,
                'total' => $itemTotal,
            ]);
        }

        return redirect()
            ->route($this->pathView.'.index')
            ->with('success', 'Purchase Order berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendors = Vendor::all();
        $products = Product::all();
        $units = Unit::all();
        $purchaseOrder = PurchaseOrder::with('details.product', 'details.unit')->findOrFail($id);
        $orderItems = $purchaseOrder->details->map(function ($detail) {
            return [
                'product_id' => $detail->product_id,
                'product_name' => $detail->product->name ?? 'Unknown Product',
                'unit_id' => $detail->unit_id,
                'unit_name' => $detail->unit->name ?? 'Unknown Unit',
                'quantity' => $detail->quantity,
                'tax' => $detail->tax ?? 0,
            ];
        })->toArray();

        return view($this->pathView.'.edit', compact('vendors', 'products', 'units', 'purchaseOrder', 'orderItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|unique:purchase_orders,code,'.$purchaseOrder->id,
            'vendor_id' => 'required|exists:vendors,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:Draft,Quotation,Confirmed,Done',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.tax' => 'required|numeric|min:0',
        ]);

        $code = $validated['code'] ?? $purchaseOrder->code;

        $purchaseOrder->update([
            'code' => $code,
            'vendor_id' => $validated['vendor_id'],
            'total' => $validated['total'],
            'status' => $validated['status'],
            'description' => $validated['description'] ?? null,
        ]);

        $purchaseOrder->details()->delete();

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $subtotal = $item['quantity'] * $product->price;
            $taxValue = $subtotal * ($item['tax'] / 100);

            $purchaseOrder->details()->create([
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
                'tax' => $item['tax'],
                'tax_value' => $taxValue,
                'total' => $subtotal + $taxValue,
            ]);
        }

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();

        return redirect()->route($this->pathView.'.index')->with('success', 'Purchase Order berhasil dihapus');
    }
}
