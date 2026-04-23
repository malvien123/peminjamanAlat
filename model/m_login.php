<?php
class m_login {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function validasi_user($username, $password) {
        // Ambil data user berdasarkan username
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_object();
            
            // Verifikasi password hash
            if (password_verify($password, $user->password)) {
                return $user; // Password cocok
            }
        }
        
        return false; // Username tidak ketemu atau password salah
    }
}