<?php

namespace App\Http\Controllers;

use App\Models\BillOfMaterial;
use App\Models\BomItem;
use App\Models\ManufacturingOrder;
use App\Models\ManufacturingOrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class ManufacturingOrderController extends Controller
{
    public function index()
    {
        $orders = ManufacturingOrder::with('product', 'billOfMaterial')->latest()->get();
        return view('manufacturing_order.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        $boms = BillOfMaterial::with('product')->get();

        return view('manufacturing_order.create', compact('products', 'boms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'bill_of_material_id' => 'required',
            'quantity' => 'required|numeric',
        ]);

        // ---- CREATE MO (HEADER) ----
        $mo = ManufacturingOrder::create([
            'product_id' => $request->product_id,
            'bill_of_material_id' => $request->bill_of_material_id,
            'user_id' => auth()->id(),
            'company_id' => 1,
            'schedule' => now(),
            'quantity' => $request->quantity,
            'total' => 0,
            'status' => 'Draft',
        ]);

        // ---- GET BOM ITEMS ----
        $bomItems = BomItem::where('bill_of_material_id', $request->bill_of_material_id)->get();

        $totalCost = 0;

        foreach ($bomItems as $item) {
            $requirements = $item->quantity * $request->quantity; // Odoo style

            ManufacturingOrderDetail::create([
                'manufacturing_order_id' => $mo->id,
                'product_id' => $item->product_id,
                'unit_id' => $item->product->unit_id,
                'requirements' => $requirements,
                'consumed' => $requirements,
            ]);

            // total cost formula
            $totalCost += $requirements * $item->cost;
        }

        // UPDATE TOTAL COST
        $mo->update(['total' => $totalCost]);

        return redirect()->route('manufacturing-order.index')
            ->with('success', 'Manufacturing Order created successfully!');
    }
    public function show($id)
    {
        $mo = ManufacturingOrder::with([
            'product',
            'billOfMaterial',
            'details.product',
            'details.unit',
            'user',
        ])->findOrFail($id);

        return view('manufacturing_order.show', compact('mo'));
    }

}