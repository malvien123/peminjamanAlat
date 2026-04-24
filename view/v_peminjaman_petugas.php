<?php include '../controller/c_peminjaman.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Monitoring Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { 
            .no-print { display: none !important; } 
            .badge { color: black !important; border: 1px solid #ccc; }
        }
    </style>
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h2 class="m-0"><center>Laporan  Peminjaman Alat</h2>
            <a href="../controller/c_login.php?aksi=logout" onclick="return confirm('Apakah Anda yakin ingin keluar dari sesi?');" class="btn btn-danger">logout</a>
            <button onclick="window.print()" class="btn btn-secondary no-print" href="v_cetak_laporan.php">Cetak Laporan</button>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th class="no-print">Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if ($isi_tabel && mysqli_num_rows($isi_tabel) > 0):
                    while($row = mysqli_fetch_object($isi_tabel)): 
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row->nama_peminjam); ?></td>
                    <td><?= htmlspecialchars($row->nama_alat); ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($row->tgl_pinjam)); ?></td>
                    <td>
                     <?= ($row->status == 'kembali') ? $row->tgl_kembali_asli : '-'; ?></td>
                    <td class="text-center">
                        <?php 
                            $badge = 'secondary';
                            if ($row->status == 'pending') $badge = 'warning text-dark';
                            elseif ($row->status == 'dipinjam') $badge = 'info';
                            elseif ($row->status == 'kembali') $badge = 'success';
                        ?>
                        <span class="badge bg-<?= $badge; ?>"><?= strtoupper($row->status); ?></span>
                    </td>
                    <td class="text-center no-print">
                        <?php if ($row->status == 'pending'): ?>
                            <a href="../controller/c_peminjaman.php?aksi=setuju&id=<?= $row->id_peminjaman; ?>" 
                               class="btn btn-sm btn-success">Setuju</a>

                        <?php elseif ($row->status == 'dipinjam'): ?>
                            <a href="../controller/c_peminjaman.php?aksi=konfirmasi_kembali&id=<?= $row->id_peminjaman; ?>" 
                               class="btn btn-sm btn-primary" 
                               onclick="return confirm('Konfirmasi alat sudah kembali?')">Kembali</a>

                        <?php else: ?>
                            <span class="text-muted small">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="6" class="text-center">Tidak ada data riwayat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>