<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $cartItem = new Cart([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
            ]);

            $cartItem->save();

            return response()->json(['message' => 'Product added to cart successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add product to cart'], 500);
        }
    }

    public function removeFromCart($cartItemId)
    {
        try {
            $cartItem = Cart::findOrFail($cartItemId);
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
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();

            return response()->json(['message' => 'Cart item updated successfully']);
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
