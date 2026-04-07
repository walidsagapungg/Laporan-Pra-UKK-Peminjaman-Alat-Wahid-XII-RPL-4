<?php
class Pengembalian {
    private $conn;
    private $table = 'pengembalian';

    public $id;
    public $peminjaman_id;
    public $tanggal_kembali_aktual;
    public $kondisi_alat;
    public $catatan;
    public $denda;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Pengembalian
    public function getAll() {
        $query = "SELECT pl.*, p.user_id, p.alat_id, p.tanggal_kembali_estimasi,
                         u.nama_lengkap, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " pl
                  JOIN peminjaman p ON pl.peminjaman_id = p.id
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  ORDER BY pl.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Pengembalian by ID
    public function getById($id) {
        $query = "SELECT pl.*, p.user_id, p.alat_id, p.tanggal_pinjam, p.tanggal_kembali_estimasi,
                         u.nama_lengkap, a.nama_alat, k.nama_kategori
                  FROM " . $this->table . " pl
                  JOIN peminjaman p ON pl.peminjaman_id = p.id
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  JOIN kategori k ON a.kategori_id = k.id
                  WHERE pl.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get by Peminjaman
    public function getByPeminjaman($peminjaman_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE peminjaman_id = :peminjaman_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':peminjaman_id', $peminjaman_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create Pengembalian
    public function create() {
        // Calculate denda if late
        $query = "SELECT p.tanggal_kembali_estimasi FROM peminjaman p WHERE p.id = :peminjaman_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':peminjaman_id', $this->peminjaman_id);
        $stmt->execute();
        $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->denda = 0;
        if (strtotime($this->tanggal_kembali_aktual) > strtotime($peminjaman['tanggal_kembali_estimasi'])) {
            $days_late = ceil((strtotime($this->tanggal_kembali_aktual) - strtotime($peminjaman['tanggal_kembali_estimasi'])) / (60 * 60 * 24));
            $this->denda = $days_late * 50000; // Rp 50,000 per hari
        }

        $query = "INSERT INTO " . $this->table . "
                  (peminjaman_id, tanggal_kembali_aktual, kondisi_alat, catatan, denda)
                  VALUES (:peminjaman_id, :tanggal_kembali_aktual, :kondisi_alat, :catatan, :denda)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':peminjaman_id', $this->peminjaman_id);
        $stmt->bindParam(':tanggal_kembali_aktual', $this->tanggal_kembali_aktual);
        $stmt->bindParam(':kondisi_alat', $this->kondisi_alat);
        $stmt->bindParam(':catatan', $this->catatan);
        $stmt->bindParam(':denda', $this->denda);

        if ($stmt->execute()) {
            // Update peminjaman status
            $query = "UPDATE peminjaman SET status = 'selesai' WHERE id = :peminjaman_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':peminjaman_id', $this->peminjaman_id);
            $stmt->execute();

            // Update alat status
            if ($this->kondisi_alat == 'hilang') {
                $query = "UPDATE alat SET status = 'rusak' WHERE id = (SELECT alat_id FROM peminjaman WHERE id = :peminjaman_id)";
            } else {
                $query = "UPDATE alat SET status = 'tersedia' WHERE id = (SELECT alat_id FROM peminjaman WHERE id = :peminjaman_id)";
            }
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':peminjaman_id', $this->peminjaman_id);
            $stmt->execute();

            return true;
        }
        return false;
    }

    // Update Pengembalian
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET tanggal_kembali_aktual = :tanggal_kembali_aktual,
                      kondisi_alat = :kondisi_alat,
                      catatan = :catatan
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':tanggal_kembali_aktual', $this->tanggal_kembali_aktual);
        $stmt->bindParam(':kondisi_alat', $this->kondisi_alat);
        $stmt->bindParam(':catatan', $this->catatan);

        return $stmt->execute();
    }

    // Delete Pengembalian
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
