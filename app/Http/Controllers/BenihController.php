<?php

namespace App\Http\Controllers;

use App\Models\Benih;
use Illuminate\Http\Request;

class BenihController extends Controller
{
    public function index()
    {
        $benihs = Benih::all();
        return response()->json(['massage' => 'Succes','data' => $benihs]);
    }

    public function show($id)
    {
        $benih = Benih::find($id);
        return response()->json(['massage' => 'Succes','data' => $benih]);
    }

    public function store(Request $request)
    {
        $benih = Benih::create($request->all());
        return response()->json(['massage' => 'Succes','data' => $benih]);
    }

    public function update(Request $request, $id)
    {
        $benih = Benih::find($id);
        $benih->update($request->all());
        return response()->json(['massage' => 'Succes','data' => $benih]);
    }

    public function destroy($id)
    {
        $benih = Benih::find($id);
        $benih->delete();
        return response()->json(['massage' => 'Succes','data' => null]);
    }
}
