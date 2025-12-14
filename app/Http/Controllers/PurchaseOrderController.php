<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'tax' => 'required',
            'tax_value' => 'required',
        ]);
    }
}
