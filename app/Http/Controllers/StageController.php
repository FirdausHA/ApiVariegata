<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::all();
        return response()->json($stages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'banner_id' => 'required|exists:banners,id',
        ]);

        try {
            $stage = new Stage();
            $stage->name = $request->input('name');
            $stage->banner_id = $request->input('banner_id');

            $stage->save();
            return response()->json(['message' => 'Tahapan berhasil dibuat']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat tahapan'], 500);
        }
    }

    public function show($id)
    {
        $stage = Stage::findOrFail($id);
        return response()->json($stage);
    }

    public function getByCategory($banner_id)
    {
        $stages = Stage::where('banner_id', $banner_id)->get();
        return response()->json($stages);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'banner_id' => 'required|exists:banners,id',
        ]);

        try {
            $stage = Stage::findOrFail($id);
            $stage->name = $request->input('name');
            $stage->banner_id = $request->input('banner_id');

            $stage->save();
            return response()->json(['message' => 'Tahapan berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui tahapan'], 500);
        }
    }

    public function destroy($id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();
        return response()->json(null, 204);
    }
}
