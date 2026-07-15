<?php
require_once 'auth.php';
require_once 'functions.php';
$page_title = $page_title ?? 'Aplikasi Data Karyawan';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <strong>UAS PWB MUCHAMMAD AZIZ</strong><br>
            <small>NIM A18.2025.00175</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="karyawan.php">Data Karyawan</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Data User</a></li>
            </ul>
            <span class="navbar-text text-white me-3">
                <?= e($_SESSION['nama_lengkap'] ?? 'User'); ?>
            </span>
            <a class="btn btn-outline-light btn-sm" href="logout.php"
               onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>
    </div>
</nav>
<main class="container py-4">
    <?php show_flash(); ?>
