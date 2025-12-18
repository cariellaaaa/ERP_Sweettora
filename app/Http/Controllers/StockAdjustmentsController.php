<?php

namespace App\Http\Controllers;

use App\Models\StockAdjustment;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockAdjustmentsController extends Controller
{
    protected $pathView = 'stock-adjustments';

    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $data = StockAdjustment::with(['user', 'warehouse'])
            ->where(function ($q) use ($search) {
                if (isset($search)) {
                    $q->where('code', 'like', "%$search%");
                }
            })
            ->when($status, function($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['search' => $search, 'status' => $status]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search', 'status'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('status', 'Active')->get();
        $products = Product::all();
        return view($this->pathView.'.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'code' => 'nullable|unique:stock_adjustments,code',
            'adjustment_date' => 'required|date',
            'adjustment_type' => 'required|in:Increase,Decrease,Damage,Loss,Found,Correction',
            'status' => 'required|in:Draft,Approved,Rejected',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (empty($validated['code'])) {
            $lastAdjustment = StockAdjustment::latest('id')->first();
            $nextNumber = $lastAdjustment ? ((int) substr($lastAdjustment->code, 3)) + 1 : 1;
            $validated['code'] = 'SA-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        $validated['user_id'] = auth()->id();

        $stockAdjustment = StockAdjustment::create($validated);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $stockAdjustment->stockAdjustmentDetails()->create([
                    'product_id' => $item['product_id'],
                    'quantity_before' => $item['quantity_before'],
                    'quantity_adjusted' => $item['quantity_adjusted'],
                    'quantity_after' => $item['quantity_after'],
                    'unit_cost' => $item['unit_cost'] ?? 0,
                    'total_cost' => $item['total_cost'] ?? 0,
                    'batch_number' => $item['batch_number'] ?? null,
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('stock-adjustments.index')->with('success', 'Stock Adjustment created successfully!');
    }

    public function edit(string $id)
    {
        $stockAdjustment = StockAdjustment::with(['stockAdjustmentDetails.product'])->findOrFail($id);
        $warehouses = Warehouse::where('status', 'Active')->get();
        $products = Product::all();
        return view($this->pathView.'.edit', compact('stockAdjustment', 'warehouses', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $stockAdjustment = StockAdjustment::findOrFail($id);

        $validated = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'code' => 'nullable|unique:stock_adjustments,code,' . $id,
            'adjustment_date' => 'required|date',
            'adjustment_type' => 'required|in:Increase,Decrease,Damage,Loss,Found,Correction',
            'status' => 'required|in:Draft,Approved,Rejected',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $stockAdjustment->update($validated);

        $stockAdjustment->stockAdjustmentDetails()->delete();

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $stockAdjustment->stockAdjustmentDetails()->create([
                    'product_id' => $item['product_id'],
                    'quantity_before' => $item['quantity_before'],
                    'quantity_adjusted' => $item['quantity_adjusted'],
                    'quantity_after' => $item['quantity_after'],
                    'unit_cost' => $item['unit_cost'] ?? 0,
                    'total_cost' => $item['total_cost'] ?? 0,
                    'batch_number' => $item['batch_number'] ?? null,
                    'notes' => $item['notes'] ?? null,
                ]);
            }
        }

        return redirect()->route('stock-adjustments.index')->with('success', 'Stock Adjustment updated successfully!');
    }

    public function destroy(string $id)
    {
        $stockAdjustment = StockAdjustment::findOrFail($id);
        $stockAdjustment->stockAdjustmentDetails()->delete();
        $stockAdjustment->delete();

        return redirect()->route('stock-adjustments.index')->with('success', 'Stock Adjustment deleted successfully!');
    }
}
