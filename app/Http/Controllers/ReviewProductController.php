<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewProduct;

class ReviewProductController extends Controller
{
    public function index()
    {
        $reviews = ReviewProduct::all();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'transaction_code' => 'required|string',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = ReviewProduct::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'transaction_code' => $request->input('transaction_code'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json(['message' => 'Review added successfully', 'review' => $review]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'transaction_code' => 'required|string',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = ReviewProduct::findOrFail($id);
        $review->update([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'transaction_code' => $request->input('transaction_code'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json(['message' => 'Review updated successfully', 'review' => $review]);
    }

    public function destroy($id)
    {
        $review = ReviewProduct::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
