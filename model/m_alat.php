<?php
class m_alat {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function tampil_data() {
        $sql = "SELECT alat.*, kategori.nama_kategori 
                FROM alat 
                LEFT JOIN kategori ON alat.id_kategori = kategori.id_kategori";
        $query = mysqli_query($this->db, $sql);
        $result = [];
        while ($data = mysqli_fetch_object($query)) {
            $result[] = $data;
        }
        return $result;
    }

    public function tampil_data_by_id($id_alat) {
        $sql = "SELECT * FROM alat WHERE id_alat = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_alat);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public function tambah_data($nama, $kat, $stok, $foto) {
        $sql = "INSERT INTO alat (nama_alat, id_kategori, stok, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siis", $nama, $kat, $stok, $foto);
        return $stmt->execute();
    }

    public function ubah_data($id, $nama, $kat, $stok, $foto) {
        // Urutan SQL: nama(1), kategori(2), stok(3), foto(4) WHERE id(5)
        $sql = "UPDATE alat SET nama_alat=?, id_kategori=?, stok=?, foto=? WHERE id_alat=?";
        $stmt = $this->db->prepare($sql);
        // Bind param: s=string, i=integer. Urutan: siisi
        $stmt->bind_param("siisi", $nama, $kat, $stok, $foto, $id);
        return $stmt->execute();
    }

    public function hapus_data($id) {
        $stmt = $this->db->prepare("DELETE FROM alat WHERE id_alat = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>