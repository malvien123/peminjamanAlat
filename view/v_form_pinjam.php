<?php 
include '../controller/c_peminjaman.php'; 

// Proteksi: Hanya user (peminjam) yang bisa akses form ini
if ($_SESSION['role'] !== 'peminjam') {
    header("location:v_login.php");
    exit();
}

$id_alat = $_GET['id_alat'];
$nama_alat = $_GET['nama'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pinjam Alat</title>
</head>
<body>
    <div style="width: 400px; border: 1px solid #ccc; padding: 20px; margin: 20px auto; font-family: sans-serif;">
        <h3 style="text-align: center; border-bottom: 2px solid blue; padding-bottom: 10px;">Proses Pendataan</h3>
        
        <form action="../controller/c_peminjaman.php?aksi=proses_pinjam" method="POST">
            <input type="hidden" name="id_alat" value="<?= $id_alat; ?>">

            <p><strong>Nama Peminjam:</strong><br>
            <input type="text" value="<?= $_SESSION['username']; ?>" style="width: 95%; padding: 8px; margin-top: 5px; background: #eee;" readonly></p>

            <p><strong>Barang yang Dipilih:</strong><br>
            <input type="text" value="<?= $nama_alat; ?>" style="width: 95%; padding: 8px; margin-top: 5px; background: #eee;" readonly></p>

            <p><strong>Tanggal Pinjam:</strong><br>
            <input type="text" name="tgl_pinjam" value="<?= date('d F Y'); ?>" style="width: 95%; padding: 8px; margin-top: 5px; background: #eee;" readonly></p>

            <?php $stok_sekarang = $_GET['stok'] ?? 0; ?>

            <p><strong>Jumlah Pinjam:</strong> (Stok tersedia: <?= $stok_sekarang; ?>)</p>
            <input type="number" name="jumlah_pinjam" min="1" max="<?= $stok_sekarang; ?>"placeholder="Masukkan jumlah..." style="width: 95%; padding: 8px; margin-top: 5px;" required>

            <p><strong>Kondisi Saat Keluar:</strong><br>
            <select name="kondisi_keluar" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                <option value="Bagus">Bagus</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
            </select></p>

            <div style="margin-top: 20px;">
                <button type="submit" style="width:100%; background:blue; color:white; padding:12px; border:none; cursor:pointer; font-weight:bold;">KIRIM REQUEST PINJAM</button>
                <a href="v_daftar_alat.php" style="display:block; text-align:center; margin-top:10px; color:gray; text-decoration:none; font-size:12px;">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>