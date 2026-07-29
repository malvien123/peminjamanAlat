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

include '../controller/c_peminjaman.php'; 

$tipe_halaman = $_GET['tipe'] ?? 'pinjam'; // Default ke pinjam jika kosong
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi - Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="flex min-h-screen">

        <!-- ================= SIDEBAR KIRI ================= -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col justify-between p-5 shadow-xl">
            <div>
                <!-- Logo & Judul Aplikasi -->
                <div class="flex items-center gap-3 px-2 py-4 border-b border-indigo-800/60 mb-6">
                    <div class="bg-indigo-500 text-white p-2.5 rounded-xl shadow-lg">
                        <i class="fa-solid fa-boxes-packing text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">Peminjaman</h1>
                        <span class="text-xs text-indigo-300">Admin Dashboard</span>
                    </div>
                </div>

                <!-- Menu Navigasi -->
                <nav class="space-y-1.5">
                    <a href="v_tampilan_user.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-users w-5"></i> Data Pengguna
                    </a>
                    <a href="v_kategori.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-layer-group w-5"></i> Kategori
                    </a>
                    <a href="v_alat.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-toolbox w-5"></i> Data Alat
                    </a>
                    <a href="v_peminjaman_admin.php?tipe=pinjam" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-800 text-white font-medium shadow-sm transition">
                        <i class="fa-solid fa-arrow-right-arrow-left w-5"></i> Peminjaman
                    </a>
                    <a href="v_log_aktivitas.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-clock-history w-5"></i> Log Aktivitas
                    </a>
                </nav>
            </div>

            <!-- Info Panel Samping (Bawah Sidebar) -->
            <div class="bg-indigo-800/60 p-4 rounded-2xl border border-indigo-700/50 text-center">
                <i class="fa-solid fa-receipt text-indigo-300 text-2xl mb-2"></i>
                <h4 class="text-sm font-semibold mb-1">Transaksi Aktif</h4>
                <p class="text-xs text-indigo-300 mb-1">Pantau seluruh riwayat peminjaman & pengembalian barang.</p>
            </div>
        </aside>

        <!-- ================= KONTEN UTAMA ================= -->
        <main class="flex-1 p-8 overflow-y-auto">

            <!-- Top Header Bar -->
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        Kelola Transaksi <?= ($tipe_halaman == 'kembali') ? 'Pengembalian' : 'Peminjaman'; ?>
                    </h2>
                    <p class="text-sm text-slate-500">Monitor dan perbarui status transaksi alat.</p>
                </div>

                <!-- Profile Badge & Logout -->
                <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-2xl shadow-sm border border-slate-200/80">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                        <?= strtoupper(substr($_SESSION['role'] ?? 'A', 0, 1)); ?>
                    </div>
                    <div>
                        <p class="text-sm font-semibold capitalize text-slate-800"><?= $_SESSION['role'] ?? 'Admin'; ?></p>
                        <span class="text-xs text-emerald-500 font-medium">● Online</span>
                    </div>
                    <a href="../controller/c_login.php?aksi=logout" 
                       onclick="return confirm('Apakah Anda yakin ingin keluar dari sesi?');" 
                       class="ml-2 text-rose-500 hover:bg-rose-50 p-2 rounded-lg transition" title="Logout">
                        <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    </a>
                </div>
            </header>

            <!-- Navigation Tabs & Actions -->
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                <!-- Tab Menu (Filter Tipe Halaman) -->
                <div class="flex bg-slate-200/80 p-1.5 rounded-2xl gap-1">
                    <a href="v_peminjaman_admin.php?tipe=pinjam" 
                       class="px-5 py-2.5 rounded-xl font-semibold text-xs transition flex items-center gap-2 <?= ($tipe_halaman != 'kembali') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'; ?>">
                        <i class="fa-solid fa-hand-holding"></i> Daftar Peminjaman
                    </a>
                    <a href="v_peminjaman_admin.php?tipe=kembali" 
                       class="px-5 py-2.5 rounded-xl font-semibold text-xs transition flex items-center gap-2 <?= ($tipe_halaman == 'kembali') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'; ?>">
                        <i class="fa-solid fa-box-archive"></i> Daftar Pengembalian
                    </a>
                </div>

                <!-- Tombol Kembali -->
                <a href="../view/v_tampilan_user.php" class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-medium text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <!-- ================= TABEL DATA ================= -->
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">
                        Data <?= ($tipe_halaman == 'kembali') ? 'Pengembalian' : 'Peminjaman'; ?> Alat
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-semibold">
                                <th class="p-4 pl-6 text-center">No</th>
                                <th class="p-4">Peminjam</th>
                                <th class="p-4">Alat & Kategori</th>
                                <th class="p-4 text-center">Jumlah</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php 
                            $no = 1; 
                            if ($isi_tabel && mysqli_num_rows($isi_tabel) > 0):
                                while($row = mysqli_fetch_object($isi_tabel)): 
                            ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4 pl-6 text-center font-medium text-slate-500"><?= $no++; ?></td>
                                    <td class="p-4 font-semibold text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs border">
                                                <?= strtoupper(substr($row->nama_peminjam, 0, 1)); ?>
                                            </div>
                                            <span><?= htmlspecialchars($row->nama_peminjam); ?></span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-bold text-slate-800 mb-0.5"><?= htmlspecialchars($row->nama_alat); ?></p>
                                        <span class="text-xs text-slate-400 font-medium"><?= htmlspecialchars($row->nama_kategori ?? 'Umum'); ?></span>
                                    </td>
                                    <td class="p-4 text-center font-semibold text-slate-700">
                                        <?= $row->jumlah_pinjam; ?> unit
                                    </td>
                                    <td class="p-4 text-center">
                                        <?php 
                                        $st = strtolower($row->status);
                                        if ($st == 'kembali'): 
                                        ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                KEMBALI
                                            </span>
                                        <?php elseif ($st == 'dipinjam'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                                DIPINJAM
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                                <?= strtoupper($row->status); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-center pr-6">
                                        <div class="flex justify-center items-center gap-2">
                                            <?php 
                                            if ($tipe_halaman == 'kembali') {
                                                $link_edit = "v_update_kembali.php?aksi=edit_kembali&id=" . $row->id_peminjaman;
                                            } else {
                                                $link_edit = "v_update_pinjam.php?aksi=edit_pinjam&id=" . $row->id_peminjaman;
                                            }
                                            ?>

                                            <a href="<?= $link_edit; ?>" 
                                               class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>

                                            <a href="../controller/c_peminjaman.php?aksi=hapus&id=<?= $row->id_peminjaman; ?>" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')" 
                                               class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white font-medium text-xs rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                endwhile; 
                            else: 
                            ?>
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">
                                        <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                                        <p>Tidak ada data <strong><?= $tipe_halaman; ?></strong> untuk ditampilkan saat ini.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

</body>
</html>