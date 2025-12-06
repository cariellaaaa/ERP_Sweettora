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
        return view('bom.index', compact('boms'));
    }

    public function create()
    {
        $products = Product::all();
        return view('bom.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'reference' => 'required',
            'name' => 'required',
            'quantity' => 'required|numeric|min:1',
            'cost' => 'required|numeric',
        ]);

        BillOfMaterial::create([
            'product_id' => $request->product_id,
            'company_id' => auth()->user()->company_id ?? 1, 
            'user_id' => auth()->id(),
            'reference' => $request->reference,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'cost' => $request->cost,
            'total' => $request->quantity * $request->cost,
        ]);

        return redirect()->route('bill-of-materials.index')->with('success', 'BOM successfully created.');
    }

    public function edit(BillOfMaterial $bom)
    {
        return view('bom.edit', compact('bom'));
    }

    public function show($id)
    {
    $billOfMaterial = BillOfMaterial::findOrFail($id);

    return view('bill-of-materials.show', compact('billOfMaterial'));
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