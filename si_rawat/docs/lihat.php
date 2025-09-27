<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT d.*, a.nama_aset FROM maintenance_docs d JOIN assets a ON a.id=d.asset_id WHERE d.id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { header("Location: index.php"); exit; }

include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Lihat Dokumentasi</h4>
  <a href="index.php" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="card shadow-sm border-0">
  <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" class="card-img-top" style="max-height:500px;object-fit:contain">
  <div class="card-body">
    <div class="small text-muted"><?= htmlspecialchars($data['tanggal']) ?> • <?= htmlspecialchars($data['nama_aset']) ?></div>
    <div><?= htmlspecialchars($data['keterangan']) ?></div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
