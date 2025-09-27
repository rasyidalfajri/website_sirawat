<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';

// Filters
$where = "1=1";
$params = [];
$types = "";
if (!empty($_GET['status'])) { 
  $where .= " AND h.status=?"; 
  $params[] = $_GET['status']; 
  $types .= "s"; 
}
if (!empty($_GET['dari'])) { 
  $where .= " AND h.tanggal>=?"; 
  $params[] = $_GET['dari']; 
  $types .= "s"; 
}
if (!empty($_GET['sampai'])) { 
  $where .= " AND h.tanggal<=?"; 
  $params[] = $_GET['sampai']; 
  $types .= "s"; 
}

$sql = "SELECT * FROM history_perawatan h WHERE $where ORDER BY h.tanggal DESC";
$stmt = $conn->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$list = $stmt->get_result();

include __DIR__ . '/../includes/header.php';
?>
<h4 class="mb-3">History Perawatan</h4>
<form class="card shadow-sm border-0 mb-3">
  <div class="card-body row g-3">
    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="">Semua</option>
        <?php foreach(['pending','proses','selesai'] as $s): ?>
          <option value="<?= $s ?>" <?= (($_GET['status']??'')==$s)?'selected':'' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">Dari</label>
      <input type="date" name="dari" class="form-control" value="<?= htmlspecialchars($_GET['dari']??'') ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">Sampai</label>
      <input type="date" name="sampai" class="form-control" value="<?= htmlspecialchars($_GET['sampai']??'') ?>">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i>Filter</button>
    </div>
  </div>
</form>

<div class="card shadow-sm border-0">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <strong>Daftar History</strong>
    <a class="btn btn-sm btn-success" href="export.php?<?= http_build_query($_GET) ?>"><i class="bi bi-filetype-csv me-1"></i>Export CSV</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr><th>Tanggal</th><th>Nama Aset</th><th>Deskripsi</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php while($r = $list->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['tanggal']) ?></td>
            <td><?= htmlspecialchars($r['nama_aset']) ?></td>
            <td><?= htmlspecialchars($r['deskripsi']) ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
