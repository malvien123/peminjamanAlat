

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Alat</title>
    <link rel="stylesheet" href="../asset/style_tambah_alat.css"> 
</head>
<body>
    <div class="container">
        <div>
        
        <h2>Tambah Alat </h2>
        <form action="../controller/c_alat.php?aksi=proses_tambah" method="post">
            <label>Nama Alat:</label>
            <input type="text" name="nama_alat" required placeholder="Masukkan nama alat">

            <label>Kategori:</label>
            <select name="id_kategori" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php foreach ($data_kategori as $kat): ?>
                    <option value="<?= $kat->id_kategori ?>"><?= $kat->nama_kategori ?></option>
                <?php endforeach; ?>
            </select>

            <label>Stok:</label>
            <input type="number" name="stok" required placeholder="0">

            <label>URL Foto Alat:</label>
            <input type="text" name="url_foto" placeholder="Paste link foto di sini" required>

            <button type="submit">Simpan Alat</button>
            <a href="../controller/c_alat.php?aksi=tampil" style="display:block; margin-top:15px; color:#bbb; text-decoration:none; font-size:0.8rem;">&larr; Kembali</a>
        </form>
        
        </div>
    </div>
</body>
</html>