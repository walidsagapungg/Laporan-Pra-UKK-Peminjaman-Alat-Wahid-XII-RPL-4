<?php
class Laporan {
    private $conn;
    private $table = 'laporan';

    public $id;
    public $petugas_id;
    public $bulan;
    public $tahun;
    public $total_peminjaman;
    public $total_pengembalian;
    public $total_rusak;
    public $total_hilang;
    public $total_denda;
    public $catatan;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Laporan
    public function getAll() {
        $query = "SELECT l.*, u.nama_lengkap, u.username
                  FROM " . $this->table . " l
                  JOIN users u ON l.petugas_id = u.id
                  ORDER BY l.tahun DESC, l.bulan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Laporan by ID
    public function getById($id) {
        $query = "SELECT l.*, u.nama_lengkap, u.username
                  FROM " . $this->table . " l
                  JOIN users u ON l.petugas_id = u.id
                  WHERE l.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get Laporan by Month and Year
    public function getByMonthYear($bulan, $tahun) {
        $query = "SELECT l.*, u.nama_lengkap, u.username
                  FROM " . $this->table . " l
                  JOIN users u ON l.petugas_id = u.id
                  WHERE l.bulan = :bulan AND l.tahun = :tahun";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->bindParam(':tahun', $tahun);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create Laporan
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (petugas_id, bulan, tahun, total_peminjaman, total_pengembalian, 
                   total_rusak, total_hilang, total_denda, catatan)
                  VALUES (:petugas_id, :bulan, :tahun, :total_peminjaman, :total_pengembalian,
                          :total_rusak, :total_hilang, :total_denda, :catatan)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':petugas_id', $this->petugas_id);
        $stmt->bindParam(':bulan', $this->bulan);
        $stmt->bindParam(':tahun', $this->tahun);
        $stmt->bindParam(':total_peminjaman', $this->total_peminjaman);
        $stmt->bindParam(':total_pengembalian', $this->total_pengembalian);
        $stmt->bindParam(':total_rusak', $this->total_rusak);
        $stmt->bindParam(':total_hilang', $this->total_hilang);
        $stmt->bindParam(':total_denda', $this->total_denda);
        $stmt->bindParam(':catatan', $this->catatan);

        return $stmt->execute();
    }

    // Update Laporan
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET petugas_id = :petugas_id,
                      bulan = :bulan,
                      tahun = :tahun,
                      total_peminjaman = :total_peminjaman,
                      total_pengembalian = :total_pengembalian,
                      total_rusak = :total_rusak,
                      total_hilang = :total_hilang,
                      total_denda = :total_denda,
                      catatan = :catatan
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':petugas_id', $this->petugas_id);
        $stmt->bindParam(':bulan', $this->bulan);
        $stmt->bindParam(':tahun', $this->tahun);
        $stmt->bindParam(':total_peminjaman', $this->total_peminjaman);
        $stmt->bindParam(':total_pengembalian', $this->total_pengembalian);
        $stmt->bindParam(':total_rusak', $this->total_rusak);
        $stmt->bindParam(':total_hilang', $this->total_hilang);
        $stmt->bindParam(':total_denda', $this->total_denda);
        $stmt->bindParam(':catatan', $this->catatan);

        return $stmt->execute();
    }

    // Delete Laporan
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Generate Statistics
    public function generateStats($bulan, $tahun) {
        // Get peminjaman data
        $query = "SELECT COUNT(*) as total FROM peminjaman 
                  WHERE MONTH(tanggal_pinjam) = :bulan AND YEAR(tanggal_pinjam) = :tahun";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->bindParam(':tahun', $tahun);
        $stmt->execute();
        $total_peminjaman = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Get pengembalian data
        $query = "SELECT COUNT(*) as total, 
                         SUM(CASE WHEN kondisi_alat = 'rusak' THEN 1 ELSE 0 END) as rusak,
                         SUM(CASE WHEN kondisi_alat = 'hilang' THEN 1 ELSE 0 END) as hilang,
                         SUM(denda) as total_denda
                  FROM pengembalian pl
                  JOIN peminjaman p ON pl.peminjaman_id = p.id
                  WHERE MONTH(pl.tanggal_kembali_aktual) = :bulan AND YEAR(pl.tanggal_kembali_aktual) = :tahun";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bulan', $bulan);
        $stmt->bindParam(':tahun', $tahun);
        $stmt->execute();
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);

        return array(
            'total_peminjaman' => $total_peminjaman,
            'total_pengembalian' => $stats['total'] ?? 0,
            'total_rusak' => $stats['rusak'] ?? 0,
            'total_hilang' => $stats['hilang'] ?? 0,
            'total_denda' => $stats['total_denda'] ?? 0
        );
    }
}
?>
