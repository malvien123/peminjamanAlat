<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Cek apakah sudah login?
if (!isset($_SESSION['role'])) {
    header("Location: v_login.php");
    exit();
}

// 2. Jika yang masuk BUKAN petugas, maka ditendang balik
if ($_SESSION['role'] !== 'petugas') {
    if ($_SESSION['role'] === 'admin') {
        // Jika admin nyasar ke sini, balikin ke dashboard admin
        header("Location: v_tampilan_user.php");
    } else {
        // Jika peminjam nyasar ke sini, balikin ke dashboard user
        header("Location: v_daftar_alat.php");
    }
    exit();
}

include '../controller/c_peminjaman.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Peminjaman</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Khusus Cetak agar Tombol & Kolom Aksi Tidak Ikut Tercetak */
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 font-sans">

    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200">
        
        <!-- Header & Tombol Aksi -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-slate-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-purple-900 tracking-tight">
                    Laporan Peminjaman Alat
                </h1>
                <p class="text-slate-500 text-sm mt-1">Monitoring dan konfirmasi data peminjaman petugas</p>
            </div>
            
            <div class="flex items-center gap-3 no-print">
                <a href="../controller/c_login.php?aksi=logout" 
                   onclick="return confirm('Apakah Anda yakin ingin keluar dari sesi?');" 
                   class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150">
                    Logout
                </a>
                <button onclick="window.print()" 
                        class="px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Tabel Monitoring Peminjaman -->
        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-purple-900 text-white text-sm font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4 text-center border-b border-purple-800">No</th>
                        <th class="py-3 px-4 border-b border-purple-800">Nama Peminjam</th>
                        <th class="py-3 px-4 border-b border-purple-800">Nama Alat</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800">Tgl Pinjam</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800">Tgl Kembali</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800">Status</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800 no-print">Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700 text-sm">
                    <?php 
                    $no = 1;
                    if ($isi_tabel && mysqli_num_rows($isi_tabel) > 0):
                        while($row = mysqli_fetch_object($isi_tabel)): 
                    ?>
                    <tr class="hover:bg-purple-50/50 transition duration-150">
                        <td class="py-3 px-4 text-center font-medium text-slate-500"><?= $no++; ?></td>
                        <td class="py-3 px-4 font-semibold text-slate-800"><?= htmlspecialchars($row->nama_peminjam); ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($row->nama_alat); ?></td>
                        <td class="py-3 px-4 text-center whitespace-nowrap"><?= date('d-m-Y', strtotime($row->tgl_pinjam)); ?></td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <?= ($row->status == 'kembali') ? $row->tgl_kembali_asli : '<span class="text-slate-400">-</span>'; ?>
                        </td>
                        
                        <!-- Badge Status -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <?php 
                                $badge_bg = 'bg-slate-100 text-slate-600 border-slate-300';
                                if ($row->status == 'pending') {
                                    $badge_bg = 'bg-amber-100 text-amber-800 border-amber-300';
                                } elseif ($row->status == 'dipinjam') {
                                    $badge_bg = 'bg-sky-100 text-sky-800 border-sky-300';
                                } elseif ($row->status == 'kembali') {
                                    $badge_bg = 'bg-emerald-100 text-emerald-800 border-emerald-300';
                                }
                            ?>
                            <span class="inline-block px-3 py-1 rounded-md text-xs font-bold border uppercase tracking-wider <?= $badge_bg; ?>">
                                <?= strtoupper($row->status); ?>
                            </span>
                        </td>

                        <!-- Tombol Konfirmasi -->
                        <td class="py-3 px-4 text-center whitespace-nowrap no-print">
                            <?php if ($row->status == 'pending'): ?>
                                <a href="../controller/c_peminjaman.php?aksi=setuju&id=<?= $row->id_peminjaman; ?>" 
                                   class="inline-block px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded shadow transition duration-150">
                                    Setuju
                                </a>

                            <?php elseif ($row->status == 'dipinjam'): ?>
                                <a href="../controller/c_peminjaman.php?aksi=konfirmasi_kembali&id=<?= $row->id_peminjaman; ?>" 
                                   class="inline-block px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded shadow transition duration-150" 
                                   onclick="return confirm('Konfirmasi alat sudah kembali?')">
                                    Kembali
                                </a>

                            <?php else: ?>
                                <span class="text-slate-400 text-xs italic">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-500 font-medium">
                            Tidak ada data riwayat peminjaman.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>