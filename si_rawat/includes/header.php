<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SI RAWAT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f6f8fb; }
    .sidebar {
      width: 260px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      background: #0d6efd;
      color: #fff;
      padding: 1rem 0;
    }
    .sidebar a { color: rgba(255,255,255,.9); text-decoration: none; }
    .sidebar .nav-link.active { background: rgba(255,255,255,.15); border-radius: .5rem; }
    .content {
      margin-left: 260px;
      min-height: 100vh;
    }
    .brand {
      font-weight: 700;
      letter-spacing: .5px;
    }
  </style>
</head>
<body>
<aside class="sidebar d-none d-md-block">
  <div class="px-3 mb-3">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-wrench-adjustable-circle fs-3"></i>
      <span class="brand">SI RAWAT</span>
    </div>
  </div>
  <nav class="nav flex-column px-2">
    <a class="nav-link py-2 px-3" href="/si_rawat/index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a class="nav-link py-2 px-3" href="/si_rawat/assets/index.php"><i class="bi bi-box-seam me-2"></i>Data Aset</a>
    <a class="nav-link py-2 px-3" href="/si_rawat/schedules/index.php"><i class="bi bi-calendar-check me-2"></i>Jadwal Pemeliharaan</a>
    <a class="nav-link py-2 px-3" href="/si_rawat/docs/index.php"><i class="bi bi-card-image me-2"></i>Dokumentasi</a>
    <a class="nav-link py-2 px-3" href="/si_rawat/reports/index.php"><i class="bi bi-graph-up-arrow me-2"></i>Laporan</a>
  </nav>
  <div class="px-3 mt-auto position-absolute bottom-0 w-100">
    <div class="small text-white-50 mb-2">Login: <?= htmlspecialchars($_SESSION['admin'] ?? 'Admin') ?></div>
    <a class="btn btn-outline-light w-100 mb-3" href="/si_rawat/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
  </div>
</aside>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top d-md-none">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="bi bi-wrench-adjustable"></i> SI RAWAT</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mnav"><span class="navbar-toggler-icon"></span></button>
    <div id="mnav" class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/si_rawat/index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/si_rawat/assets/index.php">Data Aset</a></li>
        <li class="nav-item"><a class="nav-link" href="/si_rawat/schedules/index.php">Jadwal</a></li>
        <li class="nav-item"><a class="nav-link" href="/si_rawat/docs/index.php">Dokumentasi</a></li>
        <li class="nav-item"><a class="nav-link" href="/si_rawat/reports/index.php">Laporan</a></li>

      </ul>
      <a class="btn btn-primary ms-auto" href="/si_rawat/logout.php">Logout</a>
    </div>
  </div>
</nav>

<main class="content">
  <div class="container-fluid py-4">
