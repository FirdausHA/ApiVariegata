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
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();
        return response()->json($cartItems);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            $user = Auth::user();
            $product = Product::findOrFail($request->input('product_id'));

            if ($product->stock < $request->input('quantity')) {
                return response()->json(['error' => 'Stok produk tidak mencukupi'], 400);
            }

            $existingCartItem = Cart::where('product_id', $product->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingCartItem) {
                $existingCartItem->quantity += $request->input('quantity');
                $existingCartItem->save();
            } else {
                $cartItem = new Cart([
                    'product_id' => $product->id,
                    'quantity' => $request->input('quantity'),
                    'user_id' => $user->id,
                ]);

                $cartItem->save();
            }

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
            $user = Auth::user();
            $cartItem = Cart::where('user_id', $user->id)->findOrFail($cartItemId);

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
            $user = Auth::user();
            $cartItem = Cart::where('user_id', $user->id)->findOrFail($cartItemId);
            $originalQuantity = $cartItem->quantity;

            $product = Product::find($cartItem->product_id);
            $product->stock += $originalQuantity;
            $product->save();

            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();

            if ($product->stock >= $request->input('quantity')) {
                $product->stock -= $request->input('quantity');
                $product->save();

                return response()->json(['message' => 'Cart item updated successfully']);
            } else {
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
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->product->price;
        }

        return response()->json(['total_price' => $totalPrice]);
    }
}
