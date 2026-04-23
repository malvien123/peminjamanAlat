<?php
session_start();
require_once '../model/m_koneksi.php';
require_once '../model/m_alat.php';
require_once '../model/m_kategori.php';

$db = (new m_koneksi())->koneksi;
$alat_model = new m_alat($db);
$kategori_model = new m_kategori($db);

$aksi = $_REQUEST['aksi'] ?? 'tampil';
$id   = $_REQUEST['id'] ?? null;

if ($aksi === 'tampil') {
    $data_alat = $alat_model->tampil_data();
    
    if (basename($_SERVER['PHP_SELF']) == 'c_alat.php') {
        include '../view/v_alat.php';
    }
} 
elseif ($aksi === 'tambah') {
    $data_kategori = $kategori_model->tampil_data(); 
    include '../view/v_tambah_alat.php';
} 
elseif ($aksi === 'proses_tambah') {
    // Ambil url_foto dari input name="url_foto" di v_tambah_alat
    $foto = $_POST['url_foto'] ?? '';
    $alat_model->tambah_data($_POST['nama_alat'], $_POST['id_kategori'], $_POST['stok'], $foto);
    
    header("location:c_alat.php?aksi=tampil");
    exit();
} 
elseif ($aksi === 'edit') {
    $data_alat = $alat_model->tampil_data_by_id($id);
    $data_kategori = $kategori_model->tampil_data(); 
    include '../view/v_update_alat.php';
} 
elseif ($aksi === 'update') {
    // Ambil data dari v_update_alat
    $id_alat = $_POST['id_alat'];
    $nama    = $_POST['nama_alat'];
    $id_kat  = $_POST['id_kategori'];
    $stok    = $_POST['stok'];
    $foto    = $_POST['url_foto']; // Pastikan di v_update_alat inputnya: name="url_foto"

    $result = $alat_model->ubah_data($id_alat, $nama, $id_kat, $stok, $foto);
    
    if($result) {
        header("location:c_alat.php?aksi=tampil");
    } else {
        echo "Gagal mengupdate data.";
    }
    exit();
} 
elseif ($aksi === 'hapus') {
    $alat_model->hapus_data($id);
    header("location:c_alat.php?aksi=tampil");
    exit();
}
?>