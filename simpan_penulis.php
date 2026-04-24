<?php
header('Content-Type: application/json');
require 'koneksi.php';

$nama_depan   = trim($_POST['nama_depan']   ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$username     = trim($_POST['username']     ?? '');
$password     = $_POST['password']          ?? '';

if (!$nama_depan || !$nama_belakang || !$username || !$password) {
    echo json_encode(['status' => 'error', 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// Handle foto upload
$foto = 'default.png';
if (!empty($_FILES['foto']['tmp_name'])) {
    $file = $_FILES['foto'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed_mime)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.']);
        exit;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }
    $ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
    $foto = uniqid('p_', true) . '.' . $ext;
    move_uploaded_file($file['tmp_name'], 'uploads_penulis/' . $foto);
}

$hashed = password_hash($password, PASSWORD_BCRYPT);

$stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $username, $hashed, $foto);

if ($stmt->execute()) {
    echo json_encode(['status' => 'ok', 'pesan' => 'Penulis berhasil disimpan.']);
} else {
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan: ' . $koneksi->error]);
    }
}
