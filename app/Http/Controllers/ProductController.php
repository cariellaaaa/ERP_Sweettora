<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $pathView = 'products';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $listView = $request->view ?? '';

        $data = Product::where(function($q)use($search){
            if(isset($search)){
                $q->where('name', 'like', "%$search%");
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
        $categories = ProductCategory::all();
        $vendors = Vendor::all();
        $units = Unit::all();
        return view($this->pathView.'.create', compact('categories', 'vendors', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request;
        $data['cost'] = clearCurrency($request->cost);
        $data['price'] = clearCurrency($request->price);

        $fields = $data->validate([
            'code' => 'nullable|string|unique:products,code',
            'name' => 'required|string|max:150',
            'type' => 'required|in:raw,product',
            'product_category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:units,id',
            'tags' => 'nullable|string',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5128'
        ]);
        
        
        if(!isset($request->code)){
            $code = strtoupper(uniqid());
            $fields['code'] = $code;
        }
        
        $fields['barcode'] = $code;

        $product = Product::create($fields);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
            $product->save();
        }

        return $this->redirectIndex();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $vendors = Vendor::all();
        $units = Unit::all();
        return view($this->pathView.'.edit', compact('categories', 'vendors', 'units', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $fields = $request->validate([
            'code' => ['nullable','string', Rule::unique('products')->ignore($product->id)],
            'name' => 'required|string|max:150',
            'type' => 'required|in:raw,product',
            'product_category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:units,id',
            'tags' => 'nullable|string',
            'cost' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5128'
        ]);

        $fields['cost'] = clearCurrency($request->cost);
        $fields['price'] = clearCurrency($request->price);
        
        if(!isset($request->code)){
            $code = strtoupper(uniqid());
            $fields['code'] = $code;
        }
        
        $fields['barcode'] = $code ?? $product->code;

        $product->update($fields);

        if($request->hasFile('image')){
            
            if(Storage::fileExists($product->image)){
                Storage::unlink($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
            $product->save();
        }

        return $this->redirectIndex();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    protected function redirectIndex($message = 'Data saved successfully!')
    {
        toast($message, 'success');
        return redirect()->route($this->pathView.'.index');
    }
}
