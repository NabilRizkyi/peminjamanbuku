<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Show register form
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle register
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', 'min:6'],
        'no_hp' => ['required', 'regex:/^[0-9+]+$/'],
        'alamat' => ['required', 'string'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'status' => 'pending', 
    ]);

    event(new Registered($user));

    return redirect()->route('login')
        ->with('success', 'Registrasi berhasil! Tunggu approval admin.');
}
}