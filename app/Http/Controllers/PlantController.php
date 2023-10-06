<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
                $imagePath = $request->file('image')->store('plant_images', 'public');
                $plant->image = $imagePath;
            }
            if ($request->hasFile('image_bg')) {
                $imageBgPath = $request->file('image_bg')->store('plant_images', 'public');
                $plant->image_bg = $imageBgPath;
            }

            $plant->save();
            return response()->json(['message' => 'Plant created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create plant'], 500);
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
            'scientific' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $plant = Plant::findOrFail($id);
            $plant->name = $request->input('name');
            $plant->scientific = $request->input('scientific');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($plant->image);

                $imagePath = $request->file('image')->store('plant_images', 'public');
                $plant->image = $imagePath;

                Log::info('New image uploaded: ' . $imagePath);
            }

            if ($request->hasFile('image_bg')) {
                Storage::disk('public')->delete($plant->image_bg);

                $imageBgPath = $request->file('image_bg')->store('plant_images', 'public');
                $plant->image_bg = $imageBgPath;

                Log::info('New background image uploaded: ' . $imageBgPath);
            }

            $plant->save();
            return response()->json(['message' => 'Plant updated successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to update plant: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update plant'], 500);
        }
    }

    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();
        return response()->json(null, 204);
    }

    //Metode Web Admin
    public function listdata()
    {
        $plants = Plant::get();

        return view('plant.index', ['data' => $plants]);
    }

    public function tambah()
    {

        return view('plant.form');
    }
}
