<?php 

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Cek login
if (!isset($_SESSION['role'])) {
    header("Location: v_login.php");
    exit();
}

// 2. Jika yang masuk BUKAN peminjam, tendang ke halaman kerjanya masing-masing
if ($_SESSION['role'] !== 'peminjam') {
    if ($_SESSION['role'] === 'admin') {
        header("Location: v_tampilan_user.php"); // Ke dashboard admin
    } elseif ($_SESSION['role'] === 'petugas') {
        header("Location: v_peminjaman_petugas.php"); // Ke dashboard petugas
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
    <title>Riwayat Saya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 font-sans">

    <!-- Container Utama -->
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200">
        
        <!-- Header & Info User -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-slate-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-purple-900 tracking-tight">
                    Riwayat Peminjaman
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Pengguna Aktif: <span class="font-semibold text-purple-700"><?= htmlspecialchars($_SESSION['username']); ?></span>
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="v_daftar_alat.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150 flex items-center gap-1.5">
                    <span>+</span> Pinjam Alat
                </a>
                
                <!-- Tombol Logout SweetAlert2 -->
                <button type="button" onclick="konfirmasiLogout()" 
                        class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-medium text-sm rounded-lg shadow-sm transition duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-purple-900 text-white text-sm font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-16">No</th>
                        <th class="py-3 px-4 border-b border-purple-800">Nama Alat</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800">Tgl Pinjam</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-36">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700 text-sm">
                    <?php 
                    $no = 1;
                    if (isset($isi_tabel_user) && mysqli_num_rows($isi_tabel_user) > 0):
                        while($row = mysqli_fetch_object($isi_tabel_user)): 
                    ?>
                    <tr class="hover:bg-purple-50/50 transition duration-150">
                        <td class="py-3 px-4 text-center font-medium text-slate-500"><?= $no++; ?></td>
                        <td class="py-3 px-4 font-bold text-slate-800"><?= htmlspecialchars($row->nama_alat); ?></td>
                        <td class="py-3 px-4 text-center whitespace-nowrap"><?= date('d-m-Y', strtotime($row->tgl_pinjam)); ?></td>
                        
                        <!-- Badge Status -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <?php 
                                $badge_bg = 'bg-amber-100 text-amber-800 border-amber-300';
                                if ($row->status == 'kembali') {
                                    $badge_bg = 'bg-emerald-100 text-emerald-800 border-emerald-300';
                                } elseif ($row->status == 'dipinjam') {
                                    $badge_bg = 'bg-sky-100 text-sky-800 border-sky-300';
                                }
                            ?>
                            <span class="inline-block px-3 py-1 rounded-md text-xs font-bold border uppercase tracking-wider <?= $badge_bg; ?>">
                                <?= strtoupper($row->status); ?>
                            </span>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 font-medium">
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Script SweetAlert2 Konfirmasi Logout -->
    <script>
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Konfirmasi sesi',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-right-from-bracket mr-1"></i> Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'px-4 py-2 rounded-xl text-sm font-semibold',
                    cancelButton: 'px-4 py-2 rounded-xl text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../controller/c_login.php?aksi=logout';
                }
            });
        }
    </script>

</body>
</html>