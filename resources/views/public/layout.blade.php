<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f7fb; color: #222; }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 24px; }
        .topbar { background: linear-gradient(135deg, #0f172a, #2563eb); color: white; padding: 24px; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,.08); }
        .topbar h1 { margin: 0 0 8px; font-size: 28px; }
        .topbar p { margin: 0; opacity: .9; }
        nav { margin: 20px 0 24px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        nav a { text-decoration: none; color: #2563eb; background: white; padding: 8px 12px; border-radius: 999px; font-size: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
        nav a:hover { background: #eff6ff; }
        .btn { display: inline-block; margin-top: 8px; color: #2563eb; font-weight: 600; text-decoration: none; }
        .btn-primary { background: #2563eb; color: white; border-radius: 999px; padding: 8px 14px; box-shadow: 0 4px 14px rgba(37,99,235,.16); }
        .btn-primary:hover { background: #1d4ed8; color: white; }
        .card { background: white; border-radius: 14px; padding: 18px; margin-bottom: 16px; box-shadow: 0 4px 16px rgba(0,0,0,.05); }
        .card h2, .card h3 { margin-top: 0; }
        .meta { color: #64748b; font-size: 13px; margin-bottom: 10px; }
        .thumb { max-width: 240px; border-radius: 10px; margin-bottom: 12px; }
        footer { text-align: center; color: #64748b; padding: 24px 0 8px; font-size: 13px; }
        @media (max-width: 700px) { .topbar h1 { font-size: 22px; } .thumb { max-width: 100%; } }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="topbar">
            <h1><a href="{{ url('/') }}" style="text-decoration: none; color: white;">PORTAL BERITA TERKINI</a></h1>
            <p>Berita terbaru, ringkas, dan mudah dibaca.</p>
        </div>

        <nav>
            <a href="{{ url('/') }}">Beranda</a>
            @include('public._nav_categories')
            <a href="{{ url('/admin') }}" class="btn btn-primary">Login / Admin</a>
        </nav>

        <div>
            @yield('content')
        </div>

        <footer>
            &copy; {{ date('Y') }} Portal Berita Sederhana
        </footer>
    </div>
</body>
</html>
