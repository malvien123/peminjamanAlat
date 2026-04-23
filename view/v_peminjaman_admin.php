<?php 
include '../controller/c_peminjaman.php'; 

// Proteksi halaman: Hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:v_login.php");
    exit();
} 

$tipe_halaman = $_GET['tipe'] ?? 'pinjam'; // Default ke pinjam jika kosong
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="card p-4 shadow-sm">
        <h2 class="text-center mb-4">Halaman <?= ($tipe_halaman == 'kembali') ? 'Pengembalian' : 'Peminjaman'; ?></h2>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <a href="v_tampilan_user.php" class="btn btn-primary">kembali</a>
                <a href="v_peminjaman_admin.php?tipe=pinjam" class="btn btn-<?= ($tipe_halaman != 'kembali') ? 'primary' : 'outline-primary'; ?>">Daftar Peminjaman</a>
                <a href="v_peminjaman_admin.php?tipe=kembali" class="btn btn-<?= ($tipe_halaman == 'kembali') ? 'primary' : 'outline-primary'; ?>">Daftar Pengembalian</a>
            </div>
        </div>

        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                // $isi_tabel sudah diproses di controller/c_peminjaman.php
                if ($isi_tabel && mysqli_num_rows($isi_tabel) > 0):
                    while($row = mysqli_fetch_object($isi_tabel)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row->nama_peminjam); ?></td>
                    <td>
                        <strong><?= htmlspecialchars($row->nama_alat); ?></strong><br>
                        <small class="text-muted"><?= $row->nama_kategori; ?></small>
                    </td>
                    <td><?= $row->jumlah_pinjam; ?></td>
                    <td>
                        <span class="badge bg-<?= ($row->status == 'kembali') ? 'success' : (($row->status == 'dipinjam') ? 'info' : 'warning') ?>">
                            <?= strtoupper($row->status); ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php 
                            // Tentukan file edit berdasarkan tipe halaman atau status
                            if ($tipe_halaman == 'kembali') {
                                $link_edit = "v_update_kembali.php?aksi=edit_kembali&id=" . $row->id_peminjaman;
                            } else {
                                $link_edit = "v_update_pinjam.php?aksi=edit_pinjam&id=" . $row->id_peminjaman;
                            }
                            ?>
                            
                            <a href="<?= $link_edit; ?>" class="btn btn-sm btn-primary">Edit</a>
                            
                            <a href="../controller/c_peminjaman.php?aksi=hapus&id=<?= $row->id_peminjaman; ?>" 
                               onclick="return confirm('Yakin ingin menghapus data ini?')" 
                               class="btn btn-sm btn-danger">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" class="py-4 text-center text-muted">
                        Tidak ada data <strong><?= $tipe_halaman; ?></strong> untuk ditampilkan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>