<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return response()->json($contents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'week' => 'required|string',
            'description' => 'required|string',
            'title' => 'required|string',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $content = new Content();
            $content->name = $request->input('name');
            $content->title = $request->input('title');
            $content->description = $request->input('description');
            $content->week = $request->input('week');
            $content->stage_id = $request->input('stage_id');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $content->image = $imagePath;
            }

            $content->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $content = Content::findOrFail($id);
        return response()->json($content);
    }

    public function getByCategory($stage_id)
    {
        $contents = Content::where('stage_id', $stage_id)->get();
        return response()->json($contents);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'week' => 'required|string',
            'description' => 'required|string',
            'title' => 'required|string',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $content = Content::findOrFail($id);
            $content->name = $request->input('name');
            $content->title = $request->input('title');
            $content->description = $request->input('description');
            $content->week = $request->input('week');
            $content->stage_id = $request->input('stage_id');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($content->image) {
                    Storage::disk('public')->delete($content->image);
                }

                $imagePath = $request->file('image')->store('product_images', 'public');
                $content->image = $imagePath;
            }

            $content->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return response()->json(null, 204);
    }
}
