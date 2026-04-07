<?php
class Peminjaman {
    private $conn;
    private $table = 'peminjaman';

    public $id;
    public $user_id;
    public $alat_id;
    public $tanggal_pinjam;
    public $tanggal_kembali_estimasi;
    public $status;
    public $keterangan;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Peminjaman
    public function getAll() {
        $query = "SELECT p.*, u.nama_lengkap, u.email, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Peminjaman by ID
    public function getById($id) {
        $query = "SELECT p.*, u.nama_lengkap, u.email, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get Peminjaman by User
    public function getByUser($user_id) {
        $query = "SELECT p.*, u.nama_lengkap, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE p.user_id = :user_id
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

    // Get Pending Peminjaman
    public function getPending() {
        $query = "SELECT p.*, u.nama_lengkap, u.email, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE p.status = 'pending'
                  ORDER BY p.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create Peminjaman
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (user_id, alat_id, tanggal_pinjam, tanggal_kembali_estimasi, status, keterangan)
                  VALUES (:user_id, :alat_id, :tanggal_pinjam, :tanggal_kembali_estimasi, :status, :keterangan)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':alat_id', $this->alat_id);
        $stmt->bindParam(':tanggal_pinjam', $this->tanggal_pinjam);
        $stmt->bindParam(':tanggal_kembali_estimasi', $this->tanggal_kembali_estimasi);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':keterangan', $this->keterangan);

        return $stmt->execute();
    }

    // Update Peminjaman
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET user_id = :user_id,
                      alat_id = :alat_id,
                      tanggal_pinjam = :tanggal_pinjam,
                      tanggal_kembali_estimasi = :tanggal_kembali_estimasi,
                      status = :status,
                      keterangan = :keterangan
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':alat_id', $this->alat_id);
        $stmt->bindParam(':tanggal_pinjam', $this->tanggal_pinjam);
        $stmt->bindParam(':tanggal_kembali_estimasi', $this->tanggal_kembali_estimasi);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':keterangan', $this->keterangan);

        return $stmt->execute();
    }

    // Delete Peminjaman
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Approve Peminjaman
    public function approve($id) {
        $query = "UPDATE " . $this->table . " SET status = 'disetujui' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()) {
            // Update alat status to dipinjam
            $peminjaman = $this->getById($id);
            $alatModel = new Alat($this->conn);
            $alatModel->updateStatus($peminjaman['alat_id'], 'dipinjam');
            return true;
        }
        return false;
    }

    // Reject Peminjaman
    public function reject($id) {
        $query = "UPDATE " . $this->table . " SET status = 'ditolak' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Update Status to Dipinjam
    public function markAsDipinjam($id) {
        $query = "UPDATE " . $this->table . " SET status = 'dipinjam' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
