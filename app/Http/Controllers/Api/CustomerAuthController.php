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

        $phone = $this->normalizePhone($request->phone);

        $customers = DB::table('customer')->get();

        $customer = $customers->first(function ($c) use ($phone) {

            return $this->normalizePhone($c->telp) == $phone;
        });

        if (!$customer) {

            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 401);
        }

        $order = DB::table('order')
            ->join('customer', 'customer.id', '=', 'order.customer_id')
            ->where('order.customer_id', $customer->id)
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

    private function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }

        if (substr($phone, 0, 2) != '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
