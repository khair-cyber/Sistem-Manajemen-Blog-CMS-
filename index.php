<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; color: #333; min-height: 100vh; display: flex; flex-direction: column; }

  /* HEADER */
  .header {
    background: #1e2a3a;
    color: #fff;
    padding: 14px 24px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
  }
  .header-icon {
    background: rgba(255,255,255,0.15);
    width: 38px; height: 38px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .header-title { font-size: 17px; font-weight: 700; line-height: 1.2; }
  .header-sub { font-size: 11px; color: #a0b0c0; }

  /* LAYOUT */
  .layout { display: flex; margin-top: 66px; min-height: calc(100vh - 66px); }

  /* SIDEBAR */
  .sidebar {
    width: 200px; min-width: 200px;
    background: #fff;
    border-right: 1px solid #e2e8f0;
    padding: 20px 0;
    position: fixed; top: 66px; left: 0; bottom: 0;
    overflow-y: auto;
  }
  .sidebar-label {
    font-size: 10px; font-weight: 700;
    color: #94a3b8; letter-spacing: 1px;
    padding: 0 18px 8px;
    text-transform: uppercase;
  }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 18px;
    cursor: pointer;
    color: #4a5568;
    font-size: 13.5px;
    border-left: 3px solid transparent;
    transition: all 0.2s;
    text-decoration: none;
  }
  .nav-item:hover { background: #f7fafc; color: #2d7d46; }
  .nav-item.active {
    background: #f0faf4;
    color: #2d7d46;
    border-left-color: #2d7d46;
    font-weight: 600;
  }
  .nav-item i { width: 16px; text-align: center; font-size: 14px; }

  /* MAIN CONTENT */
  .content {
    margin-left: 200px;
    flex: 1;
    padding: 28px;
  }

  /* SECTION HEADER */
  .section-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
  }
  .section-title { font-size: 20px; font-weight: 700; color: #1e2a3a; }

  /* BUTTONS */
  .btn {
    padding: 8px 16px;
    border: none; border-radius: 5px;
    cursor: pointer; font-size: 13px; font-weight: 600;
    transition: opacity 0.2s, transform 0.1s;
    display: inline-flex; align-items: center; gap: 6px;
  }
  .btn:hover { opacity: 0.88; }
  .btn:active { transform: scale(0.97); }
  .btn-success { background: #28a745; color: #fff; }
  .btn-primary { background: #007bff; color: #fff; }
  .btn-danger  { background: #dc3545; color: #fff; }
  .btn-secondary { background: #6c757d; color: #fff; }
  .btn-sm { padding: 5px 12px; font-size: 12px; }

  /* CARD */
  .card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    padding: 0;
    overflow: hidden;
  }

  /* TABLE */
  .table-wrapper { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px; font-weight: 700; letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 12px 16px;
    border-bottom: 2px solid #e2e8f0;
    text-align: left;
  }
  tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #f8fafc; }
  tbody td { padding: 12px 16px; vertical-align: middle; }

  /* BADGES */
  .badge {
    display: inline-block;
    padding: 3px 10px; border-radius: 4px;
    font-size: 11.5px; font-weight: 600;
    background: #dbeafe; color: #1d4ed8;
  }

  /* FOTO THUMBNAIL */
  .foto-thumb {
    width: 42px; height: 42px;
    border-radius: 6px; object-fit: cover;
    background: #e2e8f0;
    border: 2px solid #e2e8f0;
  }
  .foto-ext {
    width: 42px; height: 42px;
    border-radius: 6px;
    background: #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 700; color: #64748b;
    border: 2px solid #e2e8f0;
  }

  /* PASSWORD MASK */
  .pw-mask { color: #94a3b8; font-size: 13px; letter-spacing: 1px; }

  /* MODAL OVERLAY */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 200;
    align-items: center; justify-content: center;
  }
  .modal-overlay.show { display: flex; }
  .modal {
    background: #fff;
    border-radius: 10px;
    padding: 28px;
    width: 480px; max-width: 95vw;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: fadeUp 0.2s ease;
  }
  @keyframes fadeUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
  }
  .modal-title { font-size: 17px; font-weight: 700; margin-bottom: 20px; color: #1e2a3a; }
  .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }

  /* CONFIRM MODAL */
  .confirm-modal {
    text-align: center;
    padding: 36px 28px;
  }
  .confirm-icon {
    width: 56px; height: 56px;
    background: #ffe4e4; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px; color: #dc3545;
  }
  .confirm-title { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
  .confirm-sub { font-size: 13px; color: #94a3b8; margin-bottom: 22px; }
  .confirm-btns { display: flex; justify-content: center; gap: 12px; }

  /* FORM ELEMENTS */
  .form-group { margin-bottom: 16px; }
  .form-row { display: flex; gap: 14px; }
  .form-row .form-group { flex: 1; }
  label { display: block; font-size: 12.5px; font-weight: 600; margin-bottom: 5px; color: #374151; }
  input[type=text], input[type=password], textarea, select {
    width: 100%; padding: 9px 12px;
    border: 1.5px solid #d1d5db; border-radius: 6px;
    font-size: 13.5px; color: #333;
    transition: border-color 0.2s;
    font-family: inherit;
  }
  input[type=text]:focus, input[type=password]:focus, textarea:focus, select:focus {
    outline: none; border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40,167,69,0.12);
  }
  textarea { resize: vertical; min-height: 90px; }
  select { background: #fff; }
  input[type=file] { font-size: 13px; }
  .form-hint { font-size: 11px; color: #94a3b8; margin-top: 4px; }

  /* TOAST */
  #toast {
    position: fixed; bottom: 28px; right: 28px;
    background: #1e2a3a; color: #fff;
    padding: 12px 20px; border-radius: 8px;
    font-size: 13.5px; font-weight: 500;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    z-index: 999; opacity: 0; pointer-events: none;
    transition: opacity 0.3s;
  }
  #toast.show { opacity: 1; }
  #toast.success { background: #28a745; }
  #toast.error   { background: #dc3545; }

  /* LOADING */
  .loading { text-align: center; padding: 40px; color: #94a3b8; font-size: 14px; }
</style>
</head>
<body>

<!-- HEADER -->
<header class="header">
  <div class="header-icon"><i class="fa-solid fa-newspaper"></i></div>
  <div>
    <div class="header-title">Sistem Manajemen Blog (CMS)</div>
    <div class="header-sub">Blog Keren</div>
  </div>
</header>

<!-- LAYOUT -->
<div class="layout">

  <!-- SIDEBAR -->
  <nav class="sidebar">
    <div class="sidebar-label">Menu Utama</div>
    <div class="nav-item active" id="nav-penulis" onclick="setMenu('penulis')">
      <i class="fa-solid fa-user-pen"></i> Kelola Penulis
    </div>
    <div class="nav-item" id="nav-artikel" onclick="setMenu('artikel')">
      <i class="fa-regular fa-file-lines"></i> Kelola Artikel
    </div>
    <div class="nav-item" id="nav-kategori" onclick="setMenu('kategori')">
      <i class="fa-regular fa-folder"></i> Kelola Kategori
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="content" id="main-content">
    <div class="loading"><i class="fa-solid fa-spinner fa-spin"></i> Memuat data...</div>
  </main>
</div>

<!-- ========== MODAL PENULIS TAMBAH ========== -->
<div class="modal-overlay" id="modal-tambah-penulis">
  <div class="modal">
    <div class="modal-title">Tambah Penulis</div>
    <div class="form-row">
      <div class="form-group">
        <label>Nama Depan</label>
        <input type="text" id="tp-nama-depan" placeholder="Nama depan...">
      </div>
      <div class="form-group">
        <label>Nama Belakang</label>
        <input type="text" id="tp-nama-belakang" placeholder="Nama belakang...">
      </div>
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" id="tp-username" placeholder="Username unik...">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" id="tp-password" placeholder="Password...">
    </div>
    <div class="form-group">
      <label>Foto Profil</label>
      <input type="file" id="tp-foto" accept="image/*">
      <div class="form-hint">Opsional. Maks 2 MB.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-penulis')">Batal</button>
      <button class="btn btn-success" onclick="simpanPenulis()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- ========== MODAL PENULIS EDIT ========== -->
<div class="modal-overlay" id="modal-edit-penulis">
  <div class="modal">
    <div class="modal-title">Edit Penulis</div>
    <input type="hidden" id="ep-id">
    <div class="form-row">
      <div class="form-group">
        <label>Nama Depan</label>
        <input type="text" id="ep-nama-depan">
      </div>
      <div class="form-group">
        <label>Nama Belakang</label>
        <input type="text" id="ep-nama-belakang">
      </div>
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" id="ep-username">
    </div>
    <div class="form-group">
      <label>Password Baru <span style="color:#94a3b8;font-weight:400">(kosongkan jika tidak diganti)</span></label>
      <input type="password" id="ep-password" placeholder="Password baru...">
    </div>
    <div class="form-group">
      <label>Foto Profil <span style="color:#94a3b8;font-weight:400">(kosongkan jika tidak diganti)</span></label>
      <input type="file" id="ep-foto" accept="image/*">
      <div class="form-hint">Maks 2 MB.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-edit-penulis')">Batal</button>
      <button class="btn btn-success" onclick="updatePenulis()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ========== MODAL ARTIKEL TAMBAH ========== -->
<div class="modal-overlay" id="modal-tambah-artikel">
  <div class="modal">
    <div class="modal-title">Tambah Artikel</div>
    <div class="form-group">
      <label>Judul</label>
      <input type="text" id="ta-judul" placeholder="Judul artikel...">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Penulis</label>
        <select id="ta-penulis"></select>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select id="ta-kategori"></select>
      </div>
    </div>
    <div class="form-group">
      <label>Isi Artikel</label>
      <textarea id="ta-isi" placeholder="Tulis isi artikel di sini..." rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Gambar</label>
      <input type="file" id="ta-gambar" accept="image/*">
      <div class="form-hint">Opsional. Maks 2 MB.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-artikel')">Batal</button>
      <button class="btn btn-success" onclick="simpanArtikel()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- ========== MODAL ARTIKEL EDIT ========== -->
<div class="modal-overlay" id="modal-edit-artikel">
  <div class="modal">
    <div class="modal-title">Edit Artikel</div>
    <input type="hidden" id="ea-id">
    <div class="form-group">
      <label>Judul</label>
      <input type="text" id="ea-judul">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Penulis</label>
        <select id="ea-penulis"></select>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select id="ea-kategori"></select>
      </div>
    </div>
    <div class="form-group">
      <label>Isi Artikel</label>
      <textarea id="ea-isi" rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Gambar <span style="color:#94a3b8;font-weight:400">(kosongkan jika tidak diganti)</span></label>
      <input type="file" id="ea-gambar" accept="image/*">
      <div class="form-hint">Maks 2 MB.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-edit-artikel')">Batal</button>
      <button class="btn btn-success" onclick="updateArtikel()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ========== MODAL KATEGORI TAMBAH ========== -->
<div class="modal-overlay" id="modal-tambah-kategori">
  <div class="modal">
    <div class="modal-title">Tambah Kategori</div>
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" id="tk-nama" placeholder="Nama kategori...">
    </div>
    <div class="form-group">
      <label>Keterangan</label>
      <textarea id="tk-keterangan" placeholder="Deskripsi kategori..."></textarea>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-kategori')">Batal</button>
      <button class="btn btn-success" onclick="simpanKategori()">Simpan Data</button>
    </div>
  </div>
</div>

<!-- ========== MODAL KATEGORI EDIT ========== -->
<div class="modal-overlay" id="modal-edit-kategori">
  <div class="modal">
    <div class="modal-title">Edit Kategori</div>
    <input type="hidden" id="ek-id">
    <div class="form-group">
      <label>Nama Kategori</label>
      <input type="text" id="ek-nama">
    </div>
    <div class="form-group">
      <label>Keterangan</label>
      <textarea id="ek-keterangan"></textarea>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="tutupModal('modal-edit-kategori')">Batal</button>
      <button class="btn btn-success" onclick="updateKategori()">Simpan Perubahan</button>
    </div>
  </div>
</div>

<!-- ========== MODAL KONFIRMASI HAPUS ========== -->
<div class="modal-overlay" id="modal-hapus">
  <div class="modal" style="width:380px">
    <div class="confirm-modal">
      <div class="confirm-icon"><i class="fa-solid fa-trash"></i></div>
      <div class="confirm-title">Hapus data ini?</div>
      <div class="confirm-sub">Data yang dihapus tidak dapat dikembalikan.</div>
      <div class="confirm-btns">
        <button class="btn btn-secondary" onclick="tutupModal('modal-hapus')">Batal</button>
        <button class="btn btn-danger" id="btn-konfirm-hapus">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
// ============================================================
// GLOBAL STATE
// ============================================================
let menuAktif = 'penulis';

// ============================================================
// NAVIGATION
// ============================================================
function setMenu(menu) {
  menuAktif = menu;
  document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
  document.getElementById('nav-' + menu).classList.add('active');
  if (menu === 'penulis') tampilkanPenulis();
  else if (menu === 'artikel') tampilkanArtikel();
  else if (menu === 'kategori') tampilkanKategori();
}

// ============================================================
// TOAST
// ============================================================
function showToast(msg, type = 'success') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'show ' + type;
  setTimeout(() => { t.className = ''; }, 3000);
}

// ============================================================
// MODAL HELPERS
// ============================================================
function bukaModal(id) {
  document.getElementById(id).classList.add('show');
}
function tutupModal(id) {
  document.getElementById(id).classList.remove('show');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
  });
});

// ============================================================
// =================== KELOLA PENULIS ========================
// ============================================================
function tampilkanPenulis() {
  const mc = document.getElementById('main-content');
  mc.innerHTML = '<div class="loading"><i class="fa-solid fa-spinner fa-spin"></i> Memuat data...</div>';
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(data => {
      let rows = '';
      if (data.length === 0) {
        rows = '<tr><td colspan="5" style="text-align:center;padding:30px;color:#94a3b8">Belum ada data penulis.</td></tr>';
      } else {
        data.forEach(p => {
          const foto = `<img src="uploads_penulis/${escHtml(p.foto || 'default.png')}" class="foto-thumb" alt="foto" onerror="this.src='uploads_penulis/default.png'">`;
          rows += `<tr>
            <td>${foto}</td>
            <td>${escHtml(p.nama_depan + ' ' + p.nama_belakang)}</td>
            <td><span class="badge">${escHtml(p.user_name)}</span></td>
            <td class="pw-mask">${escHtml(p.password.substring(0,14))}...</td>
            <td>
              <button class="btn btn-primary btn-sm" onclick="editPenulis(${p.id})"><i class="fa-solid fa-pen"></i> Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusPenulis(${p.id})" style="margin-left:4px"><i class="fa-solid fa-trash"></i> Hapus</button>
            </td>
          </tr>`;
        });
      }
      mc.innerHTML = `
        <div class="section-header">
          <div class="section-title">Data Penulis</div>
          <button class="btn btn-success" onclick="bukaModalTambahPenulis()"><i class="fa-solid fa-plus"></i> Tambah Penulis</button>
        </div>
        <div class="card">
          <div class="table-wrapper">
            <table>
              <thead><tr>
                <th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th>
              </tr></thead>
              <tbody>${rows}</tbody>
            </table>
          </div>
        </div>`;
    })
    .catch(() => showToast('Gagal memuat data penulis.', 'error'));
}

function bukaModalTambahPenulis() {
  document.getElementById('tp-nama-depan').value = '';
  document.getElementById('tp-nama-belakang').value = '';
  document.getElementById('tp-username').value = '';
  document.getElementById('tp-password').value = '';
  document.getElementById('tp-foto').value = '';
  bukaModal('modal-tambah-penulis');
}

function simpanPenulis() {
  const fd = new FormData();
  fd.append('nama_depan', document.getElementById('tp-nama-depan').value.trim());
  fd.append('nama_belakang', document.getElementById('tp-nama-belakang').value.trim());
  fd.append('username', document.getElementById('tp-username').value.trim());
  fd.append('password', document.getElementById('tp-password').value);
  const foto = document.getElementById('tp-foto').files[0];
  if (foto) fd.append('foto', foto);

  fetch('simpan_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-tambah-penulis');
        showToast('Penulis berhasil ditambahkan!');
        tampilkanPenulis();
      } else {
        showToast(res.pesan || 'Gagal menyimpan.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function editPenulis(id) {
  fetch('ambil_satu_penulis.php?id=' + id)
    .then(r => r.json())
    .then(p => {
      document.getElementById('ep-id').value = p.id;
      document.getElementById('ep-nama-depan').value = p.nama_depan;
      document.getElementById('ep-nama-belakang').value = p.nama_belakang;
      document.getElementById('ep-username').value = p.user_name;
      document.getElementById('ep-password').value = '';
      document.getElementById('ep-foto').value = '';
      bukaModal('modal-edit-penulis');
    }).catch(() => showToast('Gagal memuat data.', 'error'));
}

function updatePenulis() {
  const fd = new FormData();
  fd.append('id', document.getElementById('ep-id').value);
  fd.append('nama_depan', document.getElementById('ep-nama-depan').value.trim());
  fd.append('nama_belakang', document.getElementById('ep-nama-belakang').value.trim());
  fd.append('username', document.getElementById('ep-username').value.trim());
  fd.append('password', document.getElementById('ep-password').value);
  const foto = document.getElementById('ep-foto').files[0];
  if (foto) fd.append('foto', foto);

  fetch('update_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-edit-penulis');
        showToast('Penulis berhasil diperbarui!');
        tampilkanPenulis();
      } else {
        showToast(res.pesan || 'Gagal memperbarui.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function konfirmasiHapusPenulis(id) {
  bukaModal('modal-hapus');
  document.getElementById('btn-konfirm-hapus').onclick = function() {
    fetch('hapus_penulis.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'id=' + id
    }).then(r => r.json())
      .then(res => {
        tutupModal('modal-hapus');
        if (res.status === 'ok') {
          showToast('Penulis berhasil dihapus!');
          tampilkanPenulis();
        } else {
          showToast(res.pesan || 'Gagal menghapus.', 'error');
        }
      }).catch(() => showToast('Terjadi kesalahan.', 'error'));
  };
}

// ============================================================
// =================== KELOLA ARTIKEL ========================
// ============================================================
function tampilkanArtikel() {
  const mc = document.getElementById('main-content');
  mc.innerHTML = '<div class="loading"><i class="fa-solid fa-spinner fa-spin"></i> Memuat data...</div>';
  fetch('ambil_artikel.php')
    .then(r => r.json())
    .then(data => {
      let rows = '';
      if (data.length === 0) {
        rows = '<tr><td colspan="6" style="text-align:center;padding:30px;color:#94a3b8">Belum ada data artikel.</td></tr>';
      } else {
        data.forEach(a => {
          const gambarSrc = a.gambar ? 'uploads_artikel/' + a.gambar : 'uploads_artikel/default.png';
          rows += `<tr>
            <td><img src="${gambarSrc}" class="foto-thumb" alt="gambar" onerror="this.src='uploads_artikel/default.png'"></td>
            <td>${escHtml(a.judul)}</td>
            <td><span class="badge">${escHtml(a.nama_kategori)}</span></td>
            <td>${escHtml(a.nama_depan + ' ' + a.nama_belakang)}</td>
            <td style="font-size:12px;color:#64748b">${escHtml(a.hari_tanggal)}</td>
            <td>
              <button class="btn btn-primary btn-sm" onclick="editArtikel(${a.id})"><i class="fa-solid fa-pen"></i> Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusArtikel(${a.id})" style="margin-left:4px"><i class="fa-solid fa-trash"></i> Hapus</button>
            </td>
          </tr>`;
        });
      }
      mc.innerHTML = `
        <div class="section-header">
          <div class="section-title">Data Artikel</div>
          <button class="btn btn-success" onclick="bukaModalTambahArtikel()"><i class="fa-solid fa-plus"></i> Tambah Artikel</button>
        </div>
        <div class="card">
          <div class="table-wrapper">
            <table>
              <thead><tr>
                <th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th>
              </tr></thead>
              <tbody>${rows}</tbody>
            </table>
          </div>
        </div>`;
    }).catch(() => showToast('Gagal memuat data artikel.', 'error'));
}

function bukaModalTambahArtikel() {
  document.getElementById('ta-judul').value = '';
  document.getElementById('ta-isi').value = '';
  document.getElementById('ta-gambar').value = '';
  // Load dropdown
  Promise.all([
    fetch('ambil_penulis.php').then(r => r.json()),
    fetch('ambil_kategori.php').then(r => r.json())
  ]).then(([penulis, kategori]) => {
    const sp = document.getElementById('ta-penulis');
    const sk = document.getElementById('ta-kategori');
    sp.innerHTML = penulis.map(p => `<option value="${p.id}">${escHtml(p.nama_depan + ' ' + p.nama_belakang)}</option>`).join('');
    sk.innerHTML = kategori.map(k => `<option value="${k.id}">${escHtml(k.nama_kategori)}</option>`).join('');
    bukaModal('modal-tambah-artikel');
  });
}

function simpanArtikel() {
  const fd = new FormData();
  fd.append('judul', document.getElementById('ta-judul').value.trim());
  fd.append('id_penulis', document.getElementById('ta-penulis').value);
  fd.append('id_kategori', document.getElementById('ta-kategori').value);
  fd.append('isi', document.getElementById('ta-isi').value.trim());
  const gambar = document.getElementById('ta-gambar').files[0];
  if (gambar) fd.append('gambar', gambar);

  fetch('simpan_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-tambah-artikel');
        showToast('Artikel berhasil ditambahkan!');
        tampilkanArtikel();
      } else {
        showToast(res.pesan || 'Gagal menyimpan.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function editArtikel(id) {
  Promise.all([
    fetch('ambil_satu_artikel.php?id=' + id).then(r => r.json()),
    fetch('ambil_penulis.php').then(r => r.json()),
    fetch('ambil_kategori.php').then(r => r.json())
  ]).then(([a, penulis, kategori]) => {
    document.getElementById('ea-id').value = a.id;
    document.getElementById('ea-judul').value = a.judul;
    document.getElementById('ea-isi').value = a.isi;
    document.getElementById('ea-gambar').value = '';

    const sp = document.getElementById('ea-penulis');
    const sk = document.getElementById('ea-kategori');
    sp.innerHTML = penulis.map(p => `<option value="${p.id}" ${p.id == a.id_penulis ? 'selected' : ''}>${escHtml(p.nama_depan + ' ' + p.nama_belakang)}</option>`).join('');
    sk.innerHTML = kategori.map(k => `<option value="${k.id}" ${k.id == a.id_kategori ? 'selected' : ''}>${escHtml(k.nama_kategori)}</option>`).join('');

    bukaModal('modal-edit-artikel');
  }).catch(() => showToast('Gagal memuat data.', 'error'));
}

function updateArtikel() {
  const fd = new FormData();
  fd.append('id', document.getElementById('ea-id').value);
  fd.append('judul', document.getElementById('ea-judul').value.trim());
  fd.append('id_penulis', document.getElementById('ea-penulis').value);
  fd.append('id_kategori', document.getElementById('ea-kategori').value);
  fd.append('isi', document.getElementById('ea-isi').value.trim());
  const gambar = document.getElementById('ea-gambar').files[0];
  if (gambar) fd.append('gambar', gambar);

  fetch('update_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-edit-artikel');
        showToast('Artikel berhasil diperbarui!');
        tampilkanArtikel();
      } else {
        showToast(res.pesan || 'Gagal memperbarui.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function konfirmasiHapusArtikel(id) {
  bukaModal('modal-hapus');
  document.getElementById('btn-konfirm-hapus').onclick = function() {
    fetch('hapus_artikel.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'id=' + id
    }).then(r => r.json())
      .then(res => {
        tutupModal('modal-hapus');
        if (res.status === 'ok') {
          showToast('Artikel berhasil dihapus!');
          tampilkanArtikel();
        } else {
          showToast(res.pesan || 'Gagal menghapus.', 'error');
        }
      }).catch(() => showToast('Terjadi kesalahan.', 'error'));
  };
}

// ============================================================
// =================== KELOLA KATEGORI =======================
// ============================================================
function tampilkanKategori() {
  const mc = document.getElementById('main-content');
  mc.innerHTML = '<div class="loading"><i class="fa-solid fa-spinner fa-spin"></i> Memuat data...</div>';
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(data => {
      let rows = '';
      if (data.length === 0) {
        rows = '<tr><td colspan="3" style="text-align:center;padding:30px;color:#94a3b8">Belum ada data kategori.</td></tr>';
      } else {
        data.forEach(k => {
          rows += `<tr>
            <td><span class="badge">${escHtml(k.nama_kategori)}</span></td>
            <td>${escHtml(k.keterangan || '-')}</td>
            <td>
              <button class="btn btn-primary btn-sm" onclick="editKategori(${k.id})"><i class="fa-solid fa-pen"></i> Edit</button>
              <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusKategori(${k.id})" style="margin-left:4px"><i class="fa-solid fa-trash"></i> Hapus</button>
            </td>
          </tr>`;
        });
      }
      mc.innerHTML = `
        <div class="section-header">
          <div class="section-title">Data Kategori Artikel</div>
          <button class="btn btn-success" onclick="bukaModalTambahKategori()"><i class="fa-solid fa-plus"></i> Tambah Kategori</button>
        </div>
        <div class="card">
          <div class="table-wrapper">
            <table>
              <thead><tr>
                <th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th>
              </tr></thead>
              <tbody>${rows}</tbody>
            </table>
          </div>
        </div>`;
    }).catch(() => showToast('Gagal memuat data kategori.', 'error'));
}

function bukaModalTambahKategori() {
  document.getElementById('tk-nama').value = '';
  document.getElementById('tk-keterangan').value = '';
  bukaModal('modal-tambah-kategori');
}

function simpanKategori() {
  const fd = new FormData();
  fd.append('nama_kategori', document.getElementById('tk-nama').value.trim());
  fd.append('keterangan', document.getElementById('tk-keterangan').value.trim());

  fetch('simpan_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-tambah-kategori');
        showToast('Kategori berhasil ditambahkan!');
        tampilkanKategori();
      } else {
        showToast(res.pesan || 'Gagal menyimpan.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function editKategori(id) {
  fetch('ambil_satu_kategori.php?id=' + id)
    .then(r => r.json())
    .then(k => {
      document.getElementById('ek-id').value = k.id;
      document.getElementById('ek-nama').value = k.nama_kategori;
      document.getElementById('ek-keterangan').value = k.keterangan || '';
      bukaModal('modal-edit-kategori');
    }).catch(() => showToast('Gagal memuat data.', 'error'));
}

function updateKategori() {
  const fd = new FormData();
  fd.append('id', document.getElementById('ek-id').value);
  fd.append('nama_kategori', document.getElementById('ek-nama').value.trim());
  fd.append('keterangan', document.getElementById('ek-keterangan').value.trim());

  fetch('update_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.status === 'ok') {
        tutupModal('modal-edit-kategori');
        showToast('Kategori berhasil diperbarui!');
        tampilkanKategori();
      } else {
        showToast(res.pesan || 'Gagal memperbarui.', 'error');
      }
    }).catch(() => showToast('Terjadi kesalahan.', 'error'));
}

function konfirmasiHapusKategori(id) {
  bukaModal('modal-hapus');
  document.getElementById('btn-konfirm-hapus').onclick = function() {
    fetch('hapus_kategori.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'id=' + id
    }).then(r => r.json())
      .then(res => {
        tutupModal('modal-hapus');
        if (res.status === 'ok') {
          showToast('Kategori berhasil dihapus!');
          tampilkanKategori();
        } else {
          showToast(res.pesan || 'Gagal menghapus.', 'error');
        }
      }).catch(() => showToast('Terjadi kesalahan.', 'error'));
  };
}

// ============================================================
// UTILS
// ============================================================
function escHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// ============================================================
// INIT
// ============================================================
setMenu('penulis');
</script>
</body>
</html>
