<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Product;
use Midtrans\Config;
use App\Models\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class TransactionController extends Controller
{
    public function requestPayment(Request $request)
    {

        $request->validate([
            'total_amount' => 'required|numeric',
        ]);

        // try {
            // Create order
            $order = Order::create([
                'total_amount' => request('total_amount'),
            ]);

            // Midtrans configuration
            Config::$serverKey = "SB-Mid-server-NIduoNcz-aZq3WjE8BXL3eBY";
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Create payment request to Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => "user",
                    'email' => 'user1@gmail.com',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json(['snap_token' => $snapToken, 'client_key' => "SB-Mid-client-XsUvkW0DyXiyhOcl"]);
    }

    public function paymentCallback(Request $request)
    {
        $notification = new Notification();

        // Get order number from the callback data
        $orderNumber = $notification->order_id;

        // Find the order
        $order = Order::where('order_number', $orderNumber)->first();

        if ($order) {
            if ($notification->transaction_status == 'capture') {
                // Payment is successful and captured
                // Update order status to paid or completed
                $order->update([
                    'status' => 'paid' // or 'completed', based on your business logic
                ]);

                // Perform other tasks here, like sending email, updating inventory, etc.
            } elseif ($notification->transaction_status == 'settlement') {
                // Payment is settled (completed)
                // Update order status to completed
                $order->update([
                    'status' => 'completed'
                ]);

                // Perform other tasks here
            } elseif ($notification->transaction_status == 'cancel') {
                // Payment is canceled
                // Update order status to canceled
                $order->update([
                    'status' => 'canceled'
                ]);

                // Perform other tasks here
            } elseif ($notification->transaction_status == 'deny') {
                // Payment is denied
                // Update order status to denied
                $order->update([
                    'status' => 'denied'
                ]);

                // Perform other tasks here
            } else {
                // Other transaction statuses
                // Handle accordingly based on your business logic
            }
        }

        return response()->json(['message' => 'Payment callback received']);
    }
}
