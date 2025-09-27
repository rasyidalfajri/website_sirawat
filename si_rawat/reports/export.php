<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

$where = "1=1";
$params = [];
$types = "";
if (!empty($_GET['asset_id'])) { $where .= " AND s.asset_id=?"; $params[] = (int)$_GET['asset_id']; $types .= "i"; }
if (!empty($_GET['status'])) { $where .= " AND s.status=?"; $params[] = $_GET['status']; $types .= "s"; }
if (!empty($_GET['dari'])) { $where .= " AND s.tanggal>=?"; $params[] = $_GET['dari']; $types .= "s"; }
if (!empty($_GET['sampai'])) { $where .= " AND s.tanggal<=?"; $params[] = $_GET['sampai']; $types .= "s"; }

$sql = "SELECT s.tanggal, a.nama_aset, s.jenis_perawatan, s.deskripsi, s.status
        FROM maintenance_schedule s JOIN assets a ON a.id=s.asset_id WHERE $where ORDER BY s.tanggal DESC";
$stmt = $conn->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_pemeliharaan.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Tanggal','Aset','Jenis Perawatan','Deskripsi','Status']);
while($r = $res->fetch_row()){
  fputcsv($output, $r);
}
fclose($output);
exit;
