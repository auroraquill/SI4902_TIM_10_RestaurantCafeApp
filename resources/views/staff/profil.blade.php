<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  <div class="site-title">
    <span>Restaurant & Cafe</span>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
  </div>

  <div class="page-center">
    <h1>Profil Saya</h1>

    @if ($staff)
      <div class="form-box">
        <div class="detail-row">
          <span>Nama</span>
          {{ $staff->nama }}
        </div>
        <div class="detail-row">
          <span>Jabatan</span>
          {{ $staff->jabatan }}
        </div>
        <div class="detail-row">
          <span>Nomor Kontak</span>
          {{ $staff->kontak }}
        </div>
      </div>
    @else
      <div class="form-box">
        <p>Akun ini belum terhubung ke data pegawai.</p>
      </div>
    @endif

    <form action="{{ route('logout') }}" method="post" class="profil-logout">
      @csrf
      <button type="submit" class="btn-logout">LOGOUT</button>
    </form>
  </div>

</body>
</html>