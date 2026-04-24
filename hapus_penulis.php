<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Check if penulis has artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS total FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jumlah = $cek->get_result()->fetch_assoc()['total'];
if ($jumlah > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki artikel.']);
    exit;
}

// Get foto to delete
$stmt = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$del = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$del->bind_param('i', $id);
if ($del->execute()) {
    if ($row && $row['foto'] !== 'default.png' && file_exists('uploads_penulis/' . $row['foto'])) {
        unlink('uploads_penulis/' . $row['foto']);
    }
    echo json_encode(['status' => 'ok', 'pesan' => 'Penulis berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus: ' . $koneksi->error]);
}
