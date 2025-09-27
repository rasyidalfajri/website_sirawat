<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM maintenance_schedule WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) { header("Location: index.php"); exit; }

$assets = $conn->query("SELECT id,nama_aset FROM assets ORDER BY nama_aset");

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $stmt = $conn->prepare("UPDATE maintenance_schedule 
                          SET asset_id=?, tanggal=?, jenis_perawatan=?, deskripsi=?, suplier=?, biaya=?, status=? 
                          WHERE id=?");
  $stmt->bind_param(
    "issssdis",
    $_POST['asset_id'],
    $_POST['tanggal'],
    $_POST['jenis_perawatan'],
    $_POST['deskripsi'],
    $_POST['suplier'],
    $_POST['biaya'],
    $_POST['status'],
    $id
  );
  $stmt->execute();
  header("Location: index.php?updated=1");
  exit;
}

include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Edit Jadwal</h4>
  <a class="btn btn-outline-secondary" href="index.php">Kembali</a>
</div>
<div class="card shadow-sm border-0">
  <form method="post" class="card-body">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Aset</label>
        <select name="asset_id" class="form-select">
          <?php while($a = $assets->fetch_assoc()): ?>
            <option value="<?= $a['id'] ?>" <?= $a['id']==$data['asset_id']?'selected':'' ?>>
              <?= htmlspecialchars($a['nama_aset']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($data['tanggal']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Jenis Perawatan</label>
        <input name="jenis_perawatan" class="form-control" value="<?= htmlspecialchars($data['jenis_perawatan']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <?php foreach(['pending','proses','selesai'] as $s): ?>
            <option value="<?= $s ?>" <?= $s==$data['status']?'selected':'' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Suplier</label>
        <input name="suplier" class="form-control" value="<?= htmlspecialchars($data['suplier']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Biaya</label>
        <input type="number" step="0.01" name="biaya" class="form-control" value="<?= htmlspecialchars($data['biaya']) ?>">
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
      </div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">Simpan Perubahan</button></div>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
