<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index($customerId)
    {
        $orders = DB::table('order')
            ->join('customer', 'customer.id', '=', 'order.customer_id')
            ->where('order.customer_id', $customerId)
            ->orderByDesc('order.id')
            ->select(
                'order.id',
                'order.tgl_app_cs',
                'order.spk',
                'order.nama_produk',
                'order.status',
                'order.qty',
                'order.produk',
                'order.capture',
                'customer.nama as customer_nama'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}