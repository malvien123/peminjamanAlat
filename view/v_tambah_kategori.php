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
      
    </form>
  </div>

</body>
</html>