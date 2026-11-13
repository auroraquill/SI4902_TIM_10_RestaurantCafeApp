<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Formulir Tambah Pegawai</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  <div class="site-title">
    <span>Restaurant & Cafe</span>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
  </div>

  <div class="page-center">
    <h1>Formulir Tambah Pegawai</h1>
    <p>Isi data pegawai baru pada formulir di bawah ini.</p>

    @if ($errors->any())
      <div style="color:#c0392b;">
        @foreach ($errors->all() as $err)
          <p>{{ $err }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('staff.store') }}" method="post" class="form-box">
      @csrf
      <label for="nama">Nama Pegawai:</label><br>
      <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required><br><br>

      <label for="jabatan">Jabatan:</label><br>
      <select id="jabatan" name="jabatan">
        @foreach (['Chef', 'Waiter', 'Kasir'] as $j)
          <option value="{{ $j }}" @selected(old('jabatan') === $j)>{{ $j }}</option>
        @endforeach
      </select><br><br>

      <label for="kontak">Nomor Kontak:</label><br>
      <input type="text" id="kontak" name="kontak" value="{{ old('kontak') }}" required><br><br>

      <p><b>Akun Login</b> (opsional, kosongkan kalau pegawai belum perlu login)</p>
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="{{ old('email') }}"><br><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password"><br><br>

      <input type="submit" value="Simpan">
    </form>

    <p><a href="{{ route('staff.index') }}" class="btn-back">Kembali ke Data Staff & Pegawai</a></p>
  </div>

  @if (session('success'))
  <div class="modal-overlay show" id="modalSukses">
    <div class="modal-box">
      <h3>Berhasil!</h3>
      <p>{{ session('success') }}</p>
      <div class="modal-actions">
        <button type="button" class="btn-ok" id="btnOk">OK</button>
      </div>
    </div>
  </div>
  <script>
    const modalSukses = document.getElementById('modalSukses');
    document.getElementById('btnOk').onclick = () => modalSukses.classList.remove('show');
    modalSukses.onclick = e => { if (e.target === modalSukses) modalSukses.classList.remove('show'); };
  </script>
  @endif
</body>
</html>