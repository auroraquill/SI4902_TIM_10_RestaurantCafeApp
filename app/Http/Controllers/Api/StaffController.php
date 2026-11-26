<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $pegawai = Staff::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%")
                      ->orWhere('kontak', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $pegawai]);
    }

    public function show(Staff $staff)
    {
        return response()->json(['data' => $staff]);
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

        $staff = DB::transaction(function () use ($data) {
            $staff = Staff::create([
                'nama'    => $data['nama'],
                'jabatan' => $data['jabatan'],
                'kontak'  => $data['kontak'],
            ]);

            if (! empty($data['email'])) {
                User::create([
                    'name'       => $data['nama'],
                    'email'      => $data['email'],
                    'password'   => $data['password'],
                    'role'       => 'pegawai',
                    'pegawai_id' => $staff->id,
                ]);
            }

            return $staff;
        });

        return response()->json(['data' => $staff], 201);
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|in:Chef,Waiter,Kasir',
            'kontak'  => 'required|string|max:20',
        ]);

        $staff->update($data);
        User::where('pegawai_id', $staff->id)->update(['name' => $data['nama']]);

        return response()->json(['data' => $staff]);
    }

    public function destroy(Staff $staff)
    {
        User::where('pegawai_id', $staff->id)->delete();
        $staff->delete();

        return response()->json(['message' => 'Data pegawai berhasil dihapus.']);
    }
}