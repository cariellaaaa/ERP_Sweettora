<?php

namespace App\Http\Controllers;

use App\Models\BillOfMaterial;
use App\Models\Product;
use Illuminate\Http\Request;

class BillOfMaterialController extends Controller
{
    public function index()
    {
        $boms = BillOfMaterial::with('product')->latest()->paginate(10);
        return view('bill-of-materials.index', compact('boms'));
    }

    public function create()
    {
        $products = Product::all();
        return view('bill-of-materials.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'reference' => 'required',
            'name' => 'required',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.cost' => 'required|numeric',
        ]);

        // 1️⃣ Create BOM Header
        $bom = BillOfMaterial::create([
            'product_id' => $request->product_id,
            'company_id' => auth()->user()->company_id ?? 1,
            'user_id' => auth()->id(),
            'reference' => $request->reference,
            'name' => $request->name,
            'quantity' => 1, // quantity sudah ditentukan per item
            'cost' => 0, // dihitung total dari items
            'total' => 0,
        ]);

        $totalCost = 0;

        // 2️⃣ Create BOM Items (Rows)
        foreach ($request->items as $item) {
            $lineTotal = $item['quantity'] * $item['cost'];
            $totalCost += $lineTotal;

            $bom->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'total' => $lineTotal,
            ]);
        }

        // 3️⃣ Update total cost di BOM Header
        $bom->update([
            'cost' => $totalCost,
            'total' => $totalCost,
        ]);

        return redirect()->route('bill-of-materials.index')->with('success', 'BOM successfully created with components.');
    }


    public function edit(BillOfMaterial $bom)
    {
        return view('bill-of-materials.edit', compact('bom'));
    }

    public function show($id)
    {
        $bom = BillOfMaterial::with('product')->findOrFail($id);
        return view('bill-of-materials.show', compact('bom'));
    }

    public function update(Request $request, BillOfMaterial $bom)
    {
        $request->validate([
            'reference' => 'required',
            'name' => 'required',
            'quantity' => 'required|numeric|min:1',
            'cost' => 'required|numeric',
        ]);

        $bom->update([
            'reference' => $request->reference,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'cost' => $request->cost,
            'total' => $request->quantity * $request->cost,
        ]);

        return redirect()->route('bill-of-materials.index')->with('success', 'BOM updated successfully.');
    }

    public function destroy(BillOfMaterial $bom)
    {
        $bom->delete();
        return redirect()->route('bill-of-materials.index')->with('success', 'BOM deleted.');
    }
}