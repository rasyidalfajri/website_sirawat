<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/db.php';

// Summary counts
$counts = [];
foreach (['assets','maintenance_schedule','maintenance_docs'] as $t) {
  $res = $conn->query("SELECT COUNT(*) c FROM $t");
  $counts[$t] = $res->fetch_assoc()['c'] ?? 0;
}
// Upcoming schedules (next 10)
$upcoming = $conn->query("SELECT s.*, a.nama_aset FROM maintenance_schedule s
  JOIN assets a ON a.id = s.asset_id
  WHERE s.tanggal >= CURDATE() ORDER BY s.tanggal ASC LIMIT 10");
include __DIR__ . '/includes/header.php';
?>
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted">Total Aset</div>
        <div class="display-5 fw-bold"><?= $counts['assets'] ?></div>
        <a href="/si_rawat/assets/index.php" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted">Jadwal</div>
        <div class="display-5 fw-bold"><?= $counts['maintenance_schedule'] ?></div>
        <a href="/si_rawat/schedules/index.php" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="text-muted">Dokumentasi</div>
        <div class="display-5 fw-bold"><?= $counts['maintenance_docs'] ?></div>
        <a href="/si_rawat/docs/index.php" class="btn btn-sm btn-outline-primary mt-2">Kelola</a>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm border-0">
  <div class="card-header bg-white">
    <strong>10 Jadwal Terdekat</strong>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>Tanggal</th><th>Aset</th><th>Jenis</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $upcoming->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td><?= htmlspecialchars($row['nama_aset']) ?></td>
            <td><?= htmlspecialchars($row['jenis_perawatan']) ?></td>
            <td><span class="badge bg-<?php
                echo $row['status']=='selesai'?'success':($row['status']=='proses'?'warning text-dark':'secondary'); ?>">
                <?= htmlspecialchars($row['status']) ?></span></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
