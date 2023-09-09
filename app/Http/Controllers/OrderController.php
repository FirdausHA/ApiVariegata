<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'qty' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'addresses_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = Order::create([
            'qty' => $request->qty,
            'total_price' => $request->total_price,
            'status' => 'Belum Bayar',
            'addresses_id' => $request->addresses_id,
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $randomNumber = rand(1000, 9999);

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . $randomNumber,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $request->name,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'message' => 'Snap token obtained successfully',
                'snapToken' => $snapToken,
                'clientKey' => 'SB-Mid-client-XsUvkW0DyXiyhOcl',
                'serverKey' => 'SB-Mid-server-NIduoNcz-aZq3WjE8BXL3eBY'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error obtaining snap token',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function callback (Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        if ($hashed !== $request->signature_key) {
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 400);
        }

        if ($request->status_code == '200'){
            $order->update([
                'status' => 'Sudah Bayar'
            ]);
        } else {
            $order->update([
                'status' => 'Belum Bayar'
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Callback processed successfully']);
    }


    public function userTransactions(Request $request)
    {
        // Memeriksa apakah pengguna sudah terotentikasi
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User is not authenticated',
            ], 401);
        }

        $user = Auth::user();

        $transactions = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->has('id')) {
            $order = Order::find($request->id);
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found',
                ], 404);
            }
            return view('invoice', compact('order', 'transactions'));
        }

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ], 200);
    }
}
