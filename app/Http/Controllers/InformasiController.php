<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $informasis = Informasi::all();
        return response()->json(['massage' => 'Succes','data' => $informasis]);
    }

    public function show($id)
    {
        $informasi = Informasi::find($id);
        return response()->json(['massage' => 'Succes','data' => $informasi]);
    }

    public function store(Request $request)
    {
        $informasi = Informasi::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $informasi]);
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::find($id);
        $informasi->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $informasi]);
    }

    public function destroy($id)
    {
        $informasi = Informasi::find($id);
        $informasi->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
