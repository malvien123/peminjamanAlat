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

$id_alat = $_GET['id_alat'] ?? '';
$nama_alat = $_GET['nama'] ?? '';
$stok_sekarang = $_GET['stok'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pinjam Alat</title>
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
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 antialiased">

    <!-- Card Form Pinjam -->
    <div class="w-full max-w-md bg-slate-800 text-slate-100 rounded-2xl shadow-2xl border border-slate-700/50 p-8 sm:p-10 my-6">
        
        <!-- Header / Judul -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold tracking-wider text-white uppercase flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-pen text-indigo-500"></i>
                Proses Pendataan
            </h2>
            <p class="text-slate-400 text-sm mt-1">Lengkapi data untuk mengajukan peminjaman</p>
        </div>

        <!-- Form Pemesanan -->
        <form id="formPinjam" action="../controller/c_peminjaman.php?aksi=proses_pinjam" method="POST" class="space-y-4">
            
            <input type="hidden" name="id_alat" value="<?= htmlspecialchars($id_alat); ?>">

            <!-- Nama Peminjam (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Peminjam</label>
                <input 
                    type="text" 
                    value="<?= htmlspecialchars($_SESSION['username']); ?>" 
                    readonly 
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-700/80 text-slate-400 cursor-not-allowed select-none focus:outline-none text-sm font-medium"
                >
            </div>

            <!-- Barang yang Dipilih (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Barang yang Dipilih</label>
                <input 
                    type="text" 
                    value="<?= htmlspecialchars($nama_alat); ?>" 
                    readonly 
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-700/80 text-slate-300 cursor-not-allowed select-none focus:outline-none text-sm font-semibold"
                >
            </div>

            <!-- Tanggal Pinjam (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Tanggal Pinjam</label>
                <input 
                    type="text" 
                    name="tgl_pinjam" 
                    value="<?= date('d F Y'); ?>" 
                    readonly 
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900/60 border border-slate-700/80 text-slate-400 cursor-not-allowed select-none focus:outline-none text-sm"
                >
            </div>

            <!-- Jumlah Pinjam -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="jumlah_pinjam" class="block text-sm font-medium text-slate-300">Jumlah Pinjam</label>
                    <span class="text-xs font-semibold text-indigo-400 bg-indigo-950/60 px-2.5 py-0.5 rounded-md border border-indigo-800/50">
                        Stok: <?= $stok_sekarang; ?>
                    </span>
                </div>
                <input 
                    type="number" 
                    id="jumlah_pinjam"
                    name="jumlah_pinjam" 
                    min="1" 
                    max="<?= $stok_sekarang; ?>"
                    placeholder="Masukkan jumlah..." 
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-sm" 
                    required
                >
            </div>

            <!-- Kondisi Saat Keluar -->
            <div>
                <label for="kondisi_keluar" class="block text-sm font-medium text-slate-300 mb-1">Kondisi Saat Keluar</label>
                <select 
                    id="kondisi_keluar"
                    name="kondisi_keluar" 
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-sm cursor-pointer" 
                    required
                >
                    <option value="Bagus" class="bg-slate-800 text-white">Bagus</option>
                    <option value="Rusak Ringan" class="bg-slate-800 text-white">Rusak Ringan</option>
                </select>
            </div>

            <!-- Tombol Submit & Batal -->
            <div class="pt-4 space-y-3">
                <button 
                    type="button" 
                    onclick="konfirmasiPinjam()"
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-indigo-500/30 transition duration-200 active:scale-[0.98] uppercase tracking-wider cursor-pointer flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-paper-plane"></i> Kirim Request Pinjam
                </button>
                <a 
                    href="v_daftar_alat.php" 
                    class="block text-center text-xs text-slate-400 hover:text-slate-200 transition duration-150 py-1"
                >
                    <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Batal
                </a>
            </div>

        </form>

    </div>

    <!-- ================= SCRIPT JAVASCRIPT ================= -->
    <script>
        const maxStok = <?= (int)$stok_sekarang; ?>;
        const namaAlat = "<?= htmlspecialchars($nama_alat); ?>";

        function konfirmasiPinjam() {
            const inputJumlah = document.getElementById('jumlah_pinjam');
            const jumlah = parseInt(inputJumlah.value) || 0;

            // 1. Validasi Input Kosong atau Kurang dari 1
            if (jumlah < 1) {
                Swal.fire({
                    title: 'Jumlah Tidak Valid',
                    text: 'Silakan masukkan jumlah pinjam minimal 1 barang.',
                    icon: 'warning',
                    confirmButtonColor: '#6366f1', // Indigo-500
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl bg-slate-800 text-slate-100 border border-slate-700',
                        confirmButton: 'px-4 py-2 rounded-xl text-sm font-semibold'
                    }
                });
                return;
            }

            // 2. Validasi Jumlah Melebihi Stok
            if (jumlah > maxStok) {
                Swal.fire({
                    title: 'Stok Tidak Cukup',
                    text: `Jumlah yang diajukan (${jumlah}) melebihi stok yang tersedia (${maxStok}).`,
                    icon: 'error',
                    confirmButtonColor: '#f43f5e', // Rose-500
                    confirmButtonText: 'Perbaiki Jumlah',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl bg-slate-800 text-slate-100 border border-slate-700',
                        confirmButton: 'px-4 py-2 rounded-xl text-sm font-semibold'
                    }
                });
                return;
            }

            // 3. Popup Konfirmasi Sebelum Submit
            Swal.fire({
                title: 'Konfirmasi Pengajuan',
                html: `Apakah Anda yakin ingin mengajukan peminjaman <b>${jumlah} unit</b> alat <b>"${namaAlat}"</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1', // Indigo-500
                cancelButtonColor: '#6b7280',  // Slate-500
                confirmButtonText: '<i class="fa-solid fa-paper-plane mr-1"></i> Ya, Ajukan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl bg-slate-800 text-slate-100 border border-slate-700',
                    confirmButton: 'px-4 py-2 rounded-xl text-sm font-semibold',
                    cancelButton: 'px-4 py-2 rounded-xl text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formPinjam').submit();
                }
            });
        }
    </script>

    <!-- Notifikasi Flash Session (SweetAlert2) -->
    <?php if (isset($_SESSION['pesan'])): ?>
    <script>
        Swal.fire({
            title: '<?= $_SESSION['pesan']['judul']; ?>',
            text: '<?= $_SESSION['pesan']['teks']; ?>',
            icon: '<?= $_SESSION['pesan']['tipe']; ?>',
            confirmButtonColor: '#6366f1',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'rounded-2xl shadow-xl bg-slate-800 text-slate-100 border border-slate-700',
                confirmButton: 'px-5 py-2 rounded-xl text-sm font-semibold'
            }
        });
    </script>
    <?php 
        unset($_SESSION['pesan']); 
    endif; 
    ?>

</body>
</html>