<?php 
// Tetap include controller yang sama karena datanya sudah disiapkan di sana
include '../controller/c_peminjaman.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 30px; text-align: right; }
        
        /* Menghilangkan elemen tertentu saat diprint */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN RIWAYAT PEMINJAMAN ALAT</h2>
        <p>SMK SANGKURIANG 1 CIMAHI</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Alat</th>
                <th>Status</th>
                <th>Petugas Pelayan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            // Variabel $isi_tabel otomatis tersedia karena include controller di atas
            while($row = mysqli_fetch_object($isi_tabel)): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row->nama_peminjam; ?></td>
                <td><?= $row->nama_alat; ?></td>
                <td><?= strtoupper($row->status); ?></td>
                <td><?= $row->nama_petugas ?? '-'; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Cimahi, <?= date('d F Y'); ?></p>
        <br><br>
        <p>( ____________________ )</p>
        <p>Petugas Perpustakaan/Sarpras</p>
    </div>

</body>
</html>