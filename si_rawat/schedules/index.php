<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

// Assets for select
$assets = $conn->query("SELECT id,nama_aset FROM assets ORDER BY nama_aset");

// Create
if (isset($_POST['tambah'])) {
  $stmt = $conn->prepare("INSERT INTO maintenance_schedule (asset_id, tanggal, jenis_perawatan, deskripsi, suplier, biaya, status) VALUES (?,?,?,?,?,?,?)");
  $stmt->bind_param(
    "isssdss",
    $_POST['asset_id'],
    $_POST['tanggal'],
    $_POST['jenis_perawatan'],
    $_POST['deskripsi'],
    $_POST['suplier'],
    $_POST['biaya'],
    $_POST['status']
  );
  $stmt->execute();
  header("Location: index.php?added=1");
  exit;
}

$list = $conn->query("SELECT s.*, a.nama_aset 
                      FROM maintenance_schedule s 
                      JOIN assets a ON a.id=s.asset_id 
                      ORDER BY s.tanggal DESC, s.id DESC");

include __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Jadwal Pemeliharaan</h4>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
  </button>
</div>
<div class="card shadow-sm border-0">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Tanggal</th>
          <th>Aset</th>
          <th>Jenis</th>
          <th>Deskripsi</th>
          <th>Suplier</th>
          <th>Biaya</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($s = $list->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($s['tanggal']) ?></td>
          <td><?= htmlspecialchars($s['nama_aset']) ?></td>
          <td><?= htmlspecialchars($s['jenis_perawatan']) ?></td>
          <td><?= htmlspecialchars($s['deskripsi']) ?></td>
          <td><?= htmlspecialchars($s['suplier']) ?></td>
          <td><?= number_format($s['biaya'], 0, ',', '.') ?></td>
          <td>
            <span class="badge bg-<?php
              echo $s['status']=='selesai'?'success':($s['status']=='proses'?'warning text-dark':'secondary'); ?>">
              <?= htmlspecialchars($s['status']) ?>
            </span>
          </td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="edit.php?id=<?= $s['id'] ?>"><i class="bi bi-pencil-square"></i></a>
            <a class="btn btn-sm btn-outline-danger" href="hapus.php?id=<?= $s['id'] ?>" onclick="return confirm('Hapus jadwal ini?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label class="form-label">Aset</label>
          <select name="asset_id" class="form-select" required>
            <option value="">- pilih aset -</option>
            <?php while($a = $assets->fetch_assoc()): ?>
              <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama_aset']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Jenis Perawatan</label>
          <input name="jenis_perawatan" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label">Suplier</label>
          <input name="suplier" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Biaya</label>
          <input type="number" step="0.01" name="biaya" class="form-control" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="pending">pending</option>
            <option value="proses">proses</option>
            <option value="selesai">selesai</option>
          </select>
        </div>
      </div>
      <div class="modal-footer"><button class="btn btn-primary" name="tambah">Simpan</button></div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
