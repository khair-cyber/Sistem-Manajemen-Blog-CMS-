<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id          = (int)($_POST['id']          ?? 0);
$judul       = trim($_POST['judul']        ?? '');
$id_penulis  = (int)($_POST['id_penulis']  ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi']          ?? '');

if ($id <= 0 || !$judul || $id_penulis <= 0 || $id_kategori <= 0 || !$isi) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Get existing gambar
$stmt = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}
$gambar = $row['gambar'];

// Handle new gambar
if (!empty($_FILES['gambar']['tmp_name'])) {
    $file  = $_FILES['gambar'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed_mime)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan.']);
        exit;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }
    if ($gambar && file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    $ext    = pathinfo($file['name'], PATHINFO_EXTENSION);
    $gambar = uniqid('a_', true) . '.' . $ext;
    move_uploaded_file($file['tmp_name'], 'uploads_artikel/' . $gambar);
}

$stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui: ' . $koneksi->error]);
}
