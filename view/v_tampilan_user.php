<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Cek apakah sudah login? Jika belum, balik ke login.php
if (!isset($_SESSION['role'])) {
    header("Location: v_login.php");
    exit();
}

// 2. Jika yang masuk BUKAN admin, dialihkan
if ($_SESSION['role'] !== 'admin') {
    if ($_SESSION['role'] === 'petugas') {
        header("Location: v_peminjaman_petugas.php");
    } else {
        header("Location: v_daftar_alat.php");
    }
    exit();
}

include_once '../controller/c_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Pengguna</title>
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
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-800 text-white font-medium shadow-sm transition">
                        <i class="fa-solid fa-users w-5"></i> Data Pengguna
                    </a>
                    <a href="v_kategori.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-layer-group w-5"></i> Kategori
                    </a>
                    <a href="v_alat.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-toolbox w-5"></i> Data Alat
                    </a>
                    <a href="v_peminjaman_admin.php?tipe=pinjam" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-arrow-right-arrow-left w-5"></i> Peminjaman
                    </a>
                    <a href="v_log_aktivitas.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-indigo-200 hover:bg-indigo-800/50 hover:text-white font-medium transition">
                        <i class="fa-solid fa-clock-history w-5"></i> Log Aktivitas
                    </a>
                </nav>
            </div>

            <!-- Kartu Tambah Pengguna Baru (Bawah Sidebar) -->
            <div class="bg-indigo-800/60 p-4 rounded-2xl border border-indigo-700/50 text-center">
                <i class="fa-solid fa-user-plus text-indigo-300 text-2xl mb-2"></i>
                <h4 class="text-sm font-semibold mb-1">Tambah Pengguna</h4>
                <p class="text-xs text-indigo-300 mb-3">Buat akun admin, petugas, atau siswa baru.</p>
                <a href="../view/v_tambah_user.php" class="inline-block w-full py-2 bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-xs rounded-xl shadow-md transition">
                    + Tambah Akun
                </a>
            </div>
        </aside>

        <!-- ================= KONTEN UTAMA ================= -->
        <main class="flex-1 p-8 overflow-y-auto">

            <!-- Top Header Bar -->
            <header class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Daftar Pengguna Sistem</h2>
                    <p class="text-sm text-slate-500">Kelola semua akun terdaftar di aplikasi peminjaman.</p>
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

            <!-- Banner / Ringkasan Card -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400">Total Pengguna</span>
                        <h3 class="text-xl font-bold text-slate-800"><?= is_array($users) ? count($users) : 0; ?> Akun</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400">Status Akses</span>
                        <h3 class="text-xl font-bold text-slate-800">Hak Akses Full</h3>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400">Role Terdaftar</span>
                        <h3 class="text-xl font-bold text-slate-800">Admin / Petugas / User</h3>
                    </div>
                </div>
            </section>

            <!-- ================= TABEL DATA ================= -->
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Data Akun Terdaftar</h3>
                    <a href="../view/v_tambah_user.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-xl shadow-md transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Pengguna
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-semibold">
                                <th class="p-4 pl-6">No</th>
                                <th class="p-4">ID User</th>
                                <th class="p-4">Username</th>
                                <th class="p-4">Role / Peran</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php 
                            $no = 1;
                            if (is_array($users) && count($users) > 0):
                                foreach ($users as $data):
                            ?>
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="p-4 pl-6 font-medium text-slate-500"><?= $no++; ?></td>
                                    <td class="p-4 font-semibold text-slate-700">#<?= $data->id_user; ?></td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs border">
                                                <?= strtoupper(substr($data->username, 0, 1)); ?>
                                            </div>
                                            <span class="font-medium text-slate-800"><?= htmlspecialchars($data->username); ?></span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <?php if ($data->role === 'admin'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                                Admin
                                            </span>
                                        <?php elseif ($data->role === 'petugas'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                                Petugas
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                User / Peminjam
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-center pr-6">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="v_update_user.php?aksi=edit&id=<?= $data->id_user; ?>" 
                                               class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-medium text-xs rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="../controller/c_user.php?id=<?= $data->id_user; ?>&aksi=hapus" 
                                               onclick="return confirm('Anda yakin mau menghapus data ini?')" 
                                               class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white font-medium text-xs rounded-lg shadow-sm transition flex items-center gap-1">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            else:
                            ?>
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400">
                                        <i class="fa-solid fa-folder-open text-3xl mb-2"></i>
                                        <p>Tidak ada data pengguna yang ditemukan.</p>
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