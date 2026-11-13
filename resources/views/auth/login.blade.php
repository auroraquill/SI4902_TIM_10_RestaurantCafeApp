<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  <div class="site-title">
    <span>Restaurant & Cafe</span>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
  </div>

  <div class="page-center">
    <h1>Login</h1>

    @if ($errors->any())
      <div style="color:#c0392b;">
        @foreach ($errors->all() as $err)
          <p>{{ $err }}</p>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login.proses') }}" method="post" class="form-box">
      @csrf
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br><br>

      <button type="submit">Masuk</button>
    </form>
  </div>

</body>
</html>