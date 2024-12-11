<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $pathView = 'units';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $data = Unit::where(function($q)use($search){
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

        Unit::create($fields);

        return $this->redirectIndex();
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'string'
        ]);

        $unit->update($fields);

        return $this->redirectIndex();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ids)
    {
        $ids = explode(',', $ids);

        Unit::whereIn('id', $ids)->delete();

        return $this->redirectIndex('Data deleted successfully!');
    }

    protected function redirectIndex($message = 'Data saved successfully!')
    {
        toast($message, 'success');
        return redirect()->route($this->pathView.'.index');
    }
}
