<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Siswa</title>
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

        .field {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-size: 13px;
            color: #374151;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .hint {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
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

        button:hover {
            background: #1e40af;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

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
    <h2>Registrasi Siswa</h2>
    <p>Silakan isi data diri dengan benar</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Breeze: POST register adalah route('register') --}}
    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="field">
            <label for="nama">Nama Lengkap</label>
            <input
                id="nama"
                type="text"
                name="nama"
                placeholder="Nama Lengkap"
                value="{{ old('nama') }}"
                required
                maxlength="120"
                autocomplete="name"
            >
            @error('nama')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
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
                autocomplete="new-password"
            >
            <div class="hint">Gunakan minimal 8 karakter (disarankan huruf & angka).</div>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="Konfirmasi Password"
                required
                autocomplete="new-password"
            >
        </div>

        <div class="field">
            <label for="sekolah_asal">Sekolah Asal</label>
            <input
                id="sekolah_asal"
                type="text"
                name="sekolah_asal"
                placeholder="Sekolah Asal"
                value="{{ old('sekolah_asal') }}"
                required
                maxlength="150"
            >
            @error('sekolah_asal')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="no_telepon">No Telepon</label>
            <input
                id="no_telepon"
                type="tel"
                name="no_telepon"
                placeholder="No Telepon"
                value="{{ old('no_telepon') }}"
                required
                maxlength="30"
                autocomplete="tel"
            >
            @error('no_telepon')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="alamat">Alamat</label>
            <textarea
                id="alamat"
                name="alamat"
                placeholder="Alamat"
                required
                rows="3"
            >{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Daftar</button>
    </form>

    <div class="footer">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>
</div>

</body>
</html>
