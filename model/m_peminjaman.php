<?php
class m_peminjaman {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // Tampil SEMUA data untuk Petugas (untuk riwayat & print)
    public function tampil_data() {
        $sql = "SELECT p.*, u.username AS nama_peminjam, a.nama_alat
                FROM peminjaman p
                JOIN user u ON p.id_user = u.id_user
                JOIN alat a ON p.id_alat = a.id_alat
                ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    // Aksi Petugas: Setuju (pending -> dipinjam)
    // Aksi Petugas: Setuju (pending -> dipinjam) + KURANGI STOK
public function verifikasi_pinjam($id) {
    // 1. Ambil data peminjaman untuk tahu id_alat dan jumlahnya
    $data = mysqli_fetch_array(mysqli_query($this->db, "SELECT id_alat, jumlah_pinjam FROM peminjaman WHERE id_peminjaman = '$id'"));
    $id_alat = $data['id_alat'];
    $jumlah = $data['jumlah_pinjam'];

    // 2. Update status peminjaman
    mysqli_query($this->db, "UPDATE peminjaman SET status = 'dipinjam' WHERE id_peminjaman = '$id'");

    // 3. Kurangi stok di tabel alat
    return mysqli_query($this->db, "UPDATE alat SET stok = stok - $jumlah WHERE id_alat = '$id_alat'");
}

// Aksi Petugas: Kembali (dipinjam -> kembali) + TAMBAH STOK
public function konfirmasi_kembali($id) {
    $tgl_skrg = date('Y-m-d');
    
    // 1. Ambil data peminjaman untuk tahu id_alat dan jumlahnya
    $data = mysqli_fetch_array(mysqli_query($this->db, "SELECT id_alat, jumlah_pinjam FROM peminjaman WHERE id_peminjaman = '$id'"));
    $id_alat = $data['id_alat'];
    $jumlah = $data['jumlah_pinjam'];

    // 2. Update status peminjaman
    mysqli_query($this->db, "UPDATE peminjaman SET status = 'kembali', tgl_kembali_asli = '$tgl_skrg', kondisi_masuk = 'Baik' WHERE id_peminjaman = '$id'");

    // 3. Tambahkan kembali stok ke tabel alat
    return mysqli_query($this->db, "UPDATE alat SET stok = stok + $jumlah WHERE id_alat = '$id_alat'");
}

    // --- Fungsi Admin & User Tetap Dipertahankan (Jangan dikurangi) ---
    public function tampil_data_admin($tipe) {
        $where = ($tipe == 'kembali') ? "WHERE p.status = 'kembali'" : "WHERE p.status IN ('pending', 'dipinjam')";
        $sql = "SELECT p.*, u.username AS nama_peminjam, a.nama_alat, k.nama_kategori FROM peminjaman p JOIN user u ON p.id_user = u.id_user JOIN alat a ON p.id_alat = a.id_alat JOIN kategori k ON a.id_kategori = k.id_kategori $where ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    public function update_pinjam($id, $jumlah, $status) {
        return mysqli_query($this->db, "UPDATE peminjaman SET jumlah_pinjam = '$jumlah', status = '$status' WHERE id_peminjaman = '$id'");
    }

    public function update_kembali($id, $kondisi, $tgl) {
        return mysqli_query($this->db, "UPDATE peminjaman SET kondisi_masuk = '$kondisi', tgl_kembali_asli = '$tgl', status = 'kembali' WHERE id_peminjaman = '$id'");
    }

    public function hapus_data($id) {
        return mysqli_query($this->db, "DELETE FROM peminjaman WHERE id_peminjaman = '$id'");
    }

    public function tampil_data_user($id_user) {
        $sql = "SELECT p.*, a.nama_alat FROM peminjaman p JOIN alat a ON p.id_alat = a.id_alat WHERE p.id_user = '$id_user' ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    public function tambah_pinjam($id_user, $id_alat, $jumlah, $kondisi) {
        $tgl_skrg = date('Y-m-d H:i:s');
        $sql = "INSERT INTO peminjaman (id_user, id_alat, jumlah_pinjam, tgl_pinjam, kondisi_keluar, status) VALUES ('$id_user', '$id_alat', '$jumlah', '$tgl_skrg', '$kondisi', 'pending')";
        return mysqli_query($this->db, $sql);
    }
}
?>