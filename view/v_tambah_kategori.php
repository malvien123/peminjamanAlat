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
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>tambah</title>
  <link rel="stylesheet" href="../asset/style_tambah_user.css">
</head>
<body>

  <div class="container">
    <h2>FORM TAMBAH kategori </h2>
    <form action="../controller/c_kategori.php?aksi=tambah" method="post"> 
      <!-- <label for="id_user">id_user:</label> -->
      
      <label for="nama kategori">Nama kategori:</label>
      <input type="text" id="nama kategori" name="nama kategori" required>

      <label for="keterangan kategori">keterangan:</label>
      <input type="text" id="keterangan kategori" name="keterangan kategori" required>

      <button type="submit" value="Daftar" name="tambah">DAFTAR </button>
      <a href="v_kategori.php" style="display:block; text-align:center; margin-top:10px; color:gray; text-decoration:none; font-size:12px;">Batal</a>
      
    </form>
  </div>

</body>
</html>