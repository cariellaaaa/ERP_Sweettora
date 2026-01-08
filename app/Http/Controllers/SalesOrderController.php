<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::latest()->get();
        return view('sales_orders.index', compact('salesOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('sales_orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 1️⃣ Simpan Sales Order (HEADER)
            $salesOrder = SalesOrder::create([
                'so_number'     => 'SO-' . time(),
                'order_date'    => now(),
                'customer_name' => $request->customer_name,
                'status'        => 'confirmed',
            ]);

            // 2️⃣ Simpan Items
            foreach ($request->items as $item) {
                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['quantity'] * $item['price'],
                ]);
            }
        });

        return redirect()->route('sales-orders.index')
            ->with('success', 'Sales Order berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
