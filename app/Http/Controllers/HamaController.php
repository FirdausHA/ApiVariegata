<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hama;

class HamaController extends Controller
{
    public function index()
    {
        $hamas = Hama::all();
        return response()->json(['massage' => 'Succes','data' => $hamas]);
    }

    public function show($id)
    {
        $hama = Hama::find($id);
        return response()->json(['massage' => 'Succes','data' => $hama]);
    }

    public function store(Request $request)
    {
        $hama = Hama::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $hama]);
    }

    public function update(Request $request, $id)
    {
        $hama = Hama::find($id);
        $hama->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $hama]);
    }

    public function destroy($id)
    {
        $hama = Hama::find($id);
        $hama->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
