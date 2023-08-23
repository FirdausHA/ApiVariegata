<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Snap;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Notification;

class TransactionController extends Controller
{
    public function requestPayment(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'total_amount' => 'required|numeric|min:1',
        ]);

        try {
            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(), // Generate unique order number
                'total_amount' => $request->total_amount,
            ]);

            // Midtrans configuration
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Create payment request to Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => request('total_amount'),
                ],
                'customer_details' => [
                    'first_name' => $user->name, // Use user's name
                    'email' => $user->email,    // Use user's email
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }

    // Rest of the controller methods...

    // Generate unique order number
    private function generateOrderNumber() {
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $orderNumber = $lastOrder ? $lastOrder->id + 1 : 1;
        return 'ORDER-' . str_pad($orderNumber, 5, '0', STR_PAD_LEFT);
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
