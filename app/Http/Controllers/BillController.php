<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('deliveryOrder.salesOrder')
            ->latest()
            ->get();

        return view('bills.index', compact('bills'));
    }

    public function create($deliveryOrderId)
    {
        $deliveryOrder = DeliveryOrder::with('items.product')
            ->findOrFail($deliveryOrderId);

        // 🚫 Cegah kalau belum delivered
        if ($deliveryOrder->status !== 'delivered') {
            return back()->with('error', 'Delivery Order belum delivered');
        }

        // 🚫 Cegah double bill
        if ($deliveryOrder->bill) {
            return back()->with('error', 'Bill sudah dibuat');
        }

        return view('bills.create', compact('deliveryOrder'));
    }

    public function store($deliveryOrderId)
    {
        $deliveryOrder = DeliveryOrder::with('items.product')
            ->findOrFail($deliveryOrderId);

        DB::transaction(function () use ($deliveryOrder) {

            $subtotal = 0;

            foreach ($deliveryOrder->items as $item) {
                $subtotal += $item->quantity * $item->product->price;
            }

            $tax = $subtotal * 0.11;
            $total = $subtotal + $tax;

            Bill::create([
                'bill_number'       => 'BILL-' . time(),
                'delivery_order_id' => $deliveryOrder->id,
                'bill_date'         => now(),
                'due_date'          => now()->addDays(14),
                'subtotal'          => $subtotal,
                'tax'               => $tax,
                'total'             => $total,
                'status'            => 'unpaid',
            ]);
        });

        return redirect()
            ->route('bills.index')
            ->with('success', 'Bill berhasil dibuat');
    }

    public function show($id)
    {
        $bill = Bill::with('deliveryOrder.items.product', 'deliveryOrder.salesOrder')
            ->findOrFail($id);

        return view('bills.show', compact('bill'));
    }
}