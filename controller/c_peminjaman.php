<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once '../model/m_koneksi.php';
require_once '../model/m_peminjaman.php';

$database = new m_koneksi();
$db = $database->koneksi;
$pinjam_model = new m_peminjaman($db);

$aksi = $_GET['aksi'] ?? '';
$id = $_GET['id'] ?? '';
$role = $_SESSION['role'] ?? '';

// --- TAMBAHAN: AKSI UNTUK USER PINJAM (Agar tidak Blank) ---
if ($aksi == 'proses_pinjam') {
    // Ambil data dari $_SESSION dan $_POST
    $id_user = $_SESSION['id_user'];
    $id_alat = $_POST['id_alat'];
    $jumlah  = $_POST['jumlah_pinjam'];
    $kondisi = $_POST['kondisi_keluar'];

    // Panggil fungsi di model m_peminjaman
    $simpan = $pinjam_model->tambah_pinjam($id_user, $id_alat, $jumlah, $kondisi);

    if ($simpan) {
        // Jika berhasil, lempar ke riwayat user
        header("location:../view/v_peminjaman_user.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        die("Gagal memproses peminjaman: " . mysqli_error($db));
    }
}

// --- AKSI PETUGAS (Tetap Sama) ---
if ($aksi == 'setuju') {
    $pinjam_model->verifikasi_pinjam($id);
    header("location:../view/v_peminjaman_petugas.php");
    exit();
}

if ($aksi == 'konfirmasi_kembali') {
    $pinjam_model->konfirmasi_kembali($id);
    header("location:../view/v_peminjaman_petugas.php");
    exit();
}

// --- BAGIAN KRUSIAL: Ambil data satu baris untuk Form Edit ---
$data_edit = null;
if (isset($_GET['id']) && ($_GET['aksi'] == 'edit_pinjam' || $_GET['aksi'] == 'edit_kembali')) {
    $id_target = $_GET['id'];
    $query_edit = mysqli_query($db, "SELECT p.*, u.username, a.nama_alat 
                                    FROM peminjaman p 
                                    JOIN user u ON p.id_user = u.id_user 
                                    JOIN alat a ON p.id_alat = a.id_alat 
                                    WHERE p.id_peminjaman = '$id_target'");
    $data_edit = mysqli_fetch_object($query_edit);
}

// --- PROSES UPDATE PINJAM (Tombol Simpan Perubahan) ---
if ($aksi == 'update_pinjam') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $jumlah = $_POST['jumlah_pinjam'];
    $status = $_POST['status'];

    $simpan = $pinjam_model->update_pinjam($id_peminjaman, $jumlah, $status);
    if ($simpan) {
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='../view/v_peminjaman_admin.php?tipe=pinjam';</script>";
        exit();
    }
}

// --- PROSES UPDATE KEMBALI (Tombol Update Data Kembali) ---
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

// ... (lanjutkan dengan kode aksi lainnya seperti hapus, setuju, dll)

// DATA VIEW
// if ($role == 'petugas') {
//     $isi_tabel = $pinjam_model->tampil_data();
// } elseif ($role == 'admin') {
//     $isi_tabel = $pinjam_model->tampil_data_admin($_GET['tipe'] ?? 'pinjam');
// } elseif ($role == 'peminjam') {
//     // Tambahkan ini agar riwayat user bisa tampil
//     $isi_tabel_user = $pinjam_model->tampil_data_user($_SESSION['id_user']);
// }
// ... (kode aksi-aksi di atas tetap sama)

// --- BAGIAN DATA VIEW ---
if ($role == 'petugas') {
    $isi_tabel = $pinjam_model->tampil_data();
} elseif ($role == 'admin') {
    $isi_tabel = $pinjam_model->tampil_data_admin($_GET['tipe'] ?? 'pinjam');
} 

// TAMBAHKAN INI: Pastikan untuk user selalu mengambil data riwayat
if (isset($_SESSION['id_user'])) {
    $isi_tabel_user = $pinjam_model->tampil_data_user($_SESSION['id_user']);
}
?>