<?php
class DashboardController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        AuthController::requireLogin();
        
        // Get statistics
        $stats = array();

        // Total Users
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total Alat
        $query = "SELECT COUNT(*) as total FROM alat";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_alat'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total Alat Tersedia
        $query = "SELECT COUNT(*) as total FROM alat WHERE status = 'tersedia'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['alat_tersedia'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total Peminjaman
        $query = "SELECT COUNT(*) as total FROM peminjaman";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_peminjaman'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Pending Peminjaman
        $query = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['pending_peminjaman'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Peminjaman Aktif
        $query = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'dipinjam'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['aktif_peminjaman'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Recent Activities
        $query = "SELECT l.*, u.username FROM log_aktivitas l
                  JOIN users u ON l.user_id = u.id
                  ORDER BY l.created_at DESC LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['recent_activities'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/dashboard.php';
        return ob_get_clean();
    }
}
?>
