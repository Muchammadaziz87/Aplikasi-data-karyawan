<?php
require_once 'auth.php';
require_once 'config.php';

$data = mysqli_query($conn, 'SELECT id_user, username, nama_lengkap, level, created_at FROM users ORDER BY id_user DESC');

$page_title = 'Data User';
require 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data User</h3>
    <a href="user_tambah.php" class="btn btn-primary">+ Tambah User</a>
</div>

<div class="table-responsive shadow-sm">
<table class="table table-bordered table-striped table-hover align-middle mb-0">
    <thead class="table-primary">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Nama Lengkap</th>
        <th>Level</th>
        <th>Dibuat</th>
        <th width="150">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= e($row['username']); ?></td>
        <td><?= e($row['nama_lengkap']); ?></td>
        <td><?= e($row['level']); ?></td>
        <td><?= e($row['created_at']); ?></td>
        <td>
            <a href="user_edit.php?id=<?= (int)$row['id_user']; ?>" class="btn btn-warning btn-sm">Edit</a>
            <?php if ((int)$row['id_user'] !== (int)$_SESSION['id_user']): ?>
            <a href="user_hapus.php?id=<?= (int)$row['id_user']; ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
<?php require 'footer.php'; ?>
