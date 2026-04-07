<?php
class Kategori {
    private $conn;
    private $table = 'kategori';

    public $id;
    public $nama_kategori;
    public $deskripsi;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Kategori
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Kategori by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create Kategori
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (nama_kategori, deskripsi)
                  VALUES (:nama_kategori, :deskripsi)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        $stmt->bindParam(':deskripsi', $this->deskripsi);

        return $stmt->execute();
    }

    // Update Kategori
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET nama_kategori = :nama_kategori,
                      deskripsi = :deskripsi
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        $stmt->bindParam(':deskripsi', $this->deskripsi);

        return $stmt->execute();
    }

    // Delete Kategori
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
