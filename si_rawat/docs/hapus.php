<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT foto FROM maintenance_docs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$foto = $stmt->get_result()->fetch_assoc()['foto'] ?? null;

$stmt = $conn->prepare("DELETE FROM maintenance_docs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($foto && file_exists(__DIR__ . '/../uploads/'.$foto)) {
  unlink(__DIR__ . '/../uploads/'.$foto);
}
header("Location: index.php?deleted=1");
exit;
