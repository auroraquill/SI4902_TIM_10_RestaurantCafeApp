<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index(Request $request)
    {
        $mejas = Meja::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('id')
            ->get();

        return response()->json(['data' => $mejas]);
    }

    public function show(Meja $meja)
    {
        return response()->json(['data' => $meja]);
    }

    public function store(Request $request)
    {
        $meja = Meja::create($this->validated($request));

        return response()->json(['data' => $meja], 201);
    }

    public function update(Request $request, Meja $meja)
    {
        $meja->update($this->validated($request));

        return response()->json(['data' => $meja]);
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();

        return response()->json(['message' => 'Meja berhasil dihapus.']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nomor_meja' => 'required|string|max:50',
            'kapasitas'  => 'required|integer|min:1',
            'status'     => 'required|string|in:tersedia,terisi',
        ]);
    }
}