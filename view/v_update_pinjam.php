<?php 
include '../controller/c_peminjaman.php'; 
// Jika data_edit gagal diambil, kembalikan ke halaman utama agar tidak error property on null
if (!$data_edit) { header("location:v_peminjaman_admin.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 shadow rounded" style="max-width: 500px;">
        <h4 class="mb-4 text-center">Edit Peminjaman ID: <?= $data_edit->id_peminjaman; ?></h4>
        
        <form action="../controller/c_peminjaman.php?aksi=update_pinjam" method="POST">
            <input type="hidden" name="id_peminjaman" value="<?= $data_edit->id_peminjaman; ?>">

            <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control bg-light" value="<?= $data_edit->username; ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Alat</label>
                <input type="text" class="form-control bg-light" value="<?= $data_edit->nama_alat; ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Pinjam</label>
                <input type="number" name="jumlah_pinjam" class="form-control" value="<?= $data_edit->jumlah_pinjam; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="pending" <?= ($data_edit->status == 'pending') ? 'selected' : ''; ?>>PENDING</option>
                    <option value="dipinjam" <?= ($data_edit->status == 'dipinjam') ? 'selected' : ''; ?>>DIPINJAM</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="v_peminjaman_admin.php?tipe=pinjam" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>