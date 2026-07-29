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
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 font-sans">

    <!-- Card Form Pinjam -->
    <div class="w-full max-w-md bg-slate-800 text-slate-100 rounded-2xl shadow-2xl border border-slate-700/50 p-8 sm:p-10 my-6">
        
        <!-- Header / Judul -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold tracking-wider text-white uppercase">Proses Pendataan</h2>
            <p class="text-slate-400 text-sm mt-1">Lengkapi data untuk mengajukan peminjaman</p>
        </div>

        <!-- Form Pemesanan -->
        <form action="../controller/c_peminjaman.php?aksi=proses_pinjam" method="POST" class="space-y-4">
            
            <input type="hidden" name="id_alat" value="<?= htmlspecialchars($id_alat); ?>">

            <!-- Nama Peminjam (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Peminjam</label>
                <input 
                    type="text" 
                    value="<?= htmlspecialchars($_SESSION['username']); ?>" 
                    readonly 
                    class="w-full px-4 py-2.5 rounded-lg bg-slate-900/60 border border-slate-700/80 text-slate-400 cursor-not-allowed select-none focus:outline-none text-sm font-medium"
                >
            </div>

            <!-- Barang yang Dipilih (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Barang yang Dipilih</label>
                <input 
                    type="text" 
                    value="<?= htmlspecialchars($nama_alat); ?>" 
                    readonly 
                    class="w-full px-4 py-2.5 rounded-lg bg-slate-900/60 border border-slate-700/80 text-slate-300 cursor-not-allowed select-none focus:outline-none text-sm font-semibold"
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
                    class="w-full px-4 py-2.5 rounded-lg bg-slate-900/60 border border-slate-700/80 text-slate-400 cursor-not-allowed select-none focus:outline-none text-sm"
                >
            </div>

            <!-- Jumlah Pinjam -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="jumlah_pinjam" class="block text-sm font-medium text-slate-300">Jumlah Pinjam</label>
                    <span class="text-xs font-semibold text-indigo-400 bg-indigo-950/60 px-2 py-0.5 rounded border border-indigo-800/50">
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
                    class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-sm" 
                    required
                >
            </div>

            <!-- Kondisi Saat Keluar -->
            <div>
                <label for="kondisi_keluar" class="block text-sm font-medium text-slate-300 mb-1">Kondisi Saat Keluar</label>
                <select 
                    id="kondisi_keluar"
                    name="kondisi_keluar" 
                    class="w-full px-4 py-2.5 rounded-lg bg-slate-900 border border-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-sm cursor-pointer" 
                    required
                >
                    <option value="Bagus" class="bg-slate-800 text-white">Bagus</option>
                    <option value="Rusak Ringan" class="bg-slate-800 text-white">Rusak Ringan</option>
                </select>
            </div>

            <!-- Tombol Submit & Batal -->
            <div class="pt-4 space-y-3">
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-200 active:scale-[0.98] uppercase tracking-wider"
                >
                    Kirim Request Pinjam
                </button>
                <a 
                    href="v_daftar_alat.php" 
                    class="block text-center text-xs text-slate-400 hover:text-slate-200 transition duration-150 py-1"
                >
                    ← Batal
                </a>
            </div>

        </form>

    </div>

</body>
</html>