<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* ... (CSS Anda yang sudah ada) ... */
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
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

    /* CSS tambahan untuk menandai input yang error */
    .form-control.is-invalid {
      border-color: #dc3545;
    }

    /* CSS tambahan untuk pesan error kustom */
    .invalid-feedback {
      display: block;
      /* Agar pesan muncul di bawah input */
      font-size: 0.85rem;
      margin-top: 5px;
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

    /* RESPONSIVE DESIGN */
    @media (max-width: 992px) {
      .auth-container {
        width: 90%;
        height: auto;
        flex-direction: column;
      }

      .auth-left,
      .auth-right {
        flex: unset;
        width: 100%;
        padding: 30px 20px;
        text-align: center;
      }

      .auth-left img {
        width: 120px;
      }

      .auth-right h2 {
        margin-top: 10px;
      }
    }

    @media (max-width: 576px) {
      body {
        padding: 20px;
        height: auto;
      }

      .auth-container {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      }

      .auth-right {
        padding: 25px 15px;
      }

      .auth-left h3 {
        font-size: 18px;
      }

      .auth-left p {
        font-size: 14px;
      }

      .btn-login {
        padding: 10px;
        font-size: 14px;
      }
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
      <h2>Selamat Datang</h2>
      <p>Masuk ke akun admin Anda</p>

      {{-- Pesan Error General (Email/Password salah) --}}
      @if(session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      {{-- Pesan Sukses (setelah logout) --}}
      @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        {{-- FIELD EMAIL --}}
        <div class="mb-3">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
            value="{{ old('email') }}" {{-- Pertahankan input yang diisi sebelumnya --}} {{-- Hapus atribut 'required'
            di sini --}}>
          {{-- MENAMPILKAN PESAN VALIDASI EMAIL --}}
          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        {{-- FIELD PASSWORD --}}
        <div class="mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="Password" {{-- Hapus atribut 'required' di sini --}}>
          {{-- MENAMPILKAN PESAN VALIDASI PASSWORD --}}
          @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-login">MASUK</button>
      </form>
    </div>
  </div>

</body>

</html>