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
    // public function index()
    // {
    //     return view('home');
    // }

    // public function checkout(Request $request)
    // {
    //     // Pastikan pengguna telah login
    //     if (Auth::check()) {
    //         // Dapatkan data pengguna saat ini
    //         $user = Auth::user();

    //         // Dapatkan data produk dari database berdasarkan ID produk yang dipilih
    //         $product = Product::find($request->product_id);

    //         // Pastikan produk ditemukan di database
    //         if (!$product) {
    //             return redirect()->back()->with('error', 'Produk tidak ditemukan');
    //         }

    //         // Menghitung total harga berdasarkan kuantitas produk dan harga produk
    //         $totalPrice = $request->qty * $product->price;

    //         // Menambahkan informasi total harga dan status ke dalam request
    //         $request->merge([
    //             'total_price' => $totalPrice,
    //             'status' => 'Unpaid',
    //             'user_id' => $user->id,
    //             'product_id' => $product->id,
    //         ]);

    //         // Membuat pesanan baru berdasarkan request yang telah diupdate
    //         $order = Order::create($request->all());

    //         // Konfigurasi Midtrans
    //         Config::$serverKey = config('midtrans.server_key');
    //         Config::$isProduction = false;
    //         Config::$isSanitized = true;
    //         Config::$is3ds = true;

    //         $randomNumber = rand(1000, 9999);

    //         $params = array(
    //             'transaction_details' => array(
    //                 'order_id' => $order->id . '-' . $randomNumber,
    //                 'gross_amount' => $order->total_price,
    //             ),
    //             'customer_details' => array(
    //                 'first_name' => $user->name, // Menggunakan nama pengguna saat ini
    //                 'phone' => $user->phone, // Menggunakan nomor telepon pengguna saat ini
    //             ),
    //         );

    //         $snapToken = Snap::getSnapToken($params);
    //         return view('checkout', compact('snapToken', 'order'));
    //     } else {
    //         // Pengguna belum login, alihkan mereka ke halaman login atau lakukan tindakan lain yang sesuai.
    //         return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk melanjutkan.');
    //     }
    // }

    // public function index($id)
    // {
    //     $product = product::where('id', $id)->first();

    //     return view('home',[
    //         'product' => $product
    //     ]);
    // }

    // public function checkout(Request $request)
    // {
    //     $request->request->add(['total_price' => $request->qty * $request->harga_kos, 'status' => 'Unpaid']);
    //     $order = Order::create($request->all());

    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$isProduction = false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $randomNumber = rand(1000, 9999);

    //     $params = array(
    //         'transaction_details' => array(
    //             'order_id' => $order->id . '-' . $randomNumber,
    //             'gross_amount' => $order->total_price,
    //         ),
    //         'customer_details' => array(
    //             'first_name' => $request->name,
    //             'phone' => $request->phone,
    //         ),
    //     );

    //     $snapToken = Snap::getSnapToken($params);
    //     return view('checkout', compact('snapToken', 'order'));
    // }
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'qty' => ['required', 'integer', 'min:1'],
            'harga_kos' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        $totalPrice = $request->qty * $request->harga_kos;

        $order = Order::create([
            'total_price' => $totalPrice,
            'status' => 'Belum Bayar',
            'user_id' => $user->id, // Assuming you're using user authentication
            'product_id' => $request->product_id,
            'name' => $request->name,
            'harga_kos' => $request->harga_kos,
            'tipe_kamar' => $request->tipe_kamar,
            'phone' => $request->phone,
            'qty' => $request->qty,
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $randomNumber = rand(1000, 9999);

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . $randomNumber,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'phone' => $request->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'message' => 'Snap token obtained successfully',
                'snapToken' => $snapToken,
                'clientKey'=>'SB-Mid-client-Mkh96hcK0ChFAs2J',
                'serverKey'=> 'SB-Mid-server-B1b_50vqIDw_xQ_IYN4bkjl0'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error obtaining snap token',
                'error' => $th->getMessage(),
            ],500);
        }
    }

        public function callback(Request $request)
        {
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
            if ($hashed == $request->signature_key) {
                if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement' ) {
                    $order = Order::find($request->order_id);
                    $order->update(['status' => 'Sudah Bayar']);
                    return redirect()->away('https://bukos.my.id/finish');
                }
            }
        }
        public function userTransactions()
        {
            $user = Auth::user();

            $transactions = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'transactions' => $transactions,
            ], 200);
        }
        public function invoice($id){
            $order = Order::find($id);
            return view('invoice', compact('order'));
        }
}
