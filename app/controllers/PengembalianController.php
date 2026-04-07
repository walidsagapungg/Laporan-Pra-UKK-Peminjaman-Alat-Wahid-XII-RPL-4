<?php
class PengembalianController {
    private $db;
    private $pengembalianModel;
    private $peminjamanModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->pengembalianModel = new Pengembalian($db);
        $this->peminjamanModel = new Peminjaman($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all pengembalian
    public function index() {
        AuthController::requirePetugas();
        
        $stmt = $this->pengembalianModel->getAll();
        $pengembalians = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/pengembalian/index.php';
        return ob_get_clean();
    }

    // Show create form
    public function create() {
        AuthController::requirePetugas();
        
        // Get peminjaman that are still dipinjam
        $query = "SELECT p.*, u.nama_lengkap, a.nama_alat
                  FROM peminjaman p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  WHERE p.status = 'dipinjam' OR p.status = 'disetujui'
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $peminjamans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pengembalianModel->peminjaman_id = htmlspecialchars($_POST['peminjaman_id'] ?? '');
            $this->pengembalianModel->tanggal_kembali_aktual = htmlspecialchars($_POST['tanggal_kembali_aktual'] ?? '');
            $this->pengembalianModel->kondisi_alat = htmlspecialchars($_POST['kondisi_alat'] ?? '');
            $this->pengembalianModel->catatan = htmlspecialchars($_POST['catatan'] ?? '');

            if ($this->pengembalianModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE PENGEMBALIAN';
                $this->logModel->deskripsi = 'Mencatat pengembalian alat ID: ' . $this->pengembalianModel->peminjaman_id;
                $this->logModel->create();

                $_SESSION['success'] = 'Pengembalian berhasil dicatat!';
                header('Location: ?page=pengembalian');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mencatat pengembalian!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/pengembalian/create.php';
        return ob_get_clean();
    }

    // Return alat (Peminjam)
    public function myReturn() {
        AuthController::requirePeminjam();
        
        $user_id = $_SESSION['user_id'];
        $query = "SELECT p.*, u.nama_lengkap, a.nama_alat
                  FROM peminjaman p
                  JOIN users u ON p.user_id = u.id
                  JOIN alat a ON p.alat_id = a.id
                  WHERE p.user_id = :user_id AND (p.status = 'dipinjam' OR p.status = 'disetujui')
                  ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $peminjamans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/pengembalian/my-return.php';
        return ob_get_clean();
    }

    // Show edit form
    public function edit() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $pengembalian = $this->pengembalianModel->getById($id);

        if (!$pengembalian) {
            $_SESSION['error'] = 'Pengembalian tidak ditemukan!';
            header('Location: ?page=pengembalian');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pengembalianModel->id = $id;
            $this->pengembalianModel->tanggal_kembali_aktual = htmlspecialchars($_POST['tanggal_kembali_aktual'] ?? '');
            $this->pengembalianModel->kondisi_alat = htmlspecialchars($_POST['kondisi_alat'] ?? '');
            $this->pengembalianModel->catatan = htmlspecialchars($_POST['catatan'] ?? '');

            if ($this->pengembalianModel->update()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'UPDATE PENGEMBALIAN';
                $this->logModel->deskripsi = 'Mengubah data pengembalian ID: ' . $id;
                $this->logModel->create();

                $_SESSION['success'] = 'Pengembalian berhasil diubah!';
                header('Location: ?page=pengembalian');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengubah pengembalian!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/pengembalian/edit.php';
        return ob_get_clean();
    }

    // Delete pengembalian
    public function delete() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $pengembalian = $this->pengembalianModel->getById($id);

        if (!$pengembalian) {
            $_SESSION['error'] = 'Pengembalian tidak ditemukan!';
            header('Location: ?page=pengembalian');
            exit;
        }

        if ($this->pengembalianModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE PENGEMBALIAN';
            $this->logModel->deskripsi = 'Menghapus pengembalian ID: ' . $id;
            $this->logModel->create();

            $_SESSION['success'] = 'Pengembalian berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pengembalian!';
        }

        header('Location: ?page=pengembalian');
        exit;
    }
}
?>
