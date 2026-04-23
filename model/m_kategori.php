<?php
include_once 'm_koneksi.php';

class m_kategori {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    // Ambil Semua Data (Mengirimkan Array untuk di-looping di View)
    public function tampil_data() {
        $sql = "SELECT id_kategori, nama_kategori, keterangan_kategori FROM kategori";
        $query = mysqli_query($this->db, $sql);
        $result = [];
        
        if ($query && mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_object($query)) {
                $result[] = $data;
            }
        }
        return $result;   
    }

    public function tampil_data_by_id($id_kategori) {
        $sql = "SELECT * FROM kategori WHERE id_kategori = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_kategori);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_object();
        $stmt->close();
        return $data;
    }

    public function tambah_data($nama, $ket) {
        $sql = "INSERT INTO kategori (nama_kategori, keterangan_kategori) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $nama, $ket);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    public function ubah_data($nama, $ket, $id) {
        $sql = "UPDATE kategori SET nama_kategori = ?, keterangan_kategori = ? WHERE id_kategori = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $nama, $ket, $id);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    public function hapus_data($id) {
        $sql = "DELETE FROM kategori WHERE id_kategori = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
}