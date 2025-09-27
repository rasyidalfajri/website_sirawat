<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

// Nama file CSV
$filename = "data_aset_" . date('Y-m-d') . ".csv";

// Header untuk download file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Buat file pointer ke output
$output = fopen("php://output", "w");

// Tulis header kolom
fputcsv($output, ['Kode Aset', 'Nama Aset', 'Kategori', 'Lokasi', 'Tanggal Beli', 'Kondisi', 'Nilai Aset']);

// Query ambil data
$result = $conn->query("SELECT kode_aset, nama_aset, kategori, lokasi, tanggal_beli, kondisi, nilai_aset FROM assets ORDER BY created_at DESC");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
exit;
?>
