<?php 
include '../controller/c_peminjaman.php'; 
if (!$data_edit) { header("location:v_peminjaman_admin.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 shadow rounded" style="max-width: 500px; border-top: 5px solid green;">
        <h4 class="mb-4 text-center">Update Pengembalian ID: <?= $data_edit->id_peminjaman; ?></h4>
        
        <form action="../controller/c_peminjaman.php?aksi=update_kembali" method="POST">
            <input type="hidden" name="id_peminjaman" value="<?= $data_edit->id_peminjaman; ?>">

            <div class="mb-3">
                <label class="form-label">Kondisi Barang Masuk</label>
                <select name="kondisi_masuk" class="form-select">
                    <option value="Baik" <?= ($data_edit->kondisi_masuk == 'Baik') ? 'selected' : ''; ?>>Baik</option>
                    <option value="Rusak Ringan" <?= ($data_edit->kondisi_masuk == 'Rusak Ringan') ? 'selected' : ''; ?>>Rusak Ringan</option>
                    <option value="Rusak Berat" <?= ($data_edit->kondisi_masuk == 'Rusak Berat') ? 'selected' : ''; ?>>Rusak Berat</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Kembali Asli</label>
                <input type="date" name="tgl_kembali_asli" class="form-control" value="<?= $data_edit->tgl_kembali_asli; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="v_peminjaman_admin.php?tipe=kembali" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Update Data Kembali</button>
            </div>
        </form>
    </div>
</body>
</html>