<?php
require_once 'auth.php';
require_once 'config.php';
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $level = $_POST['level'] ?? 'petugas';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $nama === '' || $password === '') {
        $error = 'Semua kolom wajib diisi.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, 'INSERT INTO users (username, password, nama_lengkap, level) VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssss', $username, $hash, $nama, $level);

        if (mysqli_stmt_execute($stmt)) {
            flash('success', 'User berhasil ditambahkan.');
            header('Location: users.php');
            exit;
        }

        $error = mysqli_errno($conn) === 1062
            ? 'Username sudah digunakan.'
            : 'Gagal menambahkan user.';
    }
}

$page_title = 'Tambah User';
require 'header.php';
?>
<h3 class="mb-3">Tambah User</h3>
<?php if ($error !== ''): ?><div class="alert alert-danger"><?= e($error); ?></div><?php endif; ?>

<form method="post" class="card shadow-sm border-0">
<div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= e($_POST['username'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= e($_POST['nama_lengkap'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Level</label>
            <select name="level" class="form-select">
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" minlength="6" required>
        </div>
    </div>
</div>
<div class="card-footer bg-white">
    <button class="btn btn-primary">Simpan</button>
    <a href="users.php" class="btn btn-secondary">Kembali</a>
</div>
</form>
<?php require 'footer.php'; ?>
