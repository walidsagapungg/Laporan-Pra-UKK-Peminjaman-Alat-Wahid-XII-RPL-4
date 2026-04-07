<?php
class Alat {
    private $conn;
    private $table = 'alat';

    public $id;
    public $nama_alat;
    public $kategori_id;
    public $deskripsi;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Alat
    public function getAll() {
        $query = "SELECT a.*, k.nama_kategori FROM " . $this->table . " a
                  JOIN kategori k ON a.kategori_id = k.id
                  ORDER BY a.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Alat by ID
    public function getById($id) {
        $query = "SELECT a.*, k.nama_kategori FROM " . $this->table . " a
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE a.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get Available Alat
    public function getAvailable() {
        $query = "SELECT a.*, k.nama_kategori FROM " . $this->table . " a
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE a.status = 'tersedia'
                  ORDER BY a.nama_alat ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create Alat
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (nama_alat, kategori_id, deskripsi, status)
                  VALUES (:nama_alat, :kategori_id, :deskripsi, :status)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama_alat', $this->nama_alat);
        $stmt->bindParam(':kategori_id', $this->kategori_id);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Update Alat
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET nama_alat = :nama_alat,
                      kategori_id = :kategori_id,
                      deskripsi = :deskripsi,
                      status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama_alat', $this->nama_alat);
        $stmt->bindParam(':kategori_id', $this->kategori_id);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Delete Alat
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Update Status
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}
?>
