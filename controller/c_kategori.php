<?php
// session_start();

// require_once '../model/m_koneksi.php'; 
// require_once '../model/m_kategori.php'; 

// $koneksi_obj = new m_koneksi();
// $dbConnection = $koneksi_obj->koneksi; 

// if (!$dbConnection) {
//     die("Koneksi database gagal.");
// }

// $kategori_model = new m_kategori($dbConnection);

// $aksi = $_GET['aksi'] ?? 'tampil'; 
// $id   = $_GET['id'] ?? null;

// // --- LOGIKA TAMPIL DATA ---
// if ($aksi === 'tampil') {
//     $data['kategori'] = $kategori_model->tampil_data();
//     include '../view/v_kategori.php'; 
//     exit();
// } 

// // --- LOGIKA EDIT ---
// elseif ($aksi === 'edit' && $id) {
//     //variabel untuk edit
//     $data_kategori = $kategori_model->tampil_data_by_id($id);
//     include_once '../view/v_update_kategori.php';
//     exit();
// } 

// // --- LOGIKA HAPUS ---
// elseif ($aksi === 'hapus' && $id) {
//     $result = $kategori_model->hapus_data($id);
//     $status = $result ? 'berhasil' : 'gagal';
//     echo "<script>alert('Data kategori $status dihapus'); window.location='c_kategori.php?aksi=tampil';</script>";
//     exit();
// }

// // --- LOGIKA TAMBAH & UPDATE (DIPROSES DARI FORM POST) ---
// elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $id_kategori         = $_POST['id_kategori'] ?? null;
//     $nama_kategori       = $_POST['nama_kategori'] ?? '';
//     $keterangan_kategori = $_POST['keterangan_kategori'] ?? '';

//     if ($aksi === 'tambah') {
//         if (empty($nama_kategori)) {
//             // Jika kosong, balikkan ke halaman form tambah di folder view
//             echo "<script>alert('Nama kategori tidak boleh kosong!'); window.location='../view/v_tambah_kategori.php';</script>";
//             exit();
//         }

//         $result = $kategori_model->tambah_data($nama_kategori, $keterangan_kategori);
//         $status = $result ? 'ditambahkan' : 'gagal ditambahkan';

//     } elseif ($aksi === 'update') {
//         $result = $kategori_model->ubah_data($nama_kategori , $keterangan_kategori , $id_kategori);
//         $status = $result ? 'diperbarui' : 'gagal';
//     }

//     // REDIRECT FINAL: Karena file ini (c_kategori.php) ada di folder controller, 
//     // jangan pakai '../controller/'. Cukup panggil namanya saja.
//     echo "<script>alert('Data kategori $status'); window.location='c_kategori.php?aksi=tampil';</script>";
//     exit();

//     $kategori = new m_kategori();
//     $kategoris = $kategori->tampil_data();
// }


// session_start();
require_once '../model/m_koneksi.php'; 
require_once '../model/m_kategori.php'; 

$koneksi_obj = new m_koneksi();
$dbConnection = $koneksi_obj->koneksi; 

$kategori_model = new m_kategori($dbConnection);

$aksi = $_GET['aksi'] ?? 'tampil'; 
$id   = $_GET['id'] ?? null;

if ($aksi === 'tampil') {
    // Ambil data dan simpan ke variabel untuk View
    $data_kategori = $kategori_model->tampil_data();
    include '../view/v_kategori.php'; 
    exit();
} 

elseif ($aksi === 'edit' && $id) {
    $data_edit = $kategori_model->tampil_data_by_id($id);
    include '../view/v_update_kategori.php';
    exit();
} 
// --- LOGIKA HAPUS ---
elseif ($aksi === 'hapus' && $id) {
    // Memanggil fungsi hapus dari model
    $result = $kategori_model->hapus_data($id);
    
    // Memberikan notifikasi berdasarkan hasil
    if ($result) {
        $status = "berhasil";
    } else {
        $status = "gagal";
    }
    
    echo "<script>
            alert('Data kategori $status dihapus'); 
            window.location='c_kategori.php?aksi=tampil';
          </script>";
    exit();
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kat  = $_POST['id_kategori'] ?? null;
    $nama    = $_POST['nama_kategori'] ?? '';
    $ket     = $_POST['keterangan_kategori'] ?? '';

    if ($aksi === 'tambah') {
        $result = $kategori_model->tambah_data($nama, $ket);
        $msg = $result ? "Ditambah" : "Gagal";
    } elseif ($aksi === 'update') {
        $result = $kategori_model->ubah_data($nama, $ket, $id_kat);
        $msg = $result ? "Diperbarui" : "Gagal";
    }

    echo "<script>alert('Data $msg'); window.location='c_kategori.php?aksi=tampil';</script>";
    exit();
}