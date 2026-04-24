<?php
// Memulai sesi untuk menyimpan data login (seperti id_user dan role)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengambil file koneksi dan model agar bisa digunakan di controller ini
require_once '../model/m_koneksi.php'; 
require_once '../model/m_user.php'; 

// Membuat objek koneksi database
$koneksi_obj = new m_koneksi();
$dbConnection = $koneksi_obj->koneksi; 

// Cek apakah koneksi berhasil, jika gagal hentikan program
if (!$dbConnection) {
    die("Koneksi database gagal.");
}

// Menyiapkan model user untuk mengolah data tabel user
$user_model = new m_user($dbConnection);

// Menangkap instruksi aksi dari URL (default-nya adalah 'tampil')
$aksi = $_GET['aksi'] ?? 'tampil'; 
$id   = $_GET['id'] ?? null;

// --- LOGIKA TAMPIL DATA ---
if ($aksi === 'tampil') {
    // Meminta data dari model, lalu dikirim ke file view v_tampilan_user
    $users = $user_model->tampil_data();
    include '../view/v_tampilan_user.php'; 
    exit(); 
} 

// --- LOGIKA EDIT ---
elseif ($aksi === 'edit' && $id) {
    // Mengambil data spesifik satu orang berdasarkan ID untuk diedit
    $users = $user_model->tampil_data_by_id($id);
    include_once '../view/v_update_user.php';
    exit();
} 

// --- LOGIKA HAPUS ---
elseif ($aksi === 'hapus' && $id) {
    // Menjalankan fungsi hapus di database melalui model
    $result = $user_model->hapus_data($id);
    $pesan = $result ? 'berhasil' : 'gagal';
    // Memberikan notifikasi dan kembali ke daftar user
    echo "<script>alert('Data $pesan dihapus'); window.location='c_user.php';</script>";
    exit();
}

// --- LOGIKA TAMBAH & UPDATE (Menerima input dari Form) ---
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangkap data yang diketikkan user di form
    $id_user   = $_POST['id_user'] ?? null;
    $username  = $_POST['username'] ?? '';
    $password  = $_POST['password'] ?? null;
    $role      = $_POST['role'] ?? 'peminjam';
    
    // Mengubah password menjadi kode acak (Hash) agar aman di database
    $pass_hash = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Jika aksinya adalah tambah data (Registrasi/Tambah User)
    if ($aksi === 'tambah') {
        if (!$password) {
            echo "<script>alert('Password wajib diisi!'); window.history.back();</script>";
            exit();
        }
        $result = $user_model->tambah_data($username, $pass_hash, $role);
        
        if ($result) {
            // Jika yang daftar adalah peminjam, suruh dia login dulu
            if ($role === 'peminjam') {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='../view/v_login.php';</script>";
            } else {
                // Jika admin yang nambah petugas, balik ke dashboard admin
                echo "<script>alert('Data Berhasil Ditambahkan'); window.location='c_user.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal menambahkan data'); window.history.back();</script>";
        }
        exit();

    // Jika aksinya adalah update data
    } elseif ($aksi === 'update') {
        $result = $user_model->ubah_data($id_user, $username, $pass_hash);
        $status = $result ? 'diperbarui' : 'gagal';
        echo "<script>alert('Data $status'); window.location='c_user.php';</script>";
        exit();
    }
}