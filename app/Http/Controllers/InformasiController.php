<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $informasis = Informasi::all();
        return response()->json($informasis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $informasi = new Informasi();
            $informasi->name = $request->input('name');
            $informasi->description = $request->input('description');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $informasi->image = $imagePath;
            }

            $informasi->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $informasi = Informasi::findOrFail($id);
        return response()->json($informasi);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $informasi = Informasi::findOrFail($id);
            $informasi->name = $request->input('name');
            $informasi->description = $request->input('description');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                // if ($product->image) {
                //     Storage::disk('public')->delete($product->image);
                // }

                $imagePath = $request->file('image')->store('product_images', 'public');
                $informasi->image = $imagePath;
            }

            $informasi->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();
        return response()->json(null, 204);
    }
}
