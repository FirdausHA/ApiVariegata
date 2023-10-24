<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->get();
        return response()->json($cartItems);
    }

    public function addToCart(Request $request)
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
            $existingCartItem = Cart::where('product_id', $product->id)->first();

            if ($existingCartItem) {
                // Jika produk sudah ada dalam keranjang, tambahkan jumlahnya
                $existingCartItem->quantity += $request->input('quantity');
                $existingCartItem->save();
            } else {
                $cartItem = new Cart([
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

    public function removeFromCart($cartItemId)
    {
        try {
            $cartItem = Cart::findOrFail($cartItemId);

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
            $cartItem = Cart::findOrFail($cartItemId);
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
        $cartItems = Cart::all();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->product->price;
        }

        return response()->json(['total_price' => $totalPrice]);
    }
}
