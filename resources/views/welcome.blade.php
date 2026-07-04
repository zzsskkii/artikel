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
        <h1>Daftar Artikel (Admin)</h1>
        <div>
            <a href="{{ url('/') }}" target="_blank" style="margin-right: 1rem;">Lihat Web Publik</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
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

    <div id="overlay" class="overlay" onclick="closeModal()"></div>
    
    <div id="modal" class="modal">
        <h2 id="modalTitle">Tambah Artikel</h2>
        <form id="articleForm">
            <div class="form-group">
                <label>Judul Artikel</label>
                <input type="text" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label>ID Kategori</label>
                <input type="number" id="kategori_id" name="kategori_id" required>
            </div>
            <div class="form-group">
                <label>Posisi Tampil</label>
                <input type="text" id="posisi" name="posisi">
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
