<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\SalesOrder;
use App\Models\DeliveryOrderItem;
use Illuminate\Validation\ValidationException;


class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryOrders = DeliveryOrder::with('salesOrder', 'bill')
            ->latest()
            ->get();

        return view('delivery_orders.index', compact('deliveryOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $salesOrder = SalesOrder::with('items.product')
            ->findOrFail($request->sales_order_id);

        return view('delivery_orders.create', compact('salesOrder'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            // 🔹 ambil sales order + items + product
            $salesOrder = SalesOrder::with('items.product')
                ->findOrFail($request->sales_order_id);

            // 🔹 buat Delivery Order
            $deliveryOrder = DeliveryOrder::create([
                'sales_order_id' => $salesOrder->id,
                'do_number'      => 'DO-' . time(),
                'delivery_date'  => now(),
                'status'         => 'pending',
            ]);

            foreach ($request->items as $item) {

                if ($item['quantity'] > 0) {

                    // 🔎 ambil item dari Sales Order
                    $soItem = $salesOrder->items
                        ->firstWhere('product_id', $item['product_id']);

                    if (!$soItem) {
                        throw new \Exception(
                            'Produk tidak ditemukan di Sales Order'
                        );
                    }

                    DeliveryOrderItem::create([
                        'delivery_order_id' => $deliveryOrder->id,
                        'product_id'        => $item['product_id'],
                        'quantity'          => $item['quantity'],
                        'price'             => $soItem->price,
                        'subtotal'          => $item['quantity'] * $soItem->price,
                    ]);
                }
            }
        });

        return redirect()
            ->route('delivery-orders.index')
            ->with('success', 'Delivery Order berhasil dibuat');
    }
    /**
     * Display the specified resource.
     */
    public function show(DeliveryOrder $deliveryOrder)
    {
        $deliveryOrder->load([
            'salesOrder',
            'items.product',
            'bill'
        ]);

        return view('delivery_orders.show', compact('deliveryOrder'));
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

    public function deliver($id)
    {
        $deliveryOrder = DeliveryOrder::with('items.product')->findOrFail($id);

        if ($deliveryOrder->status === 'delivered') {
            return redirect()
                ->route('delivery-orders.index')
                ->with('error', 'Delivery Order sudah delivered');
        }

        // 🔍 CEK STOK DULU (TANPA TRANSACTION)
        foreach ($deliveryOrder->items as $item) {

            $inventory = Inventory::where('product_id', $item->product_id)->first();

            if (!$inventory) {
                return redirect()
                    ->route('delivery-orders.index')
                    ->with('error', 'Stok produk '.$item->product->name.' belum tersedia');
            }

            if ($inventory->quantity < $item->quantity) {
                return redirect()
                    ->route('delivery-orders.index')
                    ->with(
                        'error',
                        'Stok produk '.$item->product->name.
                        ' tidak mencukupi (tersedia '.$inventory->quantity.')'
                    );
            }
        }

        // ✅ BARU TRANSACTION
        DB::transaction(function () use ($deliveryOrder) {

            foreach ($deliveryOrder->items as $item) {

                $inventory = Inventory::where('product_id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                $inventory->quantity -= $item->quantity;
                $inventory->save();
            }

            $deliveryOrder->status = 'delivered';
            $deliveryOrder->save();
        });

        return redirect()
            ->route('delivery-orders.index')
            ->with('success', 'Delivery Order berhasil delivered');
    
    }

}
