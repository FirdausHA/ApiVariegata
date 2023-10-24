<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //Metode atau Fungsi API

    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = new Category();
            $category->name = $request->input('name');
            $category->save();

            // Respons untuk API
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Category berhasil dibuat']);
            }

            // Respons untuk tampilan web
            return redirect()->route('categories.index')->with('success', 'Category berhasil dibuat');
        } catch (\Exception $e) {
            // Respons untuk API
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Gagal membuat Category'], 500);
            }

            // Respons untuk tampilan web
            return redirect()->back()->with('error', 'Gagal membuat Category');
        }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->name = $request->input('name');

            $category->save();
            return response()->json(['message' => 'Category berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui Category'], 500);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }

    //Metode di webnya
    public function listdata()
    {
        $categories = Category::get();
        return view('category.index', ['categories' => $categories]);
    }

    public function tambah()
    {
        return view('category.form');
    }
}
