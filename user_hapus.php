<?php
require_once 'auth.php';
require_once 'config.php';
require_once 'functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    flash('danger', 'ID user tidak valid.');
} elseif ($id === (int)$_SESSION['id_user']) {
    flash('danger', 'User yang sedang login tidak dapat dihapus.');
} else {
    $stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE id_user=?');
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        flash('success', 'User berhasil dihapus.');
    } else {
        flash('danger', 'User gagal dihapus.');
    }
}

header('Location: users.php');
exit;
?>
