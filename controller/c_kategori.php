<?php
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

// --- LOGIKA TAMPIL DATA ---
if ($aksi === 'tampil') {
    // Meminta semua daftar kategori dari model untuk ditampilkan ke user
    $data_kategori = $kategori_model->tampil_data();
    include '../view/v_kategori.php'; 
    exit();
} 

// --- LOGIKA EDIT ---
elseif ($aksi === 'edit' && $id) {
    // Mengambil data satu kategori saja berdasarkan ID-nya untuk dimasukkan ke form edit
    $data_edit = $kategori_model->tampil_data_by_id($id);
    include '../view/v_update_kategori.php';
    exit();
} 

// --- LOGIKA HAPUS ---
elseif ($aksi === 'hapus' && $id) {
    // Meminta model untuk menghapus data di database
    $result = $kategori_model->hapus_data($id);
    
    // Menentukan status berhasil atau gagal untuk notifikasi
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }
    
    // Muncul notifikasi pop-up dan balik lagi ke halaman kategori
    echo "<script>
            alert('Data kategori $status dihapus'); 
            window.location='c_kategori.php?aksi=tampil';
          </script>";
    exit();
}

// --- LOGIKA SIMPAN DATA (POST) ---
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangkap inputan dari form (nama kategori dan keterangannya)
    $id_kat  = $_POST['id_kategori'] ?? null;
    $nama    = $_POST['nama_kategori'] ?? '';
    $ket     = $_POST['keterangan_kategori'] ?? '';

    // Jika aksinya tambah data baru
    if ($aksi === 'tambah') {
        $result = $kategori_model->tambah_data($nama, $ket);
        $msg = $result ? "Ditambah" : "Gagal";
    } 
    // Jika aksinya update data yang sudah ada
    elseif ($aksi === 'update') {
        $result = $kategori_model->ubah_data($nama, $ket, $id_kat);
        $msg = $result ? "Diperbarui" : "Gagal";
    }

    // Muncul notifikasi dan kembali ke daftar kategori
    echo "<script>alert('Data $msg'); window.location='c_kategori.php?aksi=tampil';</script>";
    exit();
}