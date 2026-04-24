<?php


if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Cek apakah sudah login? Jika belum, balik ke login.php
if (!isset($_SESSION['role'])) {
    header("Location: v_login.php");
    exit();
}

// 2. Jika yang masuk BUKAN admin, maka dialihkan/ditendang balik
if ($_SESSION['role'] !== 'admin') {
    if ($_SESSION['role'] === 'petugas') {
        header("Location: v_peminjaman_petugas.php");
    } else {
        header("Location: v_daftar_alat.php");
    }
    exit();
}

include_once '../controller/c_kategori.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Kategori Alat</title>
    <link rel="stylesheet" href="../asset/style_kategori.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h3><center>Kelola Kategori Alat</h3>
    <a href="../view/v_tampilan_user.php" class="btn btn-primary">kembali</a>
    <a href="../view/v_tambah_kategori.php" class="btn btn-success"> Tambah kategori</a>
    <br><br>
    <table border="1" width="100%" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            if (!empty($data_kategori)) : 
                foreach($data_kategori as $kat) : 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($kat->nama_kategori); ?></td>
                <td><?= htmlspecialchars($kat->keterangan_kategori); ?></td>
                <td>
                    <a href="../controller/c_kategori.php?aksi=edit&id=<?= $kat->id_kategori; ?>"  class="button">Edit</a> 
                    <a href="../controller/c_kategori.php?aksi=hapus&id=<?= $kat->id_kategori; ?>" onclick="return confirm('Hapus?')" class="buton">Hapus</a>
                </td>
            </tr>
            <?php endforeach; else : ?>
            <tr><td colspan="4" align="center">Data Kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>