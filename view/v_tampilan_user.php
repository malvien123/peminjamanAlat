<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

include_once '../controller/c_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../asset/style_tampilan_user.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Admin dan Data Pengguna</title>
</head>
<body>
    <h3><center>DASHBOARD ADMIN</h3>
<nav>
<a href="v_log_aktivitas.php" class="btn btn-info"><i class="bi bi-clock-history"></i> Lihat Aktivitas</a>
 <a href="../view/v_tambah_user.php" class="button">tambah pengguna |</a>
  <a href="v_kategori.php" class="button">kategori |</a>
  <a href="v_alat.php" class="button">alat |</a>
  <a href="v_peminjaman_admin.php?tipe=pinjam" class="button">data peminjaman dan pengembalian</a>
  <a href="../controller/c_login.php?aksi=logout" onclick="return confirm('Apakah Anda yakin ingin keluar dari sesi?');" class="buton">logout</a>
  </nav>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID User</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if (is_array($users) && count($users) > 0):
            foreach ($users as $data ):
        ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$data->id_user?></td>
                <td><?=$data->username?></td>
                <td class="<?=$data->role === 'admin' ? 'petugas' : 'peminjam'?>"><?=$data->role?></td>
                <td>
                    <a href="../controller/c_user.php?aksi=edit&id=<?= $data->id_user;?>" class="btn btn-primary">Edit</a>
                    <a href="../controller/c_user.php?id=<?= $data->id_user; ?>&aksi=hapus" 
                      onclick="return confirm ('Anda yakin mau menghapus data ini ?')" 
                      class="buton">
                      Hapus
                    </a>
                </td>
            </tr>
        <?php 
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pengguna yang ditemukan.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>