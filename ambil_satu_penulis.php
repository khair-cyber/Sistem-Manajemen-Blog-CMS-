<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode($row);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan.']);
}
