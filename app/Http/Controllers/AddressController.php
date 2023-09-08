<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $addresses = Address::where('user_id', $user->id)->get();
    return response()->json(['addresses' => $addresses], 200);
}

public function store(Request $request)
{
    $user = Auth::user();
    $data = $request->validate([
        'nama' => 'required|string',
        'alamat' => 'required|string',
        'nomor_telepon' => 'required|string',
        'catatan_driver' => 'nullable|string',
    ]);

    $data['user_id'] = $user->id; // Menyimpan user_id saat menyimpan alamat

    $address = Address::create($data);

    return response()->json([
        'message' => 'Address created successfully',
        'address' => $address
    ], 200);
}

public function update(Request $request, $id)
{
    $address = Address::find($id);

    if (!$address) {
        return response()->json(['message' => 'Address not found'], 404);
    }

    // Memeriksa pemilik alamat
    if ($address->user_id !== Auth::user()->id) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $data = $request->validate([
        'nama' => 'string',
        'alamat' => 'string',
        'nomor_telepon' => 'string',
        'catatan_driver' => 'nullable|string',
    ]);

    $address->update($data);

    return response()->json([
        'message' => 'Address updated successfully',
        'address' => $address
    ], 200);
}

public function destroy($id)
{
    $address = Address::find($id);

    if (!$address) {
        return response()->json(['message' => 'Address not found'], 404);
    }

    // Memeriksa pemilik alamat
    if ($address->user_id !== Auth::user()->id) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $address->delete();

    return response()->json(['message' => 'Address deleted successfully'], 200);
}
}
