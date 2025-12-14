<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class WarehousesController extends Controller
{
    protected $pathView = 'warehouses';

    public function index(Request $request)
    {
        $search = $request->search;

        $data = Warehouse::where(function ($q) use ($search) {
            if (isset($search)) {
                $q->where('code', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%");
            }
        })->paginate(20)->appends(['search' => $search]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view($this->pathView.'.create', compact('provinces', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:warehouses,code',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'manager_name' => 'nullable|string',
            'capacity' => 'nullable|numeric',
            'status' => 'required|in:Active,Inactive,Maintenance',
            'description' => 'nullable|string',
        ]);

        Warehouse::create($validated);

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully!');
    }

    public function edit(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $provinces = Province::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view($this->pathView.'.edit', compact('warehouse', 'provinces', 'cities'));
    }

    public function update(Request $request, string $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:warehouses,code,'.$id,
            'name' => 'required|string|max:255',
            'type' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'manager_name' => 'nullable|string',
            'capacity' => 'nullable|numeric',
            'status' => 'required|in:Active,Inactive,Maintenance',
            'description' => 'nullable|string',
        ]);

        $warehouse->update($validated);

        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully!');
    }

    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully!');
    }

    public function getCities($provinceCode)
    {
        $cities = City::where('province_code', $provinceCode)->orderBy('name')->get();

        return response()->json($cities);
    }
}
