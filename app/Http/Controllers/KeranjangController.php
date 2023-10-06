<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    public function listdata()
    {
        $cartItems = Keranjang::with('product')->get();
        return response()->json($cartItems);
    }

    public function tambahkeranjang(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            $product = Product::findOrFail($request->input('product_id'));

            // Periksa apakah stok mencukupi
            if ($product->stock < $request->input('quantity')) {
                return response()->json(['error' => 'Stok produk tidak mencukupi'], 400);
            }

            // Periksa apakah produk sudah ada dalam keranjang
            $existingCartItem = Keranjang::where('product_id', $product->id)->first();

            if ($existingCartItem) {
                // Jika produk sudah ada dalam keranjang, tambahkan jumlahnya
                $existingCartItem->quantity += $request->input('quantity');
                $existingCartItem->save();
            } else {
                $cartItem = new Keranjang([
                    'product_id' => $product->id,
                    'quantity' => $request->input('quantity'),
                ]);

                $cartItem->save();
            }

            // Kurangkan stok produk
            $product->stock -= $request->input('quantity');
            $product->save();

            return response()->json(['message' => 'Product added to cart successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add product to cart'], 500);
        }
    }

    public function Delete($cartItemId)
    {
        try {
            $cartItem = Keranjang::findOrFail($cartItemId);

            // Kembalikan stok produk yang dihapus dari keranjang
            $product = Product::find($cartItem->product_id);
            $product->stock += $cartItem->quantity;
            $product->save();

            $cartItem->delete();

            return response()->json(['message' => 'Product removed from cart successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove product from cart'], 500);
        }
    }

    public function updateCartItem(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            $cartItem = Keranjang::findOrFail($cartItemId);
            $originalQuantity = $cartItem->quantity;

            // Mengembalikan stok produk yang diupdate ke stok produk yang asli
            $product = Product::find($cartItem->product_id);
            $product->stock += $originalQuantity;
            $product->save();

            // Update jumlah item dalam keranjang
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();

            // Kurangkan stok produk sesuai dengan jumlah yang baru
            if ($product->stock >= $request->input('quantity')) {
                $product->stock -= $request->input('quantity');
                $product->save();

                return response()->json(['message' => 'Cart item updated successfully']);
            } else {
                // Jika stok tidak mencukupi, kembalikan stok produk ke jumlah asli
                $product->stock += $request->input('quantity');
                $product->save();

                return response()->json(['error' => 'Stok produk tidak mencukupi'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update cart item'], 500);
        }
    }

    public function calculateTotalPrice()
    {
        $cartItems = Keranjang::all();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->product->price;
        }

        return response()->json(['total_price' => $totalPrice]);
    }
}
