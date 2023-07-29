<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katalog;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogs = Katalog::all();
        return response()->json(['massage' => 'Succes','data' => $katalogs]);
    }

    public function show($id)
    {
        $katalog = Katalog::find($id);
        return response()->json(['massage' => 'Succes','data' => $katalog]);
    }

    public function store(Request $request)
    {
        $katalog = Katalog::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $katalog]);
    }

    public function update(Request $request, $id)
    {
        $katalog = Katalog::find($id);
        $katalog->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $katalog]);
    }

    public function destroy($id)
    {
        $katalog = Katalog::find($id);
        $katalog->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
