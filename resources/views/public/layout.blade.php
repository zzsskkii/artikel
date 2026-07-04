<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Berita</title>
</head>
<body style="font-family: sans-serif; margin: 2rem;">

    <h1><a href="{{ url('/') }}" style="text-decoration: none; color: black;">PORTAL BERITA TERKINI</a></h1>
    <hr>

    <nav style="margin-bottom: 2rem;">
        <a href="{{ url('/') }}">Beranda</a> |
        @foreach($categories as $cat)
            <a href="{{ url('/kategori/'.$cat->id) }}">{{ $cat->name_categori }}</a> |
        @endforeach
        <a href="{{ url('/admin') }}">Login / Admin</a>
    </nav>

    <div>
        @yield('content')
    </div>

    <hr style="margin-top: 2rem;">
    <p>&copy; {{ date('Y') }} Portal Berita Sederhana</p>

</body>
</html>
