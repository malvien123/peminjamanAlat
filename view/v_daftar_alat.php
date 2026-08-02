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

// Ambil model secara langsung agar TIDAK memanggil c_alat.php (Mencegah Redirect Loop)
require_once '../model/m_koneksi.php';
require_once '../model/m_alat.php';

$db = (new m_koneksi())->koneksi;
$alat_model = new m_alat($db);
$data_alat = $alat_model->tampil_data();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat Tersedia</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 antialiased">

    <!-- Container Utama -->
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200">
        
        <!-- Header & Navigasi -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-slate-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-purple-900 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-purple-600"></i>
                    Daftar Alat Tersedia
                </h1>
                <p class="text-slate-500 text-sm mt-1">Pilih dan ajukan peminjaman alat yang kamu butuhkan</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="v_peminjaman_user.php" class="px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white font-medium text-sm rounded-xl shadow-sm transition duration-150 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Saya
                </a>
                <button type="button" 
                        onclick="konfirmasiLogout()" 
                        class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-medium text-sm rounded-xl shadow-sm transition duration-150 flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </div>
        </div>

        <!-- Bar Search Client Side -->
        <div class="mb-4 flex justify-between items-center">
            <div class="relative w-full md:w-72">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari barang atau kategori..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-purple-500 focus:bg-white transition">
            </div>
        </div>

        <!-- Tabel Daftar Alat -->
        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
            <table class="w-full text-left border-collapse" id="dataTable">
                <thead>
                    <tr class="bg-purple-900 text-white text-xs font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-16">No</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-28">Foto</th>
                        <th class="py-3 px-4 border-b border-purple-800">Nama Barang</th>
                        <th class="py-3 px-4 border-b border-purple-800">Jenis Barang</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-24">Stok</th>
                        <th class="py-3 px-4 text-center border-b border-purple-800 w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700 text-sm">
                    <?php 
                    $no = 1;
                    if (!empty($data_alat)): 
                        foreach ($data_alat as $row): 
                            $data = (object)$row; 
                    ?>
                    <tr class="hover:bg-purple-50/50 transition duration-150 search-row">
                        <td class="py-3 px-4 text-center font-medium text-slate-500"><?= $no++; ?></td>
                        
                        <!-- Preview Foto Alat -->
                        <td class="py-3 px-4 text-center">
                            <?php if(!empty($data->foto)): ?>
                                <img src="<?= htmlspecialchars($data->foto); ?>" 
                                     onclick="previewGambar('<?= htmlspecialchars($data->foto); ?>', '<?= htmlspecialchars($data->nama_alat); ?>')"
                                     class="w-14 h-14 object-cover rounded-lg border border-slate-200 mx-auto shadow-sm cursor-pointer hover:scale-105 transition duration-200" 
                                     alt="foto">
                            <?php else: ?>
                                <div class="w-14 h-14 bg-slate-100 border border-slate-200 rounded-lg flex items-center justify-center text-[10px] text-slate-400 font-medium mx-auto">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="py-3 px-4 font-bold text-slate-800 search-nama"><?= htmlspecialchars($data->nama_alat); ?></td>
                        <td class="py-3 px-4 text-slate-600 search-kategori"><?= htmlspecialchars($data->nama_kategori); ?></td>
                        
                        <!-- Status Stok -->
                        <td class="py-3 px-4 text-center">
                            <?php if ($data->stok < 1): ?>
                                <span class="inline-block px-2.5 py-1 bg-rose-100 text-rose-700 rounded-md text-xs font-bold border border-rose-200">
                                    Habis
                                </span>
                            <?php else: ?>
                                <span class="inline-block px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-md text-xs font-bold border border-emerald-200">
                                    <?= $data->stok; ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Tombol Pinjam Alat -->
                        <td class="py-3 px-4 text-center">
                            <?php if ($data->stok < 1): ?>
                                <button disabled class="px-3 py-1.5 bg-slate-200 text-slate-400 text-xs font-semibold rounded-lg cursor-not-allowed">
                                    Pinjam Alat
                                </button>
                            <?php else: ?>
                                <a href="v_form_pinjam.php?id_alat=<?= $data->id_alat; ?>&nama=<?= urlencode($data->nama_alat); ?>&stok=<?= $data->stok; ?>" 
                                   class="inline-block px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold rounded-lg shadow transition duration-150">
                                    <i class="fa-solid fa-hand-holding mr-1"></i> Pinjam Alat
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 font-medium">
                            Data alat tidak ditemukan atau stok kosong.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- ================= SCRIPT JAVASCRIPT ================= -->
    <script>
        // 1. Live Search Table
        function filterTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.search-row');

            rows.forEach(row => {
                const nama = row.querySelector('.search-nama')?.textContent.toLowerCase() || '';
                const kategori = row.querySelector('.search-kategori')?.textContent.toLowerCase() || '';

                if (nama.includes(input) || kategori.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // 2. Konfirmasi Logout (SweetAlert2)
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Konfirmasi Sesi',
                text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e', // Rose-500
                cancelButtonColor: '#6b7280',  // Slate-500
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

        // 3. Zoom / Preview Gambar Alat
        function previewGambar(src, nama) {
            Swal.fire({
                title: nama,
                imageUrl: src,
                imageAlt: nama,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    image: 'rounded-xl max-h-96 object-cover'
                }
            });
        }
    </script>

   

</body>
</html>