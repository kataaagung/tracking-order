<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'spk' => 'required',
        ]);

        $order = DB::table('order')
            ->join('customer', 'customer.id', '=', 'order.customer_id')
            ->where('customer.telp', $request->phone)
            ->where('order.spk', $request->spk)
            ->select(
                'order.id',
                'order.customer_id',
                'order.tgl_app_cs',
                'order.spk',
                'order.nama_produk',
                'order.status',
                'order.qty',
                'order.produk',
                'order.capture',
                'customer.nama as customer_nama'
            )
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'customer_id' => $order->customer_id,
                'tanggal' => $order->tgl_app_cs,
                'spk' => $order->spk,
                'customer' => $order->customer_nama,
                'nama_produk' => $order->nama_produk,
                'status' => $order->status,
                'qty' => $order->qty,
                'produk' => $order->produk,
                'capture' => $order->capture,
            ]
        ]);
    }
}