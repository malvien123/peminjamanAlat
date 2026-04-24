<?php
// Memulai session untuk mengecek hak akses (login)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Memanggil file koneksi dan semua model yang dibutuhkan
require_once '../model/m_koneksi.php';
require_once '../model/m_alat.php';
require_once '../model/m_kategori.php';

// Menyiapkan koneksi database
$db = (new m_koneksi())->koneksi;

// Membuat objek dari model alat dan kategori
$alat_model = new m_alat($db);
$kategori_model = new m_kategori($db);

// Menangkap instruksi aksi (default: tampil) dan ID alat
$aksi = $_REQUEST['aksi'] ?? 'tampil';
$id   = $_REQUEST['id'] ?? null;

// --- LOGIKA TAMPIL DATA ALAT ---
if ($aksi === 'tampil') {
    // Mengambil semua daftar alat dari database melalui model
    $data_alat = $alat_model->tampil_data();
    
    // Memastikan file view hanya dipanggil jika sedang membuka c_alat.php
    if (basename($_SERVER['PHP_SELF']) == 'c_alat.php') {
        include '../view/v_alat.php';
    }
} 

// --- LOGIKA HALAMAN TAMBAH ---
elseif ($aksi === 'tambah') {
    // Kita perlu ambil data kategori agar user bisa memilih kategori saat tambah alat (Dropdown)
    $data_kategori = $kategori_model->tampil_data(); 
    include '../view/v_tambah_alat.php';
} 

// --- LOGIKA PROSES SIMPAN ALAT BARU ---
elseif ($aksi === 'proses_tambah') {
    // Menangkap link/alamat foto yang dimasukkan user
    $foto = $_POST['url_foto'] ?? '';
    // Meminta model untuk memasukkan data ke tabel alat
    $alat_model->tambah_data($_POST['nama_alat'], $_POST['id_kategori'], $_POST['stok'], $foto);
    
    // Setelah simpan, balikkan user ke halaman daftar alat
    header("location:c_alat.php?aksi=tampil");
    exit();
} 

// --- LOGIKA HALAMAN EDIT ---
elseif ($aksi === 'edit') {
    // Mengambil data alat yang mau diedit berdasarkan ID-nya
    $data_alat = $alat_model->tampil_data_by_id($id);
    // Mengambil kategori untuk pilihan dropdown di form edit
    $data_kategori = $kategori_model->tampil_data(); 
    include '../view/v_update_alat.php';
} 

// --- LOGIKA PROSES UPDATE ALAT ---
elseif ($aksi === 'update') {
    // Menangkap semua data kiriman dari form edit (v_update_alat)
    $id_alat = $_POST['id_alat'];
    $nama    = $_POST['nama_alat'];
    $id_kat  = $_POST['id_kategori'];
    $stok    = $_POST['stok'];
    $foto    = $_POST['url_foto']; 

    // Memperbarui data di database melalui model
    $result = $alat_model->ubah_data($id_alat, $nama, $id_kat, $stok, $foto);
    
    if($result) {
        // Jika berhasil, kembali ke daftar alat
        header("location:c_alat.php?aksi=tampil");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal mengupdate data.";
    }
    exit();
} 

// --- LOGIKA HAPUS ALAT ---
elseif ($aksi === 'hapus') {
    // Meminta model untuk menghapus alat berdasarkan ID
    $alat_model->hapus_data($id);
    // Kembali ke daftar alat
    header("location:c_alat.php?aksi=tampil");
    exit();
}
?>