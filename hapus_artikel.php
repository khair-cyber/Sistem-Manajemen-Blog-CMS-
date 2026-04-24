<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

// Get gambar path
$stmt = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$del = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$del->bind_param('i', $id);
if ($del->execute()) {
    if ($row && $row['gambar'] && file_exists('uploads_artikel/' . $row['gambar'])) {
        unlink('uploads_artikel/' . $row['gambar']);
    }
    echo json_encode(['status' => 'ok', 'pesan' => 'Artikel berhasil dihapus.']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus: ' . $koneksi->error]);
}
