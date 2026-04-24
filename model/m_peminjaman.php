<?php
class m_peminjaman {
    private $db;

    // Menghubungkan model dengan koneksi database utama
    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // Fungsi untuk mencatat setiap klik atau aksi penting user ke tabel log_aktivitas
    public function log_aktivitas($id_user, $aksi) {
        $waktu = date('Y-m-d H:i:s');
        $sql = "INSERT INTO log_aktivitas (id_user, aksi, waktu) VALUES ('$id_user', '$aksi', NOW())";
        $query = mysqli_query($this->db, $sql);
        
        if (!$query) {
            die("Gagal simpan log: " . mysqli_error($this->db));
        }
        return $query;
    }

    // Mengambil semua data log untuk ditampilkan di dashboard admin
    public function tampil_log_aktivitas() {
        $sql = "SELECT l.*, u.username FROM log_aktivitas l 
                JOIN user u ON l.id_user = u.id_user 
                ORDER BY l.id_log DESC";
        return mysqli_query($this->db, $sql);
    }

    // Mengambil semua data peminjaman (Menggabungkan tabel user dan alat)
    public function tampil_data() {
        $sql = "SELECT p.*, u.username AS nama_peminjam, a.nama_alat
                FROM peminjaman p
                JOIN user u ON p.id_user = u.id_user
                JOIN alat a ON p.id_alat = a.id_alat
                ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    // --- LOGIKA KRUSIAL: Verifikasi Pinjaman (Stok Berkurang) ---
    public function verifikasi_pinjam($id) {
        // 1. Cari tahu dulu barang apa yang dipinjam dan berapa jumlahnya
        $data = mysqli_fetch_array(mysqli_query($this->db, "SELECT id_alat, jumlah_pinjam FROM peminjaman WHERE id_peminjaman = '$id'"));
        $id_alat = $data['id_alat'];
        $jumlah = $data['jumlah_pinjam'];

        // 2. Ubah status menjadi 'dipinjam'
        mysqli_query($this->db, "UPDATE peminjaman SET status = 'dipinjam' WHERE id_peminjaman = '$id'");

        // 3. KURANGI STOK alat karena barang sudah dibawa user
        return mysqli_query($this->db, "UPDATE alat SET stok = stok - $jumlah WHERE id_alat = '$id_alat'");
    }

    // --- LOGIKA KRUSIAL: Konfirmasi Kembali (Stok Bertambah) ---
    public function konfirmasi_kembali($id) {
        $tgl_skrg = date('Y-m-d H:i:s'); 
        
        // 1. Ambil info barang dan jumlah yang dikembalikan
        $data = mysqli_fetch_array(mysqli_query($this->db, "SELECT id_alat, jumlah_pinjam FROM peminjaman WHERE id_peminjaman = '$id'"));
        $id_alat = $data['id_alat'];
        $jumlah = $data['jumlah_pinjam'];

        // 2. Update status jadi kembali dan catat tanggal kembalinya secara otomatis
        mysqli_query($this->db, "UPDATE peminjaman SET status = 'kembali', tgl_kembali_asli = '$tgl_skrg', kondisi_masuk = 'Baik' WHERE id_peminjaman = '$id'");

        // 3. TAMBAHKAN STOK alat kembali karena barang sudah dikembalikan ke gudang
        return mysqli_query($this->db, "UPDATE alat SET stok = stok + $jumlah WHERE id_alat = '$id_alat'");
    }

    // Mengambil data untuk admin dengan filter (sedang dipinjam atau sudah kembali)
    public function tampil_data_admin($tipe) {
        $where = ($tipe == 'kembali') ? "WHERE p.status = 'kembali'" : "WHERE p.status IN ('pending', 'dipinjam')";
        $sql = "SELECT p.*, u.username AS nama_peminjam, a.nama_alat, k.nama_kategori 
                FROM peminjaman p 
                JOIN user u ON p.id_user = u.id_user 
                JOIN alat a ON p.id_alat = a.id_alat 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                $where ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    // Fungsi update untuk Admin jika ada kesalahan data jumlah atau status
    public function update_pinjam($id, $jumlah, $status) {
        return mysqli_query($this->db, "UPDATE peminjaman SET jumlah_pinjam = '$jumlah', status = '$status' WHERE id_peminjaman = '$id'");
    }

    // Fungsi update untuk Admin saat mengelola data pengembalian
    public function update_kembali($id, $kondisi, $tgl) {
        return mysqli_query($this->db, "UPDATE peminjaman SET kondisi_masuk = '$kondisi', tgl_kembali_asli = '$tgl', status = 'kembali' WHERE id_peminjaman = '$id'");
    }

    // Menghapus record peminjaman
    public function hapus_data($id) {
        return mysqli_query($this->db, "DELETE FROM peminjaman WHERE id_peminjaman = '$id'");
    }

    // Menampilkan riwayat pinjam khusus untuk 1 user (yang sedang login)
    public function tampil_data_user($id_user) {
        $sql = "SELECT p.*, a.nama_alat FROM peminjaman p JOIN alat a ON p.id_alat = a.id_alat WHERE p.id_user = '$id_user' ORDER BY p.id_peminjaman DESC";
        return mysqli_query($this->db, $sql);
    }

    // Menambahkan antrian pinjaman baru dari user (Status masih Pending)
    public function tambah_pinjam($id_user, $id_alat, $jumlah, $kondisi) {
        $tgl_skrg = date('Y-m-d H:i:s');
        $sql = "INSERT INTO peminjaman (id_user, id_alat, jumlah_pinjam, tgl_pinjam, kondisi_keluar, status) VALUES ('$id_user', '$id_alat', '$jumlah', '$tgl_skrg', '$kondisi', 'pending')";
        return mysqli_query($this->db, $sql);
    }
}
?>