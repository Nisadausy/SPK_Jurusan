<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Admin')</title>

    {{-- Bootstrap 5 CDN (boleh diganti Vite/Tailwind sesuai project) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root { --sidebar-w: 280px; }
        body { background: #f6f7fb; }
        .app-shell { min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-w);
            background: #111827;
            color: #e5e7eb;
        }
        .sidebar .brand { border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar a {
            color: #e5e7eb;
            text-decoration: none;
        }
        .sidebar .nav-link {
            border-radius: .5rem;
            padding: .6rem .75rem;
            color: #e5e7eb;
        }
        .sidebar .nav-link:hover { background: rgba(255,255,255,.08); }
        .sidebar .nav-link.active { background: rgba(255,255,255,.14); }
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }
        .content-wrap { padding: 1.25rem; }
        .card-soft {
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            box-shadow: 0 1px 10px rgba(17,24,39,.04);
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="d-flex app-shell">
    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    <div class="flex-grow-1 d-flex flex-column">
        {{-- Topbar --}}
        @include('admin.partials.topbar')

        {{-- Content --}}
        <main class="content-wrap flex-grow-1">
            @yield('content')
        </main>

        <footer class="py-3 text-center text-muted small">
            &copy; {{ date('Y') }} SPK SAW — Admin Panel
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
