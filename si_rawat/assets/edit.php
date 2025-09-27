<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM assets WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$asset = $stmt->get_result()->fetch_assoc();
if (!$asset) { header("Location: index.php"); exit; }

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $conn->prepare("UPDATE assets SET kode_aset=?, nama_aset=?, kategori=?, lokasi=?, tanggal_beli=?, kondisi=?, nilai_aset=? WHERE id=?");
  $stmt->bind_param("ssssssdi", $_POST['kode_aset'], $_POST['nama_aset'], $_POST['kategori'], $_POST['lokasi'], $_POST['tanggal_beli'], $_POST['kondisi'], $_POST['nilai_aset'], $id);
  $stmt->execute();
  header("Location: index.php?updated=1");
  exit;
}

include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Edit Aset</h4>
  <a class="btn btn-outline-secondary" href="index.php">Kembali</a>
</div>
<div class="card shadow-sm border-0">
  <form method="post" class="card-body">
    <div class="row g-3">
      <div class="col-md-4"><label class="form-label">Kode</label><input name="kode_aset" class="form-control" value="<?= htmlspecialchars($asset['kode_aset']) ?>" required></div>
      <div class="col-md-8"><label class="form-label">Nama</label><input name="nama_aset" class="form-control" value="<?= htmlspecialchars($asset['nama_aset']) ?>" required></div>
      <div class="col-md-4"><label class="form-label">Kategori</label><input name="kategori" class="form-control" value="<?= htmlspecialchars($asset['kategori']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Lokasi</label><input name="lokasi" class="form-control" value="<?= htmlspecialchars($asset['lokasi']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Tanggal Beli</label><input type="date" name="tanggal_beli" class="form-control" value="<?= htmlspecialchars($asset['tanggal_beli']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Kondisi</label><input name="kondisi" class="form-control" value="<?= htmlspecialchars($asset['kondisi']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Nilai (Rp)</label><input type="number" step="0.01" name="nilai_aset" class="form-control" value="<?= htmlspecialchars($asset['nilai_aset']) ?>"></div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">Simpan Perubahan</button></div>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
