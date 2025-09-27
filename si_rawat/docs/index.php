<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $asset_id = (int)$_POST['asset_id'];
  $tanggal = $_POST['tanggal'];
  $keterangan = $_POST['keterangan'];

  if (!is_dir(__DIR__ . '/../uploads')) { mkdir(__DIR__ . '/../uploads', 0777, true); }
  $file = $_FILES['foto'] ?? null;
  if ($file && $file['tmp_name']) {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = 'doc_'.time().'_'.rand(1000,9999).'.'.$ext;
    $dest = __DIR__ . '/../uploads/'.$name;
    move_uploaded_file($file['tmp_name'], $dest);

    $stmt = $conn->prepare("INSERT INTO maintenance_docs (asset_id, tanggal, foto, keterangan) VALUES (?,?,?,?)");
    $stmt->bind_param("isss", $asset_id, $tanggal, $name, $keterangan);
    $stmt->execute();
    $msg = "Upload berhasil.";
  } else {
    $msg = "Pilih file terlebih dahulu.";
  }
}

$assets = $conn->query("SELECT id,nama_aset FROM assets ORDER BY nama_aset");
$list = $conn->query("SELECT d.*, a.nama_aset FROM maintenance_docs d JOIN assets a ON a.id=d.asset_id ORDER BY d.created_at DESC");

include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Dokumentasi Kondisi</h4>
</div>
<?php if ($msg): ?><div class="alert alert-info"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-white"><strong>Upload Dokumentasi</strong></div>
  <form class="card-body" method="post" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Aset</label>
        <select name="asset_id" class="form-select" required>
          <option value="">- pilih aset -</option>
          <?php while($a = $assets->fetch_assoc()): ?>
            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama_aset']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
      </div>
      <div class="col-md-5">
        <label class="form-label">Keterangan</label>
        <input name="keterangan" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Foto</label>
        <input type="file" name="foto" class="form-control" accept="image/*" required>
      </div>
      <div class="col-md-6 d-flex align-items-end">
        <button class="btn btn-primary">Upload</button>
      </div>
    </div>
  </form>
</div>

<div class="row g-3">
  <?php while($d = $list->fetch_assoc()): ?>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <img src="../uploads/<?= htmlspecialchars($d['foto']) ?>" class="card-img-top" style="object-fit:cover;height:200px">
      <div class="card-body">
        <div class="small text-muted"><?= htmlspecialchars($d['tanggal']) ?> • <?= htmlspecialchars($d['nama_aset']) ?></div>
        <div><?= htmlspecialchars($d['keterangan']) ?></div>
      </div>
      <div class="card-footer bg-white">
        <a class="btn btn-sm btn-outline-danger" href="hapus.php?id=<?= $d['id'] ?>" onclick="return confirm('Hapus dokumentasi ini?')"><i class="bi bi-trash"></i> Hapus</a>
        <a class="btn btn-sm btn-outline-primary" href="lihat.php?id=<?= $d['id'] ?>"><i class="bi bi-box-arrow-up-right"></i> Lihat</a>

      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
