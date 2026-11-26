<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Staff - Sistem Restoran</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    {{-- Header --}}
    <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
            Sistem Restoran
        </a>
        <div class="text-sm text-indigo-600 font-medium">
            Restaurant &amp; Cafe
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        {{-- Tombol Kembali --}}
        <div class="mb-5">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        {{-- Card Utama --}}
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Data Pegawai</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun pegawai dan jabatan restoran.</p>
                </div>

                <a href="{{ route('staff.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-md shadow-sm transition">
                    + Tambah Baru
                </a>
            </div>

            {{-- Form Search --}}
            <form action="{{ route('staff.index') }}" method="GET" class="flex flex-wrap items-center gap-2 mb-6">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, jabatan, atau nomor kontak..."
                    class="w-full sm:w-80 border border-gray-300 rounded-md px-3.5 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('staff.index') }}"
                       class="px-3.5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-md transition">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Tabel Data Pegawai --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="py-3.5 px-4">NO.</th>
                            <th class="py-3.5 px-4">NAMA PEGAWAI</th>
                            <th class="py-3.5 px-4">JABATAN</th>
                            <th class="py-3.5 px-4">NOMOR KONTAK</th>
                            <th class="py-3.5 px-4 text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        @forelse($pegawai as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-4 text-gray-500">{{ $loop->iteration }}</td>
                                <td class="py-4 px-4 font-semibold text-gray-900">{{ $item->nama }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $item->jabatan }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $item->kontak }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('staff.edit', $item->id) }}"
                                           class="px-3.5 py-1.5 bg-amber-400 hover:bg-amber-500 text-white text-xs font-bold uppercase rounded transition">
                                            EDIT
                                        </a>

                                        <form action="{{ route('staff.destroy', $item->id) }}"
                                              method="POST"
                                              data-confirm="Yakin ingin menghapus data pegawai {{ $item->nama }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3.5 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-bold uppercase rounded transition">
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                    @if(request('search'))
                                        Data pegawai dengan kata kunci "<strong>{{ request('search') }}</strong>" tidak ditemukan.
                                    @else
                                        Belum ada data pegawai.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    @include('partials.popup')
</body>
</html>