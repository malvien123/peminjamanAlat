<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alat</title>
    <link rel="stylesheet" href="../asset/style_tambah_alat.css"> 
</head>
<body>
<div class="container">
    <h2>Edit Data Alat</h2>
    <hr>
    
    <from action="../controller/c_alat.php?aksi=update" method="post">
        
        <input type="hidden" name="id_alat" value="<?= $data_alat->id_alat; ?>">

        <div class="form-group">
            <label>Nama Alat:</label><br>
            <input type="text" name="nama_alat" value="<?= htmlspecialchars($data_alat->nama_alat); ?>" required>
        </div>
        <br>

        <div class="form-group">
            <label>Kategori:</label><br>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php 
                if (!empty($data_kategori)) {
                    foreach ($data_kategori as $kat) {
                        $selected = ($kat->id_kategori == $data_alat->id_kategori) ? "selected" : "";
                        echo "<option value='" . $kat->id_kategori . "' $selected>" . $kat->nama_kategori . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label>Stok:</label><br>
            <input type="number" name="stok" value="<?= $data_alat->stok; ?>" required>
        </div>
        <br>

        <div class="form-group">
            <label>Pratinjau Foto Saat Ini:</label><br>
            <?php if(!empty($data_alat->foto)): ?>
                <img src="<?= $data_alat->foto; ?>" width="120" style="border-radius: 8px; margin-bottom: 10px; border: 1px solid #ddd;"><br>
            <?php else: ?>
                <small style="color: gray; display: block; margin-bottom: 10px;">Tidak ada foto sebelumnya</small>
            <?php endif; ?>
            
            <label>URL Foto Baru (Link Google):</label><br>
            <input type="text" 
                   name="url_foto" 
                   value="<?= htmlspecialchars($data_alat->foto ?? ''); ?>" 
                   placeholder="Tempel link foto Google di sini..." 
                   style="width: 100%; padding: 8px;">
            <small style="color: #ccc;">*Link di atas akan tersimpan otomatis jika tidak diubah.</small>
        </div>
        <br>

        <button type="submit" class="btn-simpan">UPDATE DATA</button>
         <a href="../controller/c_alat.php?aksi=tampil" style="display:block; text-align:center; margin-top:10px; color:gray; text-decoration:none; font-size:12px;">Batal</a>

    </form>
</div>
</body>
</html>