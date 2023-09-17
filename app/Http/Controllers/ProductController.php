<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer', // Validasi untuk stok ditambahkan
        ]);

        try {
            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->stock = $request->input('stock');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('product_images', 'public');
                $product->image = $imagePath;
            }

            $product->save();
            return response()->json(['message' => 'Product created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function getByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        return response()->json($products);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->stock = $request->input('stock');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($product->image);

                $imagePath = $request->file('image')->store('product_images', 'public');
                $product->image = $imagePath;

                Log::info('New image uploaded: ' . $imagePath);
            }

            $product->save();
            return response()->json(['message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Set the stock to zero before deleting the product
            $product->stock = 0;
            $product->save();

            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }


    public function updateProductStock(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            $product = Product::findOrFail($productId);

            // Periksa apakah stok mencukupi sebelum menguranginya
            if ($product->stock >= $request->input('quantity')) {
                // Kurangkan stok produk sesuai dengan permintaan
                $product->stock -= $request->input('quantity');
                $product->save();

                return response()->json(['message' => 'Stok produk berhasil diperbarui']);
            } else {
                return response()->json(['error' => 'Stok produk tidak mencukupi'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui stok produk'], 500);
        }
    }

}
