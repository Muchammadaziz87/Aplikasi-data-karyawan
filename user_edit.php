<?php
require_once 'auth.php';
require_once 'config.php';
require_once 'functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    flash('danger', 'ID user tidak valid.');
    header('Location: users.php');
    exit;
}

$stmt = mysqli_prepare($conn, 'SELECT id_user, username, nama_lengkap, level FROM users WHERE id_user=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    flash('danger', 'User tidak ditemukan.');
    header('Location: users.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $level = $_POST['level'] ?? 'petugas';
    $password = $_POST['password'] ?? '';

    if ($username === '' || $nama === '') {
        $error = 'Username dan nama lengkap wajib diisi.';
    } else {
        if ($password !== '') {
            if (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, 'UPDATE users SET username=?, nama_lengkap=?, level=?, password=? WHERE id_user=?');
                mysqli_stmt_bind_param($stmt, 'ssssi', $username, $nama, $level, $hash, $id);
            }
        } else {
            $stmt = mysqli_prepare($conn, 'UPDATE users SET username=?, nama_lengkap=?, level=? WHERE id_user=?');
            mysqli_stmt_bind_param($stmt, 'sssi', $username, $nama, $level, $id);
        }

        if ($error === '' && mysqli_stmt_execute($stmt)) {
            if ($id === (int)$_SESSION['id_user']) {
                $_SESSION['username'] = $username;
                $_SESSION['nama_lengkap'] = $nama;
                $_SESSION['level'] = $level;
            }
            flash('success', 'User berhasil diubah.');
            header('Location: users.php');
            exit;
        }

        if ($error === '') {
            $error = mysqli_errno($conn) === 1062 ? 'Username sudah digunakan.' : 'Gagal mengubah user.';
        }
    }
} else {
    $_POST = $data;
}

$page_title = 'Edit User';
require 'header.php';
?>
<h3 class="mb-3">Edit User</h3>
<?php if ($error !== ''): ?><div class="alert alert-danger"><?= e($error); ?></div><?php endif; ?>

<form method="post" class="card shadow-sm border-0">
<div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= e($_POST['username']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= e($_POST['nama_lengkap']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Level</label>
            <select name="level" class="form-select">
                <option value="admin" <?= $_POST['level'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="petugas" <?= $_POST['level'] === 'petugas' ? 'selected' : ''; ?>>Petugas</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" minlength="6">
            <div class="form-text">Kosongkan jika password tidak diubah.</div>
        </div>
    </div>
</div>
<div class="card-footer bg-white">
    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="users.php" class="btn btn-secondary">Kembali</a>
</div>
</form>
<?php require 'footer.php'; ?>
