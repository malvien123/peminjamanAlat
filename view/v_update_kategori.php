<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>edit kategori</title>
  <link rel="stylesheet" href="../asset/style_tambah_user.css">
</head>
<body>

  <div class="container">
    <h2>FORM update kategori </h2>
    <form action="../controller/c_kategori.php?aksi=update" method="post"> 
  <input type="hidden" name="id_kategori" value="<?= $data_edit->id_kategori; ?>">
  
  <label for="nama kategori">Nama kategori:</label>
  <input type="text" name="nama_kategori" value="<?= $data_edit->nama_kategori; ?>">

  <label for="keterangan kategori">keterangan:</label>
  <input type="text" name="keterangan_kategori" value="<?= $data_edit->keterangan_kategori; ?>">
  
  <button type="submit">Simpan Perubahan</button>
</form>
  </div>

</body>
</html>