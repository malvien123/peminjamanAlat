<?php 
session_start();
include '../controller/c_peminjaman.php'; // Ini otomatis memanggil m_peminjaman dan koneksi

// Ambil data log dari model menggunakan fungsi yang tadi kita buat
$isi_log = $pinjam_model->tampil_log_aktivitas();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-primary">Riwayat Aktivitas Sistem</h4>
            <a href="v_tampilan_user.php" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th width="20%">Waktu / Jam</th>
                        <th width="20%">User</th>
                        <th>Aksi / Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if ($isi_log && mysqli_num_rows($isi_log) > 0) {
                        while($row = mysqli_fetch_object($isi_log)): 
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= date('d-m-Y H:i:s', strtotime($row->waktu)); ?></td>
                        <td><strong><?= $row->username; ?></strong></td>
                        <td><?= $row->aksi; ?></td>
                    </tr>
                    <?php 
                        endwhile; 
                    } else {
                       echo "<tr>
                       <td colspan='4' class='text-center'>Belum ada catatan aktivitas</td>
                       </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>