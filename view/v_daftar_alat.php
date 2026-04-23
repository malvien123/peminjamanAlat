<?php 
// Panggil controller untuk mengisi variabel $data_alat
include_once '../controller/c_alat.php'; 
// c_peminjaman biasanya butuh session_start, pastikan tidak double jika di c_alat sudah ada
include_once '../controller/c_peminjaman.php';

// Proteksi login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'peminjam') {
    header("location:v_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>alat</title>
     <link rel="stylesheet" href="../asset/style_daftar_alat.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h2><center>Daftar Alat Tersedia</h2>
    <nav>
    <a href="v_peminjaman_user.php" class="btn btn-primary" >Riwayat peminjaman saya</a>
     <a href="../controller/c_login.php?aksi=logout" onclick="return confirm('Apakah Anda yakin ingin keluar dari sesi?');" class="btn btn-danger">logout</a>
</nav>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Stok</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if (!empty($data_alat)): 
                foreach ($data_alat as $row): 
                    // Konversi ke object jika data yang datang ternyata array (untuk mencegah error di image_91fa86.png)
                    $data = (object)$row; 
            ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td align="center">
                    <?php if(!empty($data->foto)): ?>
                        <img src="<?= htmlspecialchars($data->foto); ?>" class="img-alat" alt="foto">
                    <?php else: ?>
                        <div style="width:80px; height:80px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; border-radius:8px; font-size:10px; color:#999;">No Image</div>
                    <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($data->nama_alat); ?></strong></td>
                <td><?= htmlspecialchars($data->nama_kategori); ?></td>
                <td align="center">
                    <span style="font-weight: bold; color: <?= ($data->stok < 1) ? 'red' : 'black'; ?>;">
                        <?= $data->stok; ?>
                    </span>
                </td>
                <td align="center">
                    <a href="v_form_pinjam.php?id_alat=<?= $row->id_alat; ?>&nama=<?= $row->nama_alat; ?>&stok=<?= $row->stok; ?>" 
                    class="btn btn-primary">Pinjam Alat</a>
                </td>
            </tr>
            <?php 
                endforeach; 
            else: 
            ?>
            <tr>
                <td colspan="6" align="center" style="padding: 20px;">Data alat tidak ditemukan atau stok kosong.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>