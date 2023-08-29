<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class UserController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', auth()->user()->id)->get();

        return view('user_addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $address = new Address;
        $address->user_id = auth()->user()->id;
        $address->address = $request->input('address');
        $address->receiver_name = $request->input('receiver_name');
        $address->receiver_phone = $request->input('receiver_phone');
        $address->email = $request->input('email');
        $address->driver_note = $request->input('driver_note');
        $address->save();

        return redirect()->route('user_addresses.index')->with('success', 'Alamat berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        if (!$address) {
            return redirect()->route('user_addresses.index')->with('error', 'Alamat tidak ditemukan');
        }

        $address->address = $request->input('address');
        $address->receiver_name = $request->input('receiver_name');
        $address->receiver_phone = $request->input('receiver_phone');
        $address->email = $request->input('email');
        $address->driver_note = $request->input('driver_note');
        $address->save();

        return redirect()->route('user_addresses.index')->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $address = Address::find($id);

        if (!$address) {
            return redirect()->route('user_addresses.index')->with('error', 'Alamat tidak ditemukan');
        }

        $address->delete();

        return redirect()->route('user_addresses.index')->with('success', 'Alamat berhasil dihapus');
    }
}
