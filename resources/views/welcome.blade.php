<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Artikel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Daftar Artikel ({{ auth()->user()->role === 'admin' ? 'Admin' : 'Reporter' }})</h1>
        <div>
            <a href="{{ url('/') }}" target="_blank" style="margin-right: 1rem;">Lihat Web Publik</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <script>
        const USER_ROLE = '{{ auth()->user()->role }}';
    </script>

    @if(auth()->user()->role === 'admin')
        <div style="margin-bottom: 1rem;">
            <button onclick="showTab('articles')" id="btnTabArticles">Kelola Artikel</button>
            <button onclick="showTab('reporters')" id="btnTabReporters" style="background: #ccc; color: black;">Kelola Reporter</button>
        </div>
    @endif

    <div id="articlesSection">
        <button onclick="openModal()" style="margin-bottom: 1rem;">Tambah Artikel</button>
        <div id="status">Loading...</div>
        <table id="articleTable" style="display:none;">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Posisi</th>
                <th>Reporter</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody">
        </tbody>
    </table>
    </div>

    @if(auth()->user()->role === 'admin')
    <div id="reportersSection" style="display: none;">
        <div id="statusReporters">Loading reporters...</div>
        <table id="reporterTable" style="display:none;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBodyReporters">
            </tbody>
        </table>
    </div>
    @endif

    <div id="overlay" class="overlay" onclick="closeModal()"></div>

    <div id="modal" class="modal">
        <h2 id="modalTitle">Tambah Artikel</h2>
        <form id="articleForm">
            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" id="kategori_nama" name="kategori_nama" list="kategoriList" autocomplete="off" required>
                <datalist id="kategoriList">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name_categori }}">
                    @endforeach
                </datalist>
            </div>
            <div class="form-group">
                <label>Posisi Tampil</label>
                <select id="posisi" name="posisi">
                    <option value="">- Pilih Posisi -</option>
                    <option value="Utama">Utama (Headline)</option>
                    <option value="Populer">Populer</option>
                    <option value="Sidebar">Sidebar</option>
                    <option value="Bawah">Bawah (Footer)</option>
                </select>
            </div>
            <div class="form-group" style="display:none;">
                <input type="hidden" id="reporter" name="reporter" value="1">
            </div>
            <div class="form-group">
                <label>Isi Konten</label>
                <textarea id="isi" name="isi" required></textarea>
            </div>
            <div class="form-group">
                <label>Foto Thumbnail</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>
            <button type="button" onclick="closeModal()">Batal</button>
            <button type="submit">Simpan</button>
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
