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

            ->where('order.status', '!=', 'CANCEL')

            ->whereNotNull('order.spk')
            ->where('order.spk', '!=', '')

            ->orderByDesc('order.id')
            ->select(
                'order.id',
                'order.tgl_app_cs',
                'order.spk',
                'order.nama_produk',
                'order.status',
                'order.statusm',
                'order.qty',
                'order.produk',
                'order.capture',
                'customer.nama as customer_nama'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders->map(function ($order) {

                $order->capture = $order->capture
                    ? 'https://erp.smartone.id/' . ltrim($order->capture, '/')
                    : null;

                return $order;
            })
        ]);
    }

    public function show($id)
    {
        $order = DB::table('order')
            ->join('customer', 'customer.id', '=', 'order.customer_id')
            ->where('order.id', $id)
            ->select(
                'order.id',
                'order.tgl_app_cs',
                'order.spk',
                'order.nama_produk',
                'order.status',
                'order.statusm',
                'order.qty',
                'order.produk',
                'order.capture',
                'customer.nama as customer_nama'
            )
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false
            ], 404);
        }

        $order->capture = $order->capture
            ? 'https://erp.smartone.id/' . ltrim($order->capture, '/')
            : null;

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }
}
