<?php
// Memastikan session aktif untuk mengecek siapa yang sedang login (Admin/Petugas/User)
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Menghubungkan ke file koneksi dan model peminjaman
require_once '../model/m_koneksi.php';
require_once '../model/m_peminjaman.php';

// Inisialisasi database dan model
$database = new m_koneksi();
$db = $database->koneksi;
$pinjam_model = new m_peminjaman($db);

// Menangkap instruksi aksi dan ID dari URL
$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';
$role = $_SESSION['role'] ?? '';

// --- AKSI: USER MELAKUKAN PEMINJAMAN ---
if ($aksi == 'proses_pinjam') {
    // Menangkap data dari session (siapa yang pinjam) dan form (barang apa & berapa banyak)
    $id_user = $_SESSION['id_user'];
    $id_alat = $_POST['id_alat'];
    $jumlah  = $_POST['jumlah_pinjam'];
    $kondisi = $_POST['kondisi_keluar'];

    // Memasukkan data ke tabel peminjaman dengan status awal 'pending'
    $simpan = $pinjam_model->tambah_pinjam($id_user, $id_alat, $jumlah, $kondisi);

    if ($simpan) {
        // Mencatat aktivitas ke tabel log
        $pinjam_model->log_aktivitas($_SESSION['id_user'], "User melakukan request pinjam alat baru");
        // Jika berhasil, arahkan user ke riwayat pinjamannya sendiri
        header("location:../view/v_peminjaman_user.php");
        exit();
    } else {
        die("Gagal memproses peminjaman: " . mysqli_error($db));
    }
}

// --- AKSI: PETUGAS MENYETUJUI PINJAMAN ---
if ($aksi == 'setuju') {
    // Mengubah status pending -> dipinjam (dan memotong stok di model)
    $pinjam_model->verifikasi_pinjam($id);
    $pinjam_model->log_aktivitas($_SESSION['id_user'], "Petugas menyetujui peminjaman ID: $id");
    header("location:../view/v_peminjaman_petugas.php");
    exit();
}

// --- AKSI: PETUGAS MENGONFIRMASI PENGEMBALIAN ---
if ($aksi == 'konfirmasi_kembali') {
    // Mengubah status dipinjam -> kembali (dan menambah stok kembali di model)
    $pinjam_model->konfirmasi_kembali($id);
    $pinjam_model->log_aktivitas($_SESSION['id_user'], "Petugas mengonfirmasi pengembalian alat ID: $id");
    header("location:../view/v_peminjaman_petugas.php");
    exit();
}

// --- LOGIKA EDIT: Mengambil data lama sebelum diubah oleh Admin ---
$data_edit = null;
if (isset($_GET['id']) && ($_GET['aksi'] == 'edit_pinjam' || $_GET['aksi'] == 'edit_kembali')) {
    $id_target = $_GET['id'];
    // Query manual untuk mengambil detail pinjaman, nama user, dan nama alat untuk ditampilkan di form edit
    $query_edit = mysqli_query($db, "SELECT p.*, u.username, a.nama_alat 
                                    FROM peminjaman p 
                                    JOIN user u ON p.id_user = u.id_user 
                                    JOIN alat a ON p.id_alat = a.id_alat 
                                    WHERE p.id_peminjaman = '$id_target'");
    $data_edit = mysqli_fetch_object($query_edit);
}

// --- AKSI: ADMIN MENGUBAH DATA PINJAMAN ---
if ($aksi == 'update_pinjam') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $jumlah = $_POST['jumlah_pinjam'];
    $status = $_POST['status'];

    $simpan = $pinjam_model->update_pinjam($id_peminjaman, $jumlah, $status);
    $pinjam_model->log_aktivitas($_SESSION['id_user'], "Admin mengubah data peminjaman ID: " . $_POST['id_peminjaman']);
    if ($simpan) {
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='../view/v_peminjaman_admin.php?tipe=pinjam';</script>";
        exit();
    }
}

// --- AKSI: ADMIN MENGUBAH DATA PENGEMBALIAN ---
if ($aksi == 'update_kembali') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $kondisi = $_POST['kondisi_masuk'];
    $tgl = $_POST['tgl_kembali_asli'];

    $simpan = $pinjam_model->update_kembali($id_peminjaman, $kondisi, $tgl);
    if ($simpan) {
        echo "<script>alert('Data Pengembalian Berhasil Diupdate!'); window.location='../view/v_peminjaman_admin.php?tipe=kembali';</script>";
        exit();
    }
}

// --- LOGIKA TAMPILAN DATA BERDASARKAN ROLE ---
if ($role == 'petugas') {
    // Petugas melihat semua riwayat masuk-keluar alat
    $isi_tabel = $pinjam_model->tampil_data();
} elseif ($role == 'admin') {
    // Admin melihat data berdasarkan filter tipe (pinjam atau kembali)
    $isi_tabel = $pinjam_model->tampil_data_admin($_GET['tipe'] ?? 'pinjam');
} 

// Selalu ambil riwayat milik user yang login agar tampil di dashboard user
if (isset($_SESSION['id_user'])) {
    $isi_tabel_user = $pinjam_model->tampil_data_user($_SESSION['id_user']);
}
?>