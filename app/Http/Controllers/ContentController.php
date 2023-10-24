<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Stage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();
        return response()->json($contents);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'week' => 'required|string',
            'description' => 'required|string',
            'title' => 'required|string',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $content = new Content();
            $content->name = $request->input('name');
            $content->title = $request->input('title');
            $content->description = $request->input('description');
            $content->week = $request->input('week');
            $content->stage_id = $request->input('stage_id');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('content_images', 'public');
                $content->image = $imagePath;
            }

            $content->save();
            return response()->json(['message' => 'Content created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create cotent'], 500);
        }
    }

    public function show($id)
    {
        $content = Content::findOrFail($id);
        return response()->json($content);
    }

    public function getbyStage($stage_id)
    {
        $contents = Content::where('stage_id', $stage_id)->get();
        return response()->json($contents);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'week' => 'required|string',
            'description' => 'required|string',
            'title' => 'required|string',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $content = Content::findOrFail($id);
            $content->name = $request->input('name');
            $content->title = $request->input('title');
            $content->description = $request->input('description');
            $content->week = $request->input('week');
            $content->stage_id = $request->input('stage_id');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($content->image);

                $imagePath = $request->file('image')->store('content_images', 'public');
                $content->image = $imagePath;

                Log::info('New image uploaded: ' . $imagePath);
            }

            $content->save();
            return response()->json(['message' => 'Content updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update content'], 500);
        }
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        return response()->json(null, 204);
    }

    // Metode Web Admin
    public function listdata()
    {
        $contents = Content::get();

        return view('content.index', ['data' => $contents]);
    }

    public function tambah()
    {
        $stages = Stage::get();

        return view('content.form', ['stages' => $stages]);
    }
}
