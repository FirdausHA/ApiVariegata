<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Informasi;


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
                $imagePath = $request->file('image')->store('informasi_images', 'public');
                $informasi->image = $imagePath;
            }

            $informasi->save();
            return response()->json(['message' => 'Informasi created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create informasi'], 500);
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
                Storage::disk('public')->delete($informasi->image);

                $imagePath = $request->file('image')->store('informasi_images', 'public');
                $informasi->image = $imagePath;

                Log::info('New image uploaded: ' . $imagePath);
            }

            $informasi->save();
            return response()->json(['message' => 'Informasi updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update informasi'], 500);
        }
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();
        return response()->json(null, 204);
    }

    //Metode di webnya
    public function listdata()
    {
        $informasis = Informasi::get();
        return view('informasi.index', ['data' => $informasis]);
    }

    public function tambah()
    {
        return view('informasi.form');
    }
}
