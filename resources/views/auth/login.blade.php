<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #2563eb, #1e40af);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box {
            background: #fff;
            padding: 35px;
            width: 100%;
            max-width: 480px;
            border-radius: 14px;
            box-shadow: 0 25px 45px rgba(0,0,0,.25);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 25px;
        }

        .field { margin-bottom: 14px; }

        label {
            display: block;
            font-size: 13px;
            color: #374151;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: .3s;
        }

        button:hover { background: #1e40af; }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #dcfce7; color: #166534; }

        .error-text {
            margin-top: 6px;
            font-size: 12px;
            color: #b91c1c;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>
    <p>Silakan masuk menggunakan akun kamu</p>

    {{-- Validasi Laravel (Breeze) --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Breeze: POST login adalah route('login') --}}
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Email"
                required
                autocomplete="email"
            >
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="current-password"
            >
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Masuk</button>
    </form>

    <div class="footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div>
</div>

</body>
</html>
