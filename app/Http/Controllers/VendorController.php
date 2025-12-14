<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;

class VendorController extends Controller
{
    protected $pathView = 'vendors';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $listView = $request->view ?? '';

        $data = Vendor::where(function ($q) use ($search) {
            if (isset($search)) {
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
        $country = Country::all();
        $province = Province::all();
        $city = City::all();
        $district = District::all();
        return view($this->pathView.'.create', compact('country', 'province', 'city', 'district'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'npwp' => 'required',
            'address' => 'required',
            'image' => 'required',
        ]);

        $data = $request->all();
        $data['image'] = $request->file('image')->store('vendor');
        Vendor::create($data);
        return redirect()->route($this->pathView.'.index')->with('success', 'Vendor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Vendor::findOrFail($id);
        return view($this->pathView.'.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Vendor::findOrFail($id);
        $province = Province::all();
        $city = City::all();
        return view($this->pathView.'.edit', compact('data', 'province', 'city',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'npwp' => 'required',
            'address' => 'required',
            'image' => 'nullable',
        ]);

        $data = $request->all();
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('vendor');
        }
        Vendor::updateOrCreate(['id' => $id], $data);
        return redirect()->route($this->pathView.'.index')->with('success', 'Vendor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Vendor::findOrFail($id);
        $data->delete();
        return redirect()->route($this->pathView.'.index')->with('success', 'Vendor deleted successfully');
    }
}
