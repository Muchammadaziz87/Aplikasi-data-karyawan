<?php
require_once 'auth.php';
require_once 'config.php';
require_once 'functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    flash('danger', 'ID karyawan tidak valid.');
    header('Location: karyawan.php');
    exit;
}

$stmt = mysqli_prepare($conn, 'DELETE FROM karyawan WHERE id_karyawan = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    flash('success', 'Data karyawan berhasil dihapus.');
} else {
    flash('danger', 'Data karyawan gagal dihapus.');
}

header('Location: karyawan.php');
exit;
?>
