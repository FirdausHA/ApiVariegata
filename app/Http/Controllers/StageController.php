<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::all();
        return response()->json($stages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subtitle' => 'required|string',
            'color' => 'required|string',
            'plant_id' => 'required|exists:plants,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $stage = new Stage();
            $stage->name = $request->input('name');
            $stage->subtitle = $request->input('subtitle');
            $stage->color = $request->input('color');
            $stage->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $stage->image = $imagePath;
            }

            $stage->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $stage = Stage::findOrFail($id);
        return response()->json($stage);
    }

    public function getByCategory($plant_id)
    {
        $hamas = Stage::where('plant_id', $plant_id)->get();
        return response()->json($hamas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'subtitle' => 'required|string',
            'color' => 'required|string',
            'plant_id' => 'required|exists:plants,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $stage = Stage::findOrFail($id);
            $stage->name = $request->input('name');
            $stage->subtitle = $request->input('subtitle');
            $stage->color = $request->input('color');
            $stage->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                // if ($product->image) {
                //     Storage::disk('public')->delete($product->image);
                // }

                $imagePath = $request->file('image')->store('product_images', 'public');
                $stage->image = $imagePath;
            }

            $stage->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();
        return response()->json(null, 204);
    }
}
