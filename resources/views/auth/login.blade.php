<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Definisi Skema Warna Ungu */
        :root {
            /* Ungu Primer (Untuk Tombol & Aksen) */
            --primary-purple: #6a1b9a; 
            /* Ungu Hover */
            --hover-purple: #4a148c;
            /* Ungu Muda (Untuk Panel Kiri) */
            --light-purple: #ede7f6; 
            /* Ungu Gelap (Untuk Teks/Judul) */
            --dark-text: #4527a0;
        }

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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Bayangan lebih dramatis */
            overflow: hidden;
        }

        /* --- Perubahan Warna di auth-left (Hijau diganti Ungu Muda) --- */
        .auth-left {
            background-color: var(--light-purple);
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
            /* Tambahkan sedikit bayangan pada logo agar menonjol */
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }

        .auth-left h3 {
            color: var(--dark-text);
            font-weight: 700;
        }
        
        .auth-left p {
            color: var(--dark-text);
            opacity: 0.8;
            font-weight: 500;
        }

        .auth-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-right h2 {
            font-weight: 800;
            color: var(--dark-text);
            margin-bottom: 10px;
        }

        .auth-right p {
            color: #666;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 10px; /* Sedikit kurang bulat */
            padding: 12px 15px; /* Padding lebih besar */
            border: 1px solid #ddd;
        }

        /* CSS tambahan untuk menandai input yang error */
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* --- Perubahan Warna di btn-login (Ungu Default) --- */
        .btn-login {
            background-color: var(--primary-purple);
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background-color: var(--hover-purple);
            transform: translateY(-1px);
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
                <i class="bi bi-x-octagon-fill me-1"></i> {{ session('error') }}
            </div>
            @endif

            {{-- Pesan Sukses (setelah logout) --}}
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                {{-- FIELD EMAIL --}}
                <div class="mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                        value="{{ old('email') }}" required>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- FIELD PASSWORD --}}
                <div class="mb-4">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login shadow">MASUK</button>
            </form>
        </div>
    </div>

</body>

</html>