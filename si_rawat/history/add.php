<?php
include '../includes/db.php';
include '../includes/auth.php';
include '../includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO history (asset_id, tanggal, teknisi, catatan) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['asset_id'], $_POST['tanggal'], $_POST['teknisi'], $_POST['catatan']]);
    header("Location: index.php");
    exit;
}

$assets = $pdo->query("SELECT * FROM assets")->fetchAll();
?>
<div class="container mt-4">
    <h2>Tambah Histori Perawatan</h2>
    <form method="post">
        <div class="mb-3">
            <label>Aset</label>
            <select name="asset_id" class="form-control" required>
                <?php foreach ($assets as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nama_aset']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Teknisi</label>
            <input type="text" name="teknisi" class="form-control">
        </div>
        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
