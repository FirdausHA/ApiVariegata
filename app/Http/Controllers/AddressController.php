<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return response()->json(['addresses' => $addresses], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
            'catatan_driver' => 'nullable|string',
        ]);

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

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
