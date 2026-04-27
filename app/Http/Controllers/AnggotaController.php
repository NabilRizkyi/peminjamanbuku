<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('admin.anggota.index', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required|regex:/^[0-9+]+$/',
            'alamat' => 'required',
        ]);

        $anggota->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('anggota.index')
            ->with('success', 'Data berhasil diupdate');
    }
}
