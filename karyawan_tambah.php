<?php
require_once 'auth.php';
require_once 'config.php';
require_once 'functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = trim($_POST['nik'] ?? '');
    $nama = trim($_POST['nama_karyawan'] ?? '');
    $jk = $_POST['jenis_kelamin'] ?? '';
    $jabatan = trim($_POST['jabatan'] ?? '');
    $departemen = trim($_POST['departemen'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $tanggal_masuk = $_POST['tanggal_masuk'] ?? '';

    if ($nik === '' || $nama === '' || $jk === '' || $jabatan === '' ||
        $departemen === '' || $alamat === '' || $no_hp === '' || $tanggal_masuk === '') {
        $error = 'Semua kolom wajib diisi.';
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO karyawan
            (nik, nama_karyawan, jenis_kelamin, jabatan, departemen, alamat, no_hp, tanggal_masuk)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssssssss', $nik, $nama, $jk, $jabatan, $departemen, $alamat, $no_hp, $tanggal_masuk);

        if (mysqli_stmt_execute($stmt)) {
            flash('success', 'Data karyawan berhasil ditambahkan.');
            header('Location: karyawan.php');
            exit;
        }

        $error = mysqli_errno($conn) === 1062
            ? 'NIK sudah digunakan.'
            : 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}

$page_title = 'Tambah Karyawan';
require 'header.php';
?>
<h3 class="mb-3">Tambah Data Karyawan</h3>

<?php if ($error !== ''): ?>
    <div class="alert alert-danger"><?= e($error); ?></div>
<?php endif; ?>

<form method="post" class="card shadow-sm border-0">
<div class="card-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" value="<?= e($_POST['nik'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control" value="<?= e($_POST['nama_karyawan'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="<?= e($_POST['jabatan'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Departemen</label>
            <input type="text" name="departemen" class="form-control" value="<?= e($_POST['departemen'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= e($_POST['no_hp'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="<?= e($_POST['tanggal_masuk'] ?? ''); ?>" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required><?= e($_POST['alamat'] ?? ''); ?></textarea>
        </div>
    </div>
</div>
<div class="card-footer bg-white">
    <button class="btn btn-primary">Simpan</button>
    <a href="karyawan.php" class="btn btn-secondary">Kembali</a>
</div>
</form>
<?php require 'footer.php'; ?>
