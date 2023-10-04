<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCrosell;
use Carbon\Carbon;

class ProductCrosellController extends Controller
{
    public function index()
    {
        $product_crosells = ProductCrosell::all();
        return response()->json(['products' => $product_crosells], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
            'expiry_time' => 'required|date_format:Y-m-d H:i:s', // Tambahkan validasi waktu kedaluwarsa
        ]);

        try {
            $product_crosell = new ProductCrosell();
            $product_crosell->name = $request->input('name');
            $product_crosell->description = $request->input('description');
            $product_crosell->price = $request->input('price');
            $product_crosell->stock = $request->input('stock');
            $product_crosell->expiry_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('expiry_time')); // Parsing waktu

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $product_crosell->image = $imagePath;
            }

            $product_crosell->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
            'expiry_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        try {
            $product_crosell = Product::findOrFail($id);
            $product_crosell->name = $request->input('name');
            $product_crosell->description = $request->input('description');
            $product_crosell->price = $request->input('price');
            $product_crosell->stock = $request->input('stock');
            $product_crosell->expiry_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('expiry_time')); // Parsing waktu

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($product_crosell->image);

                $imagePath = $request->file('image')->store('product_images', 'public');
                $product_crosell->image = $imagePath;
            }

            $product_crosell->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function delete($id)
    {
        $product_crosell = Product::findOrFail($id);
        $product_crosell->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
