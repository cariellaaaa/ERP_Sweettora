<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{
    protected $pathView = 'inventories';

    public function index(Request $request)
    {
        $search = $request->search;
        $warehouse_id = $request->warehouse_id;
        $status = $request->status;

        $data = Inventory::with(['product', 'warehouse'])
            ->where(function ($q) use ($search) {
                if (isset($search)) {
                    $q->whereHas('product', function($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })->orWhere('batch_number', 'like', "%$search%");
                }
            })
            ->when($warehouse_id, function($q) use ($warehouse_id) {
                $q->where('warehouse_id', $warehouse_id);
            })
            ->when($status, function($q) use ($status) {
                $q->where('status', $status);
            })
            ->paginate(20)
            ->appends(['search' => $search, 'warehouse_id' => $warehouse_id, 'status' => $status]);

        $warehouses = Warehouse::where('status', 'Active')->get();

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search', 'warehouses', 'warehouse_id', 'status'));
    }

    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::where('status', 'Active')->get();
        return view($this->pathView.'.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'batch_number' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'reserved' => 'nullable|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'location' => 'nullable|string',
            'reorder_level' => 'nullable|numeric|min:0',
            'max_stock' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive,Expired,Damaged',
            'notes' => 'nullable|string',
        ]);

        $validated['reserved'] = $validated['reserved'] ?? 0;
        $validated['available'] = $validated['quantity'] - $validated['reserved'];
        $validated['total_value'] = $validated['quantity'] * $validated['unit_cost'];

        Inventory::create($validated);

        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully!');
    }

    public function edit(string $id)
    {
        $inventory = Inventory::with(['product', 'warehouse'])->findOrFail($id);
        $products = Product::all();
        $warehouses = Warehouse::where('status', 'Active')->get();
        return view($this->pathView.'.edit', compact('inventory', 'products', 'warehouses'));
    }

    public function update(Request $request, string $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'batch_number' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'reserved' => 'nullable|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'location' => 'nullable|string',
            'reorder_level' => 'nullable|numeric|min:0',
            'max_stock' => 'nullable|numeric|min:0',
            'status' => 'required|in:Active,Inactive,Expired,Damaged',
            'notes' => 'nullable|string',
        ]);

        $validated['reserved'] = $validated['reserved'] ?? 0;
        $validated['available'] = $validated['quantity'] - $validated['reserved'];
        $validated['total_value'] = $validated['quantity'] * $validated['unit_cost'];

        $inventory->update($validated);

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully!');
    }

    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully!');
    }
}
