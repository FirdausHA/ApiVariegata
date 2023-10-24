<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewProduct;
use Illuminate\Support\Facades\Auth;

class ReviewProductController extends Controller
{
    public function index()
    {
        $reviews = ReviewProduct::all();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = ReviewProduct::create([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'user_id' => $user->id, // Tambahkan kolom 'user_id' dengan nilai id pengguna saat ini.
        ]);

        return response()->json(['message' => 'Review added successfully', 'review' => $review]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $review = ReviewProduct::findOrFail($id);

        if ($user->id !== $review->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review->update([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json(['message' => 'Review updated successfully', 'review' => $review]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $review = ReviewProduct::findOrFail($id);

        if ($user->id !== $review->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
