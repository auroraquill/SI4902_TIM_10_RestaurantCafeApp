<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StaffController
{
    public function index()
    {
        $pegawai = Staff::orderBy('id')->get();
        return view('staff.index', compact('pegawai'));
    }

    // Hak akses Pegawai: hanya lihat profil sendiri
    public function profil()
    {
        $staff = Staff::find(auth()->user()->pegawai_id);
        return view('staff.profil', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'jabatan'  => 'required|in:Chef,Waiter,Kasir',
            'kontak'   => 'required|string|max:20',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'nullable|required_with:email|min:6',
        ]);

        DB::transaction(function () use ($data) {
            $staff = Staff::create([
                'nama'    => $data['nama'],
                'jabatan' => $data['jabatan'],
                'kontak'  => $data['kontak'],
            ]);

            // Kalau email diisi, sekalian bikin akun login role pegawai
            if (! empty($data['email'])) {
                User::create([
                    'name'       => $data['nama'],
                    'email'      => $data['email'],
                    'password'   => $data['password'],
                    'role'       => 'pegawai',
                    'pegawai_id' => $staff->id,
                ]);
            }
        });

        // Tetap di form, popup sukses ditampilkan lewat flash message
        return redirect()->route('staff.create')
            ->with('success', 'Pegawai ' . $data['nama'] . ' berhasil ditambahkan.');
    }

    public function destroy(Staff $staff)
    {
        // akun login pegawai ikut dihapus
        User::where('pegawai_id', $staff->id)->delete();
        $staff->delete();
        return redirect()->route('staff.index');
    }
}