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


include_once '../controller/c_alat.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat</title>
    <link rel="stylesheet" href="../asset/style_alat.css"> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <h2><center>Daftar Alat</h2>
    <a href="../view/v_tampilan_user.php" class="btn btn-primary">kembali</a>
    <a href="../controller/c_alat.php?aksi=tambah" class="btn btn-success"> Tambah Alat</a>
    <br>
    <br>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th> 
                    <th>Stok</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (!empty($data_alat)) {
                $no = 1; 
                foreach ($data_alat as $row): 
            ?>
                <tr>
                    <td style="text-align:center;"><?= $no++; ?></td>
                    <td style="text-align:center;">
                        <?php if(!empty($row->foto)): ?>
                            <img src="<?= htmlspecialchars($row->foto); ?>" alt="Alat" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        <?php else: ?>
                            <small style="color: grey;">Tidak ada foto</small>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row->nama_alat); ?></td>
                    <td><?= htmlspecialchars($row->nama_kategori ?? 'Tanpa Kategori'); ?></td>
                    <td style="text-align:center;">
                        <span style="font-weight: bold; color: <?= ($row->stok < 1) ? '#e74c3c' : '#2c3e50'; ?>;">
                            <?= $row->stok; ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <a href="../controller/c_alat.php?aksi=edit&id=<?= $row->id_alat; ?>" class="btn btn-primary">Edit</a>
                        
                        <a href="../controller/c_alat.php?aksi=hapus&id=<?= $row->id_alat; ?>"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')" 
                           class="btn btn-danger">
                           Hapus
                        </a>
                    </td>
                </tr>
            <?php 
                endforeach; 
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Data Kosong</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</body>
</html>