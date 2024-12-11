<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $pathView = 'product-categories';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $data = ProductCategory::where(function($q)use($search){
            if(isset($search)){
                $q->where('name', 'like', "%$search%");
            }
        })->paginate(20)->appends(['search' => $search]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'string'
        ]);

        ProductCategory::create($fields);

        return $this->redirectIndex();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'string'
        ]);

        $productCategory->update($fields);

        return $this->redirectIndex();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ids)
    {
        $ids = explode(',', $ids);

        ProductCategory::whereIn('id', $ids)->delete();

        return $this->redirectIndex('Data deleted successfully!');
    }

    protected function redirectIndex($message = 'Data saved successfully!')
    {
        toast($message, 'success');
        return redirect()->route($this->pathView.'.index');
    }
}
