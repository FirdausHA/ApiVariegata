<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; //
use App\Models\Plant;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::all();
        return response()->json($plants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'scientific' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $plant = new Plant();
            $plant->name = $request->input('name');
            $plant->scientific = $request->input('scientific');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $plant->image = $imagePath;
            }
            if ($request->hasFile('image_bg')) {
                $imagePath = $request->file('image_bg')->store('product_images', 'public');
                $plant->image_bg = $imagePath;
            }

            $plant->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $plant = Plant::findOrFail($id);
        return response()->json($plant);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'scientific' => 'nullable|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $plant = Plant::findOrFail($id);
            $plant->name = $request->input('name');
            $plant->scientific = $request->input('scientific');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada (jika diperlukan)
                Storage::disk('public')->delete($plant->image);

                $imagePath = $request->file('image')->store('product_images', 'public');
                $plant->image = $imagePath;

                // Tambahkan pernyataan log
                Log::info('New image uploaded: ' . $imagePath);
            }

            if ($request->hasFile('image_bg')) {
                // Hapus gambar lama background jika ada (jika diperlukan)
                Storage::disk('public')->delete($plant->image_bg);

                $imageBgPath = $request->file('image_bg')->store('product_images', 'public');
                $plant->image_bg = $imageBgPath;

                // Tambahkan pernyataan log
                Log::info('New background image uploaded: ' . $imageBgPath);
            }

            $plant->save();
            return response()->json(['message' => 'Plant updated successfully']);
        } catch (\Exception $e) {
            // Tambahkan pernyataan log untuk kesalahan
            Log::error('Failed to update plant: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to update plant'], 500);
        }
    }


    public function destroy($id)
    {
        $product = Plant::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
