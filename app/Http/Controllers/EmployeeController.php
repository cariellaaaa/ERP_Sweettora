<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class EmployeeController extends Controller
{
    protected $pathView = 'employees';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $department = $request->department;

        $data = Employee::where(function ($q) use ($search, $status, $department) {
            if (isset($search)) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('employee_code', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('position', 'like', "%$search%");
            }
            if (isset($status)) {
                $q->where('status', $status);
            }
            if (isset($department)) {
                $q->where('department', 'like', "%$department%");
            }
        })->orderBy('created_at', 'desc')->paginate(20)->appends([
            'search' => $search,
            'status' => $status,
            'department' => $department,
        ]);

        $title = 'Delete';
        $text = 'Are you sure want to delete selected data?';
        confirmDelete($title, $text);

        return view($this->pathView.'.index', compact('data', 'search', 'status', 'department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::all();
        $city = City::all();
        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $nextId = $lastEmployee ? $lastEmployee->id + 1 : 1;
        $employeeCode = 'EMP'.str_pad($nextId, 5, '0', STR_PAD_LEFT);
        return view($this->pathView.'.create', compact('province', 'city', 'employeeCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'postal_code' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_status' => 'nullable|in:permanent,contract,internship,probation',
            'status' => 'nullable|in:active,inactive,terminated',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees');
        }

        Employee::create($data);

        return redirect()->route($this->pathView.'.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Employee::with(['province', 'city'])->findOrFail($id);

        return view($this->pathView.'.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Employee::findOrFail($id);
        $province = Province::all();
        $city = City::all();

        return view($this->pathView.'.edit', compact('data', 'province', 'city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'employee_code' => 'required|unique:employees,employee_code,'.$id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'province_id' => 'nullable',
            'city_id' => 'nullable',
            'postal_code' => 'nullable|integer',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_status' => 'nullable|in:permanent,contract,internship,probation',
            'status' => 'nullable|in:active,inactive,terminated',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees');
        }

        Employee::updateOrCreate(['id' => $id], $data);

        return redirect()->route($this->pathView.'.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Employee::findOrFail($id);
        $data->delete();

        return redirect()->route($this->pathView.'.index')->with('success', 'Employee deleted successfully');
    }
}
