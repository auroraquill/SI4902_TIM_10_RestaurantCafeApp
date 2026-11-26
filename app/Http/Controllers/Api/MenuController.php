<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('search'), fn ($q) => $q->where('nama', 'like', '%' . $request->search . '%'))
            ->orderByDesc('id')
            ->get();

        return MenuResource::collection($menus);
    }

    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['foto']  = $this->uploadFoto($request);
        $data['halal'] = $request->boolean('halal', true);

        $menu = Menu::create($data);

        return (new MenuResource($menu))->response()->setStatusCode(201);
    }

    // Catatan: kalau kirim file foto, pakai POST + field _method=PUT (multipart)
    public function update(Request $request, Menu $menu)
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $this->hapusFoto($menu->foto);
            $data['foto'] = $this->uploadFoto($request);
        }

        if ($request->has('halal')) {
            $data['halal'] = $request->boolean('halal');
        }

        $menu->update($data);

        return new MenuResource($menu);
    }

    public function destroy(Menu $menu)
    {
        $this->hapusFoto($menu->foto);
        $menu->delete();

        return response()->json(['message' => 'Menu berhasil dihapus.']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama'     => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'halal'    => 'nullable|boolean',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }

    private function uploadFoto(Request $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }
        $file = $request->file('foto');
        $namaBaru = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $namaBaru);

        return $namaBaru;
    }

    private function hapusFoto(?string $foto): void
    {
        if ($foto && file_exists(public_path('uploads/' . $foto))) {
            @unlink(public_path('uploads/' . $foto));
        }
    }
}