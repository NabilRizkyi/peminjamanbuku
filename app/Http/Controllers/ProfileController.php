<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profile
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile
     */
    public function update(Request $request): RedirectResponse
{
    $user = $request->user();

    // 🔒 Validasi
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'no_hp' => 'nullable|string|max:15',
        'alamat' => 'nullable|string|max:255',
        'password' => 'nullable|confirmed|min:6',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✏️ Update data
    $user->name = $request->name;
    $user->email = $request->email;
    $user->no_hp = $request->no_hp;
    $user->alamat = $request->alamat;

    // 🔄 Reset verifikasi kalau email berubah
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // 🔐 Update password (opsional)
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    // 📸 Upload foto
    if ($request->hasFile('photo')) {

        // hapus foto lama
        if ($user->photo) {
            Storage::delete('public/' . $user->photo);
        }

        // simpan foto baru
        $path = $request->file('photo')->store('profile', 'public');
        $user->photo = $path;
    }

    $user->save();

    return Redirect::route('profile.edit')
        ->with('status', 'Profile berhasil diupdate!');
}

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}