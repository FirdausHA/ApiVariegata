<?php

namespace App\Http\Controllers;

use App\Models\Pupuk;
use Illuminate\Http\Request;

class PupukController extends Controller
{
    public function index()
    {
        $pupuks = Pupuk::all();
        return response()->json(['massage' => 'Succes','data' => $pupuks]);
    }

    public function show($id)
    {
        $pupuks = Pupuk::find($id);
        return response()->json(['massage' => 'Succes','data' => $pupuks]);
    }

    public function store(Request $request)
    {
        $pupuks = Pupuk::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $pupuks]);
    }

    public function update(Request $request, $id)
    {
        $pupuks = Pupuk::find($id);
        $pupuks->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $pupuks]);
    }

    public function destroy($id)
    {
        $pupuks = Pupuk::find($id);
        $pupuks->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
