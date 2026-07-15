<?php
require_once 'auth.php';
require_once 'config.php';

$q = trim($_GET['q'] ?? '');

if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = mysqli_prepare($conn, 'SELECT * FROM karyawan
        WHERE nik LIKE ? OR nama_karyawan LIKE ? OR jabatan LIKE ? OR departemen LIKE ?
        ORDER BY id_karyawan DESC');
    mysqli_stmt_bind_param($stmt, 'ssss', $like, $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
} else {
    $data = mysqli_query($conn, 'SELECT * FROM karyawan ORDER BY id_karyawan DESC');
}

$page_title = 'Data Karyawan';
require 'header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h3 class="mb-0">Data Karyawan</h3>
    <a href="karyawan_tambah.php" class="btn btn-primary">+ Tambah Karyawan</a>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-md-5">
        <input type="text" name="q" class="form-control"
               placeholder="Cari NIK, nama, jabatan, atau departemen"
               value="<?= e($q); ?>">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">Cari</button>
        <a href="karyawan.php" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="table-responsive shadow-sm">
<table class="table table-bordered table-striped table-hover align-middle mb-0">
    <thead class="table-primary">
    <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Jabatan</th>
        <th>Departemen</th>
        <th>No. HP</th>
        <th>Tanggal Masuk</th>
        <th width="150">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($data) === 0): ?>
        <tr><td colspan="9" class="text-center">Data tidak ditemukan.</td></tr>
    <?php else: ?>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= e($row['nik']); ?></td>
            <td><?= e($row['nama_karyawan']); ?></td>
            <td><?= e($row['jenis_kelamin']); ?></td>
            <td><?= e($row['jabatan']); ?></td>
            <td><?= e($row['departemen']); ?></td>
            <td><?= e($row['no_hp']); ?></td>
            <td><?= e($row['tanggal_masuk']); ?></td>
            <td>
                <a href="karyawan_edit.php?id=<?= (int)$row['id_karyawan']; ?>"
                   class="btn btn-warning btn-sm">Edit</a>
                <a href="karyawan_hapus.php?id=<?= (int)$row['id_karyawan']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>
<?php require 'footer.php'; ?>
