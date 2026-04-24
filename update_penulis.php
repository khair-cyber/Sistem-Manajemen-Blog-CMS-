<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id            = (int)($_POST['id']            ?? 0);
$nama_depan    = trim($_POST['nama_depan']     ?? '');
$nama_belakang = trim($_POST['nama_belakang']  ?? '');
$username      = trim($_POST['username']       ?? '');
$password      = $_POST['password']            ?? '';

if ($id <= 0 || !$nama_depan || !$nama_belakang || !$username) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Get existing foto
$stmt = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
    exit;
}
$foto = $row['foto'];

// Handle new foto
if (!empty($_FILES['foto']['tmp_name'])) {
    $file  = $_FILES['foto'];
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
    // Delete old foto if not default
    if ($foto !== 'default.png' && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    $ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
    $foto = uniqid('p_', true) . '.' . $ext;
    move_uploaded_file($file['tmp_name'], 'uploads_penulis/' . $foto);
}

// Build query
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $username, $hashed, $foto, $id);
} else {
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $username, $foto, $id);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Penulis berhasil diperbarui.']);
} else {
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui: ' . $koneksi->error]);
    }
}
