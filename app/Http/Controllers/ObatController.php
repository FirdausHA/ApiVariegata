<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return response()->json(['massage' => 'Succes','data' => $obats]);
    }

    public function show($id)
    {
        $obat = Obat::find($id);
        return response()->json(['massage' => 'Succes','data' => $obat]);
    }

    public function store(Request $request)
    {
        $obat = Obat::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $obat]);
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::find($id);
        $obat->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $obat]);
    }

    public function destroy($id)
    {
        $obat = Obat::find($id);
        $obat->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
