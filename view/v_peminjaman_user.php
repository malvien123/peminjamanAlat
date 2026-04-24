<?php 

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Cek login
if (!isset($_SESSION['role'])) {
    header("Location: v_login.php");
    exit();
}

// 2. Jika yang masuk BUKAN peminjam, tendang ke halaman kerjanya masing-masing
if ($_SESSION['role'] !== 'peminjam') {
    if ($_SESSION['role'] === 'admin') {
        header("Location: v_tampilan_user.php"); // Ke dashboard admin
    } elseif ($_SESSION['role'] === 'petugas') {
        header("Location: v_peminjaman_petugas.php"); // Ke dashboard petugas
    }
    exit();
}

include '../controller/c_peminjaman.php';
 ?>
<!DOCTYPE html>
<html>
<head><title>Riwayat Saya</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded">
        <h2 class="mb-4">Riwayat Pinjam</h2>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="v_daftar_alat.php" class="btn btn-primary">+ Pinjam Alat</a>
            <span>Login: <b><?= $_SESSION['username']; ?></b></span>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr><th>No</th><th>Alat</th><th>Tgl Pinjam</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($isi_tabel_user) > 0):
                    while($row = mysqli_fetch_object($isi_tabel_user)): 
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $row->nama_alat; ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($row->tgl_pinjam)); ?></td>
                    <td class="text-center">
                        <span class="badge bg-<?= ($row->status == 'kembali') ? 'success' : 'warning'; ?>"><?= strtoupper($row->status); ?></span>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4" class="text-center py-4">Belum ada riwayat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>