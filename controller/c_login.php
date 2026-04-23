<?php
session_start();
require_once '../model/m_koneksi.php';
require_once '../model/m_login.php';
require_once '../model/m_peminjaman.php'; // 1. Tambahkan model peminjaman untuk log

$database = new m_koneksi();
$db = $database->koneksi;

$login_model = new m_login($db);
$pinjam_model = new m_peminjaman($db); // 2. Inisialisasi model log

$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'proses_login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? ''; 

    $data = $login_model->validasi_user($user, $pass);

    if ($data) {
        // Set Session
        $_SESSION['id_user']  = $data->id_user;
        $_SESSION['username'] = $data->username;
        $_SESSION['role']     = $data->role; 

        // 3. CATAT KE LOG: Setiap login berhasil, simpan ke tabel log_aktivitas
        $pinjam_model->log_aktivitas($data->id_user, "User login ke sistem");

        // Redirect sesuai Role
        switch ($data->role) {
            case 'admin':
                header("location:../view/v_tampilan_user.php");
                break;
            case 'petugas':
                header("location:../view/v_peminjaman_petugas.php");
                break;
            case 'peminjam':
                header("location:../view/v_daftar_alat.php");
                break;
            default:
                header("location:../view/v_login.php");
        }
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah!'); window.location='../view/v_login.php';</script>";
        exit();
    }
} 
// ... bagian logout tetap sama
elseif ($aksi == 'logout') {
    session_destroy();
    header("location:../view/v_login.php");
    exit();
}