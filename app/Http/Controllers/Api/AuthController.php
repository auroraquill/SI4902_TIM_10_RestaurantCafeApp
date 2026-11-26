<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $plain = Str::random(60);
        $user->forceFill(['api_token' => hash('sha256', $plain)])->save();

        return response()->json([
            'token' => $plain,
            'type'  => 'Bearer',
            'user'  => $this->userData($user),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($this->userData($request->user()));
    }

    public function logout(Request $request)
    {
        $request->user()->forceFill(['api_token' => null])->save();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    private function userData(User $user): array
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $user->role,
            'pegawai_id' => $user->pegawai_id,
        ];
    }
}