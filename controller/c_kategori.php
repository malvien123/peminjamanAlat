<?php
// Memulai sesi untuk menyimpan data login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengambil file koneksi dan model kategori agar bisa digunakan di sini
require_once '../model/m_koneksi.php'; 
require_once '../model/m_kategori.php'; 

// Inisialisasi koneksi database
$koneksi_obj = new m_koneksi();
$dbConnection = $koneksi_obj->koneksi; 

// Menyiapkan model kategori untuk mengolah tabel kategori di database
$kategori_model = new m_kategori($dbConnection);

// Menangkap perintah aksi dari URL (tampil, edit, atau hapus)
$aksi = $_GET['aksi'] ?? 'tampil'; 
$id   = $_GET['id'] ?? null;


/* ==========================================================================
   1. LOGIKA TAMPIL DATA (READ)
   ========================================================================== */
if ($aksi === 'tampil') {
    // Meminta semua daftar kategori dari model untuk ditampilkan ke user
    $data_kategori = $kategori_model->tampil_data();
    include '../view/v_kategori.php'; 
    exit();
} 


/* ==========================================================================
   2. LOGIKA EDIT (FORM EDIT KATEGORI)
   ========================================================================== */
elseif ($aksi === 'edit' && $id) {
    // Mengambil data satu kategori saja berdasarkan ID-nya untuk dimasukkan ke form edit
    $data_edit = $kategori_model->tampil_data_by_id($id);
    include '../view/v_update_kategori.php';
    exit();
} 


/* ==========================================================================
   3. LOGIKA HAPUS DATA (DELETE)
   ========================================================================== */
elseif ($aksi === 'hapus' && $id) {
    // Meminta model untuk menghapus data di database
    $result = $kategori_model->hapus_data($id);
    $status = $result ? "berhasil" : "gagal";
    
    // Muncul notifikasi pop-up dan dikembalikan ke folder view
    echo "<script>
            alert('Data kategori $status dihapus!'); 
            window.location.href = '../view/v_kategori.php';
          </script>";
    exit();
}


/* ==========================================================================
   4. LOGIKA SIMPAN DATA (POST: TAMBAH & UPDATE)
   ========================================================================== */
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangkap inputan dari form (nama kategori dan keterangannya)
    $id_kat = $_POST['id_kategori'] ?? null;
    $nama   = trim($_POST['nama_kategori'] ?? '');
    $ket    = trim($_POST['keterangan_kategori'] ?? '');

    // --- SUB-LOGIKA A: TAMBAH KATEGORI BARU ---
    if ($aksi === 'tambah') {
        $result = $kategori_model->tambah_data($nama, $ket);
        $msg    = $result ? "berhasil ditambahkan" : "gagal ditambahkan";
        
        echo "<script>
                alert('Data kategori $msg!'); 
                window.location.href = '../view/v_kategori.php';
              </script>";
        exit();
    } 

    // --- SUB-LOGIKA B: UPDATE / UBAH KATEGORI ---
    elseif ($aksi === 'update') {
        $result = $kategori_model->ubah_data($nama, $ket, $id_kat);
        $msg    = $result ? "berhasil diperbarui" : "gagal diperbarui";
        
        echo "<script>
                alert('Data kategori $msg!'); 
                window.location.href = '../view/v_kategori.php';
              </script>";
        exit();
    }
}


/* ==========================================================================
   5. DEFAULT FALLBACK
   ========================================================================== */
else {
    header("Location: ../view/v_kategori.php");
    exit();
}