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
        .topbar-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
        .topbar-left { min-width: 250px; flex: 1; }
        .topbar-right { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .search-form { display: flex; background: white; border-radius: 999px; overflow: hidden; }
        .search-form input { border: none; padding: 8px 16px; outline: none; font-size: 14px; width: 150px; }
        .search-form button { border: none; background: #eff6ff; padding: 8px 16px; cursor: pointer; color: #2563eb; font-weight: bold; }
        .btn-light { background: white; color: #2563eb; border-radius: 999px; padding: 8px 14px; text-decoration: none; font-weight: bold; font-size: 14px; box-shadow: 0 4px 14px rgba(0,0,0,.1); }
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
            <div class="topbar-content">
                <div class="topbar-left">
                    <h1><a href="{{ url('/') }}" style="text-decoration: none; color: white;">PORTAL BERITA TERKINI</a></h1>
                    <p>Berita terbaru, ringkas, dan mudah dibaca.</p>
                </div>
                <div class="topbar-right">
                    @if(request()->is('/'))
                    <form class="search-form" action="{{ url('/') }}" method="GET">
                        <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}">
                        <button type="submit">Cari</button>
                    </form>
                    <a href="{{ url('/admin') }}" class="btn-light">Login / Admin</a>
                    @endif
                </div>
            </div>
        </div>

        <nav>
            <a href="{{ url('/') }}">Beranda</a>
            @include('public._nav_categories')
        </nav>

        <div id="main-content">
            @yield('content')
        </div>

        <footer>
            &copy; {{ date('Y') }} Portal Berita Sederhana
        </footer>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="q"]');
            const searchForm = document.querySelector('.search-form');
            const mainContent = document.getElementById('main-content');
            let debounceTimer;

            if (searchInput && searchForm && mainContent) {
                // Sembunyikan tombol 'Cari' karena sudah otomatis
                const searchBtn = searchForm.querySelector('button');
                if(searchBtn) searchBtn.style.display = 'none';
                
                // Mencegah form di-submit manual (reload)
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                });

                // Deteksi setiap ketikan pada kolom pencarian
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    
                    // Beri jeda 300ms agar server tidak berat jika ngetik cepat
                    debounceTimer = setTimeout(() => {
                        const query = this.value;
                        
                        // Ambil data dari server (tanpa reload)
                        fetch('{{ url('/') }}?q=' + encodeURIComponent(query))
                            .then(response => response.text())
                            .then(html => {
                                // Ekstrak HTML yang baru dan masukkan ke main-content
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContent = doc.getElementById('main-content');
                                if (newContent) {
                                    mainContent.innerHTML = newContent.innerHTML;
                                }
                                
                                // Update URL di browser tanpa reload
                                const newUrl = query ? '{{ url('/') }}?q=' + encodeURIComponent(query) : '{{ url('/') }}';
                                window.history.pushState({path: newUrl}, '', newUrl);
                            });
                    }, 300);
                });
            }
        });
    </script>
</body>
</html>
