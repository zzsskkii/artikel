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

document.addEventListener('DOMContentLoaded', () => {
    fetchArticles();
    if (typeof USER_ROLE !== 'undefined' && USER_ROLE === 'admin') {
        fetchReporters();
    }
});

window.showTab = function(tab) {
    if (tab === 'articles') {
        document.getElementById('articlesSection').style.display = 'block';
        document.getElementById('reportersSection').style.display = 'none';
        document.getElementById('btnTabArticles').style.background = '#2563eb';
        document.getElementById('btnTabArticles').style.color = 'white';
        document.getElementById('btnTabReporters').style.background = '#ccc';
        document.getElementById('btnTabReporters').style.color = 'black';
    } else {
        document.getElementById('articlesSection').style.display = 'none';
        document.getElementById('reportersSection').style.display = 'block';
        document.getElementById('btnTabArticles').style.background = '#ccc';
        document.getElementById('btnTabArticles').style.color = 'black';
        document.getElementById('btnTabReporters').style.background = '#2563eb';
        document.getElementById('btnTabReporters').style.color = 'white';
    }
};

let reporters = [];
async function fetchReporters() {
    const statusReporters = document.getElementById('statusReporters');
    const tableRep = document.getElementById('reporterTable');
    try {
        const res = await fetch('/api/reporters');
        const json = await res.json();
        reporters = json.data || [];
        
        const tbodyRep = document.getElementById('tableBodyReporters');
        tbodyRep.innerHTML = '';
        if(reporters.length === 0) {
            tbodyRep.innerHTML = '<tr><td colspan="6">Tidak ada reporter.</td></tr>';
        } else {
            reporters.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${r.nama}</td>
                    <td>${r.username}</td>
                    <td>${r.email}</td>
                    <td>${r.tanggal_lahir || '-'}</td>
                    <td>${r.umur || '-'}</td>
                    <td>${r.alamat || '-'}</td>
                    <td><button onclick="filterArticlesByReporter('${r.nama}')">Lihat Pekerjaan</button></td>
                `;
                tbodyRep.appendChild(tr);
            });
        }
        statusReporters.style.display = 'none';
        tableRep.style.display = 'table';
    } catch (e) {
        statusReporters.textContent = 'Error loading reporters.';
    }
}

window.filterArticlesByReporter = function(reporterName) {
    showTab('articles');
    
    const rows = tbody.querySelectorAll('tr');
    rows.forEach(row => {
        const reporterCell = row.cells[4];
        if (reporterCell && reporterCell.textContent === reporterName) {
            row.style.display = '';
        } else if (reporterCell) {
            row.style.display = 'none';
        }
    });

    let statusFilter = document.getElementById('statusFilter');
    if (!statusFilter) {
        statusFilter = document.createElement('div');
        statusFilter.id = 'statusFilter';
        statusFilter.style.marginBottom = '1rem';
        statusFilter.style.color = '#2563eb';
        document.getElementById('articlesSection').insertBefore(statusFilter, document.getElementById('articleTable'));
    }
    statusFilter.innerHTML = `Menampilkan artikel oleh: <b>${reporterName}</b> <button onclick="resetFilter()" style="margin-left: 10px; padding: 0.2rem 0.5rem; font-size: 0.8rem;">Tampilkan Semua</button>`;
};

window.resetFilter = function() {
    const rows = tbody.querySelectorAll('tr');
    rows.forEach(row => row.style.display = '');
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) statusFilter.innerHTML = '';
};

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
        const cat = a.category ? a.category.name_categori : a.kategori_id;
        const rep = a.reporter ? a.reporter.nama : a.reporter_id;
        
        tr.innerHTML = `
            <td>${img}</td>
            <td>${a.judul}</td>
            <td>${cat}</td>
            <td>${a.posisi || '-'}</td>
            <td>${rep}</td>
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
    document.getElementById('kategori_nama').value = a.category ? a.category.name_categori : '';
    document.getElementById('posisi').value = a.posisi || '';
    document.getElementById('reporter').value = a.reporter ? a.reporter.id : (a.reporter_id || '');
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
