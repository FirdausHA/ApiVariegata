<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hama;


class HamaController extends Controller
{
    public function index()
    {
        $hamas = Hama::all();
        return response()->json($hamas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'tipe' => 'required|string',
            'description' => 'required|string',
            'cegah' => 'required|string',
            'plant_id' => 'required|exists:plants,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $hama = new Hama();
            $hama->name = $request->input('name');
            $hama->tipe = $request->input('tipe');
            $hama->description = $request->input('description');
            $hama->cegah = $request->input('cegah');
            $hama->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $hama->image = $imagePath;
            }

            $hama->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $hama = Hama::findOrFail($id);
        return response()->json($hama);
    }

    public function getByCategory($category_id)
    {
        $hamas = Hama::where('category_id', $category_id)->get();
        return response()->json($hamas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $hama = Hama::findOrFail($id);
            $hama->name = $request->input('name');
            $hama->description = $request->input('description');
            $hama->price = $request->input('price');
            $hama->category_id = $request->input('category_id');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                // if ($product->image) {
                //     Storage::disk('public')->delete($product->image);
                // }

                $imagePath = $request->file('image')->store('product_images', 'public');
                $product->image = $imagePath;
            }

            $hama->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        $hama = Hama::findOrFail($id);
        $hama->delete();
        return response()->json(null, 204);
    }
}
