<?php
class LogAktivitas {
    private $conn;
    private $table = 'log_aktivitas';

    public $id;
    public $user_id;
    public $aksi;
    public $deskripsi;
    public $ip_address;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Logs
    public function getAll() {
        $query = "SELECT l.*, u.username, u.nama_lengkap
                  FROM " . $this->table . " l
                  JOIN users u ON l.user_id = u.id
                  ORDER BY l.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Logs by User
    public function getByUser($user_id) {
        $query = "SELECT l.*, u.username, u.nama_lengkap
                  FROM " . $this->table . " l
                  JOIN users u ON l.user_id = u.id
                  WHERE l.user_id = :user_id
                  ORDER BY l.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

    // Create Log
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (user_id, aksi, deskripsi, ip_address)
                  VALUES (:user_id, :aksi, :deskripsi, :ip_address)";
        
        $stmt = $this->conn->prepare($query);

        $this->ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':aksi', $this->aksi);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':ip_address', $this->ip_address);

        return $stmt->execute();
    }

    // Get Logs with Limit
    public function getRecent($limit = 10) {
        $query = "SELECT l.*, u.username, u.nama_lengkap
                  FROM " . $this->table . " l
                  JOIN users u ON l.user_id = u.id
                  ORDER BY l.created_at DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?>
