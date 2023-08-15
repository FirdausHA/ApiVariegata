<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                $imagePath = $request->file('image')->store('hama_images', 'public');
                $hama->image = $imagePath;
            }

            $hama->save();
            return response()->json(['message' => 'Hama created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create Hama'], 500);
        }
    }

    public function show($id)
    {
        $hama = Hama::findOrFail($id);
        return response()->json($hama);
    }

    public function getByPlant($plant_id)
    {
        $hamas = Hama::where('plant_id', $plant_id)->get();
        return response()->json($hamas);
    }

    public function update(Request $request, $id)
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
            $hama = Hama::findOrFail($id);
            $hama->name = $request->input('name');
            $hama->tipe = $request->input('tipe');
            $hama->description = $request->input('description');
            $hama->cegah = $request->input('cegah');
            $hama->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($hama->image) {
                    Storage::disk('public')->delete($hama->image);
                }

                $imagePath = $request->file('image')->store('hama_images', 'public');
                $hama->image = $imagePath;
            }

            $hama->save();
            return response()->json(['message' => 'Hama updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update hama'], 500);
        }
    }

    public function destroy($id)
    {
        $hama = Hama::findOrFail($id);
        $hama->delete();
        return response()->json(null, 204);
    }
}
