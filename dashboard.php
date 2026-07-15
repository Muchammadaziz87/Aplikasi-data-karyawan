<?php
require_once 'auth.php';
require_once 'config.php';

$jumlah_karyawan = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM karyawan'))['total'];
$jumlah_user = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM users'))['total'];
$jumlah_departemen = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(DISTINCT departemen) AS total FROM karyawan'))['total'];

$page_title = 'Dashboard';
require 'header.php';
?>
<div class="p-4 p-md-5 mb-4 rounded-3 hero">
    <h1 class="fw-bold">Selamat Datang, <?= e($_SESSION['nama_lengkap']); ?></h1>
    <p class="mb-0">Kelola data karyawan dan user melalui aplikasi berbasis web.</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="text-muted">Jumlah Karyawan</h5>
                <h2 class="fw-bold"><?= e($jumlah_karyawan); ?></h2>
                <a href="karyawan.php" class="btn btn-primary btn-sm">Lihat data</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="text-muted">Jumlah User</h5>
                <h2 class="fw-bold"><?= e($jumlah_user); ?></h2>
                <a href="users.php" class="btn btn-primary btn-sm">Lihat user</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="text-muted">Departemen</h5>
                <h2 class="fw-bold"><?= e($jumlah_departemen); ?></h2>
                <span class="text-muted small">Departemen yang terdaftar</span>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
