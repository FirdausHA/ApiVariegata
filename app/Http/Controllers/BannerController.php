<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return response()->json($banners);
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
            $banner = new Banner();
            $banner->name = $request->input('name');
            $banner->subtitle = $request->input('subtitle');
            $banner->color = $request->input('color');
            $banner->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('banner_images', 'public');
                $banner->image = $imagePath;
            }

            $banner->save();
            return response()->json(['message' => 'Banner created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create banner'], 500);
        }
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return response()->json($banner);
    }

    public function getByPlant($plant_id)
    {
        $banners = Banner::where('plant_id', $plant_id)->get();
        return response()->json($banners);
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
            $banner = Banner::findOrFail($id);
            $banner->name = $request->input('name');
            $banner->subtitle = $request->input('subtitle');
            $banner->color = $request->input('color');
            $banner->plant_id = $request->input('plant_id');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($banner->image);

                $imagePath = $request->file('image')->store('banner_images', 'public');
                $banner->image = $imagePath;

                Log::info('New image uploaded: ' . $imagePath);
            }

            $banner->save();
            return response()->json(['message' => 'Banner updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update banner'], 500);
        }
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return response()->json(null, 204);
    }

    // Metode Web Admin
    public function listdata()
    {
        $banners = Banner::get();

        return view('banner.index', ['data' => $banners]);
    }

    public function tambah()
    {
        $plants = Banner::get();

        return view('banner.form', ['plants' => $plants]);
    }
}
