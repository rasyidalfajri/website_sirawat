<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("DELETE FROM assets WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: index.php?deleted=1");
exit;
