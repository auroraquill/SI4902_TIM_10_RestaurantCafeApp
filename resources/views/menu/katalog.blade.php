<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Restaurant & Cafe</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        html { scroll-behavior: smooth; }
        .kategori-section { scroll-margin-top: 20px; }
        .kategori-nav { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }
        .kategori-nav a { padding: 7px 16px; border-radius: 999px; background: #eef2ff; color: #4f46e5; font-size: 13px; font-weight: 600; text-decoration: none; transition: background .15s, color .15s; }
        .kategori-nav a:hover { background: #4f46e5; color: #fff; }
    </style>
</head>
<body>

    <!-- Navbar Atas -->
    <div class="navbar">
        <div class="user-info" style="margin-left: auto;">
            <span style="font-weight: 600; color: #4f46e5;">Restaurant & Cafe</span>
            <img src="{{ asset('images/logo.png') }}" alt="Logo TRES" class="logo" style="max-height: 40px; width: auto;">
        </div>
    </div>

    <div class="container menu-page-container">

        <div class="card">
            <div class="card-head">
                <div>
                    <h2>Menu Kami</h2>
                    <p class="card-subtitle">Pilihan menu makanan dan minuman terbaik.</p>
                </div>
            </div>

            @php
                // Kelompokkan menu per kategori (huruf besar/kecil disamakan, urut abjad)
                $grouped = $menus
                    ->groupBy(fn($m) => ucwords(strtolower(trim($m->kategori ?: 'Umum'))))
                    ->sortKeys();
            @endphp

            {{-- Tombol navigasi kategori --}}
            @if($grouped->count() > 1)
                <div class="kategori-nav">
                    @foreach($grouped as $kategori => $items)
                        <a href="#kategori-{{ \Illuminate\Support\Str::slug($kategori) }}">{{ $kategori }}</a>
                    @endforeach
                </div>
            @endif

            @forelse($grouped as $kategori => $items)
                <div class="kategori-section" id="kategori-{{ \Illuminate\Support\Str::slug($kategori) }}" style="margin-top: 30px;">
                    <h3 style="margin: 0 0 15px 0; padding-bottom: 8px; font-size: 18px; color: #1f2937; border-bottom: 2px solid #e5e7eb;">
                        {{ $kategori }}
                        <span style="font-size: 13px; font-weight: 500; color: #6b7280;">({{ $items->count() }} menu)</span>
                    </h3>

                    <div class="menu-grid-container">
                        @foreach($items as $menu)
                        <div class="menu-card-item" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            @if(!empty($menu->foto))
                                <img src="{{ asset('uploads/' . $menu->foto) }}" alt="{{ $menu->nama }}" style="width: 100%; height: 200px; object-fit: contain; border-radius: 6px; margin-bottom: 12px; background: #f3f4f6;">
                            @else
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300" alt="Menu Default" style="width: 100%; height: 200px; object-fit: contain; border-radius: 6px; margin-bottom: 12px; background: #f3f4f6;">
                            @endif

                            <h4 style="margin: 0 0 8px 0; font-size: 16px; color: #1f2937;">{{ $menu->nama ?? 'Nama Menu' }}</h4>
                            <div class="menu-price" style="font-weight: 600; color: #4f46e5; font-size: 15px;">Rp {{ number_format($menu->harga ?? 0, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="empty-menu-state" style="text-align: center; color: #6b7280; padding: 40px;">
                    Belum ada data menu.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>