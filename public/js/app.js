const API_URL = '/api/articles';
const STORAGE_URL = '/storage/';

let articles = [];
let editingId = null;

const statusDiv = document.getElementById('status');
const table = document.getElementById('articleTable');
const tbody = document.getElementById('tableBody');
const modal = document.getElementById('modal');
const overlay = document.getElementById('overlay');
const form = document.getElementById('articleForm');
const modalTitle = document.getElementById('modalTitle');

document.addEventListener('DOMContentLoaded', fetchArticles);

async function fetchArticles() {
    statusDiv.textContent = 'Loading...';
    try {
        const res = await fetch(API_URL);
        const json = await res.json();
        articles = json.data || [];
        render();
        statusDiv.style.display = 'none';
        table.style.display = 'table';
    } catch (e) {
        statusDiv.textContent = 'Error loading data.';
    }
}

function render() {
    tbody.innerHTML = '';
    if(articles.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6">Tidak ada artikel.</td></tr>';
        return;
    }
    articles.forEach(a => {
        const tr = document.createElement('tr');
        const img = a.foto ? `<img src="${STORAGE_URL}${a.foto}" class="thumb">` : 'Tidak ada foto';
        const cat = a.category ? a.category.nama : a.kategori_id;
        
        tr.innerHTML = `
            <td>${img}</td>
            <td>${a.judul}</td>
            <td>${cat}</td>
            <td>${a.posisi || '-'}</td>
            <td>${a.reporter}</td>
            <td>
                <a href="/berita/${a.id}" target="_blank" style="text-decoration:none;">
                    <button type="button">Lihat</button>
                </a>
                <button onclick="edit(${a.id})">Edit</button>
                <button onclick="del(${a.id})">Hapus</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

window.openModal = function(isEdit = false) {
    modal.classList.add('active');
    overlay.classList.add('active');
    if(!isEdit) {
        editingId = null;
        form.reset();
        modalTitle.textContent = 'Tambah Artikel';
    } else {
        modalTitle.textContent = 'Edit Artikel';
    }
};

window.closeModal = function() {
    modal.classList.remove('active');
    overlay.classList.remove('active');
};

window.edit = function(id) {
    const a = articles.find(x => x.id === id);
    if(!a) return;
    editingId = id;
    document.getElementById('judul').value = a.judul;
    document.getElementById('kategori_id').value = a.kategori_id;
    document.getElementById('posisi').value = a.posisi || '';
    document.getElementById('reporter').value = a.reporter;
    document.getElementById('isi').value = a.isi;
    openModal(true);
};

window.del = async function(id) {
    if(!confirm('Hapus artikel ini?')) return;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    await fetch(`${API_URL}/${id}`, { 
        method: 'DELETE', 
        headers: { 
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        } 
    });
    fetchArticles();
};

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const url = editingId ? `${API_URL}/${editingId}` : API_URL;
    if(editingId) fd.append('_method', 'PUT');
    
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    await fetch(url, { 
        method: 'POST', 
        headers: { 
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        }, 
        body: fd 
    });
    closeModal();
    fetchArticles();
});
