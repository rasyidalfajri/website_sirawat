<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

// Create
if (isset($_POST['tambah'])) {
    $stmt = $conn->prepare("INSERT INTO assets (kode_aset, nama_aset, kategori, lokasi, tanggal_beli, kondisi, nilai_aset) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssd", $_POST['kode_aset'], $_POST['nama_aset'], $_POST['kategori'], $_POST['lokasi'], $_POST['tanggal_beli'], $_POST['kondisi'], $_POST['nilai_aset']);
    $stmt->execute();
    header("Location: index.php?added=1");
    exit;
}

$assets = $conn->query("SELECT * FROM assets ORDER BY created_at DESC");
include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Aset</h4>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle me-1"></i>Tambah Aset</button>
</div>

<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Kode</th><th>Nama</th><th>Kategori</th><th>Lokasi</th>
            <th>Tanggal Pembelian</th><th>Kondisi</th><th>Nilai</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($a = $assets->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($a['kode_aset']) ?></td>
            <td><?= htmlspecialchars($a['nama_aset']) ?></td>
            <td><?= htmlspecialchars($a['kategori']) ?></td>
            <td><?= htmlspecialchars($a['lokasi']) ?></td>
            <td><?= htmlspecialchars($a['tanggal_beli']) ?></td>
            <td><?= htmlspecialchars($a['kondisi']) ?></td>
            <td>Rp <?= number_format($a['nilai_aset'],0,',','.') ?></td>
            <td>
              <a class="btn btn-sm btn-outline-secondary" href="edit.php?id=<?= $a['id'] ?>"><i class="bi bi-pencil-square"></i></a>
              <a class="btn btn-sm btn-outline-danger" href="hapus.php?id=<?= $a['id'] ?>" onclick="return confirm('Hapus aset ini?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Tambah -->


<div class="card shadow-sm border-0">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <strong>Hasil</strong>
    <a class="btn btn-sm btn-success" href="export.php?<?= http_build_query($_GET) ?>"><i class="bi bi-filetype-csv me-1"></i>Export CSV</a>
  </div>
 
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Aset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-4"><label class="form-label">Kode</label><input name="kode_aset" class="form-control" required></div>
          <div class="col-md-8"><label class="form-label">Nama</label><input name="nama_aset" class="form-control" required></div>
          <div class="col-md-4"><label class="form-label">Kategori</label><input name="kategori" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Lokasi</label><input name="lokasi" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Tanggal Beli</label><input type="date" name="tanggal_beli" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Kondisi</label><input name="kondisi" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">Nilai (Rp)</label><input type="number" step="0.01" name="nilai_aset" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" name="tambah">Simpan</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
