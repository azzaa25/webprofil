<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f7f9fc;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-container {
      display: flex;
      width: 900px;
      height: 520px;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .auth-left {
      background-color: #e4f3c3;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 30px;
    }

    .auth-left img {
      width: 150px;
      height: auto;
      margin-bottom: 20px;
    }

    .auth-left h3 {
      color: #2b2b2b;
      font-weight: 700;
    }

    .auth-right {
      flex: 1;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .auth-right h2 {
      font-weight: 700;
      color: #333;
      margin-bottom: 10px;
    }

    .auth-right p {
      color: #666;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 12px;
      padding: 10px 15px;
    }

    .btn-login {
      background-color: #a89ff3;
      border: none;
      color: #fff;
      font-weight: 600;
      padding: 10px;
      border-radius: 12px;
      width: 100%;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #8b7de8;
    }
  </style>
</head>
<body>

  <div class="auth-container">

    {{-- KIRI: Logo dan Judul --}}
    <div class="auth-left">
      <img src="{{ asset('img/logo_kediri.png') }}" alt="Logo Kediri">
      <h3><strong>Pemerintah Kota Kediri</strong></h3>
      <p><em>Portal Admin Sistem Informasi</em></p>
    </div>

    {{-- KANAN: Form Login --}}
    <div class="auth-right">
      <h2>Selamat Datang 👋</h2>
      <p>Masuk ke akun admin Anda</p>

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-login">MASUK</button>
      </form>
    </div>
  </div>

</body>
</html>
