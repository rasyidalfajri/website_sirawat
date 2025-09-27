<?php
session_start();
include 'includes/db.php';
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $tanggal = $_POST['tanggal'];
    $kondisi = $_POST['kondisi'];
    $nilai = $_POST['nilai'];

    mysqli_query($conn, "INSERT INTO assets (kode_aset,nama_aset,lokasi,tanggal_beli,kondisi,nilai_aset)
    VALUES ('$kode','$nama','$lokasi','$tanggal','$kondisi','$nilai')");
}
$data = mysqli_query($conn, "SELECT * FROM assets");
?>
<!DOCTYPE html>
<html>
<head><title>Data Aset</title></head>
<body>
<h2>Data Aset</h2>
<form method="post">
    <input type="text" name="kode" placeholder="Kode Aset" required>
    <input type="text" name="nama" placeholder="Nama Aset" required>
    <input type="text" name="lokasi" placeholder="Lokasi">
    <input type="date" name="tanggal">
    <input type="text" name="kondisi" placeholder="Kondisi">
    <input type="number" name="nilai" placeholder="Nilai">
    <button type="submit" name="tambah">Tambah</button>
</form>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>Kode</th><th>Nama</th><th>Lokasi</th><th>Tanggal</th><th>Kondisi</th><th>Nilai</th></tr>
<?php while($d=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $d['kode_aset'] ?></td>
    <td><?= $d['nama_aset'] ?></td>
    <td><?= $d['lokasi'] ?></td>
    <td><?= $d['tanggal_beli'] ?></td>
    <td><?= $d['kondisi'] ?></td>
    <td><?= $d['nilai_aset'] ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
