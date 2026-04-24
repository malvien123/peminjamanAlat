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
  <title>Formulir Pendaftaran Pengguna</title>
  <link rel="stylesheet" href="../asset/style_tambah_user.css">
</head>
<body>

  <div class="container">
    <h2>FORM TAMBAH </h2>
    <form action="../controller/c_user.php?aksi=tambah" method="post"> 
      <!-- <label for="id_user">id_user:</label> -->
      
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="role">Role:</label>
      <input type="text" id="role" name="role" value="peminjam" readonly>

      <button type="submit" value="Daftar" name="tambah">DAFTAR </button>
      <a href="v_tampilan_user.php" style="display:block; text-align:center; margin-top:10px; color:gray; text-decoration:none; font-size:12px;">Batal</a>
      
    </form>
  </div>

</body>
</html>
