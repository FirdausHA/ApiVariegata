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

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $addresses = Address::where('user_id', $user->id)->get();
        return response()->json(['addresses' => $addresses], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $data = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
            'catatan_driver' => 'nullable|string',
        ]);

        $data['user_id'] = $user->id;
        $address = Address::create($data);

        return response()->json([
            'message' => 'Address created successfully',
            'address' => $address
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $address = Address::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        if ($address->user_id !== $user->id) {
            return response()->json(['message' => 'Address does not belong to the authenticated user'], 403);
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
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $address = Address::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        if ($address->user_id !== $user->id) {
            return response()->json(['message' => 'Address does not belong to the authenticated user'], 403);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
