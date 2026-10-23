<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController
{
    public function index()
    {
        $pegawai = Staff::orderBy('id')->get();
        return view('staff.index', compact('pegawai'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|in:Chef,Waiter,Kasir',
            'kontak'  => 'required|string|max:20',
        ]);

        Staff::create($data);
        return redirect()->route('staff.index');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index');
    }
}