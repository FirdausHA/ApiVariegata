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
            'user_name' => 'required|string',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
            'product_id' => 'required|exists:products,id',
        ]);

        $review = ReviewProduct::create([
            'user_name' => $request->input('user_name'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'product_id' => $request->input('product_id'),
        ]);

        return response()->json(['message' => 'Review added successfully', 'review' => $review]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string',
            'comment' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = ReviewProduct::findOrFail($id);
        $review->update([
            'user_name' => $request->input('user_name'),
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
