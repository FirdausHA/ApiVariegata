<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::all();
        return response()->json(['massage' => 'Succes','data' => $alats]);
    }

    public function show($id)
    {
        $alat = Alat::find($id);
        return response()->json(['massage' => 'Succes','data' => $alat]);
    }

    public function store(Request $request)
    {
        $alat = Alat::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $alat]);
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::find($id);
        $alat->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $alat]);
    }

    public function destroy($id)
    {
        $alat = Alat::find($id);
        $alat->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
