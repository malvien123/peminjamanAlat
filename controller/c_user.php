<?php
// Memulai sesi untuk menyimpan data login (seperti id_user dan role)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengambil file koneksi dan model
require_once '../model/m_koneksi.php'; 
require_once '../model/m_user.php'; 

// Membuat objek koneksi database
$koneksi_obj = new m_koneksi();
$dbConnection = $koneksi_obj->koneksi; 

// Cek apakah koneksi berhasil
if (!$dbConnection) {
    die("Koneksi database gagal.");
}

// Menyiapkan model user
$user_model = new m_user($dbConnection);

// Menangkap instruksi aksi & id dari URL
$aksi = $_GET['aksi'] ?? 'tampil'; 
$id   = $_GET['id'] ?? null;


/* ==========================================================================
   1. LOGIKA TAMPIL DATA (READ)
   ========================================================================== */
if ($aksi === 'tampil') {
    // Ambil semua data user dari model
    $users = $user_model->tampil_data();
    
    // Tampilkan file view
    include '../view/v_tampilan_user.php'; 
    exit(); 
} 


/* ==========================================================================
   2. LOGIKA EDIT (FORM EDIT USER)
   ========================================================================== */
elseif ($aksi === 'edit' && $id) {
    // Ambil data user spesifik berdasarkan ID
    $users = $user_model->tampil_data_by_id($id);
    
    // Tampilkan form update
    include_once '../view/v_update_user.php';
    exit();
} 


/* ==========================================================================
   3. LOGIKA HAPUS DATA (DELETE)
   ========================================================================== */
elseif ($aksi === 'hapus' && $id) {
    // Eksekusi hapus data
    $result = $user_model->hapus_data($id);
    $pesan  = $result ? 'berhasil' : 'gagal';
    
    // Alert & Kembalikan URL ke folder view
    echo "<script>
            alert('Data $pesan dihapus!'); 
            window.location.href = '../view/v_tampilan_user.php';
          </script>";
    exit();
}


/* ==========================================================================
   4. LOGIKA PROSES FORM (POST: TAMBAH & UPDATE)
   ========================================================================== */
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Tangkap data input dari Form
    $id_user  = $_POST['id_user'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? null;
    $role     = $_POST['role'] ?? 'peminjam';
    
    // Hash password jika terisi
    $pass_hash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;


    // --- SUB-LOGIKA A: TAMBAH USER / REGISTRASI ---
    if ($aksi === 'tambah') {
        
        // Validasi wajib isi password
        if (empty($password)) {
            echo "<script>
                    alert('Password wajib diisi!'); 
                    window.history.back();
                  </script>";
            exit();
        }
        
        // Eksekusi tambah ke database
        $result = $user_model->tambah_data($username, $pass_hash, $role);
        
        if ($result) {
            // Cek apakah yang menambah data adalah Admin (di dalam dashboard)
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo "<script>
                        alert('User berhasil ditambahkan oleh Admin!'); 
                        window.location.href = '../view/v_tampilan_user.php';
                      </script>";
            } else {
                // Jika registrasi mandiri dari halaman depan
                echo "<script>
                        alert('Registrasi Berhasil! Silakan Login.'); 
                        window.location.href = '../view/v_login.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Gagal menambahkan data user!'); 
                    window.history.back();
                  </script>";
        }
        exit();
    }
    

    // --- SUB-LOGIKA B: UPDATE / UBAH USER ---
    elseif ($aksi === 'update') {
        
        // Eksekusi update data
        $result = $user_model->ubah_data($id_user, $username, $pass_hash);
        
        if ($result) {
            echo "<script>
                    alert('Data user berhasil diperbarui!'); 
                    window.location.href = '../view/v_tampilan_user.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal mengupdate data user!'); 
                    window.history.back();
                  </script>";
        }
        exit();
    }
}


/* ==========================================================================
   5. DEFAULT FALLBACK (Jika Aksinya Tidak Dikenali)
   ========================================================================== */
else {
    header("Location: ../view/v_tampilan_user.php");
    exit();
}