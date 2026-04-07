<?php
class PeminjamanController {
    private $db;
    private $peminjamanModel;
    private $alatModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->peminjamanModel = new Peminjaman($db);
        $this->alatModel = new Alat($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all peminjaman (Admin)
    public function index() {
        AuthController::requireAdmin();
        
        $stmt = $this->peminjamanModel->getAll();
        $peminjamans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/peminjaman/index.php';
        return ob_get_clean();
    }

    // Get peminjaman for Petugas (approval)
    public function approval() {
        AuthController::requirePetugas();
        
        $stmt = $this->peminjamanModel->getPending();
        $peminjamans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/peminjaman/approval.php';
        return ob_get_clean();
    }

    // Get peminjaman for Peminjam
    public function myPeminjaman() {
        AuthController::requirePeminjam();
        
        $user_id = $_SESSION['user_id'];
        $stmt = $this->peminjamanModel->getByUser($user_id);
        $peminjamans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/peminjaman/my-peminjaman.php';
        return ob_get_clean();
    }

    // Show create form (Peminjam)
    public function create() {
        AuthController::requirePeminjam();
        
        $user_id = $_SESSION['user_id'];
        $stmt = $this->alatModel->getAvailable();
        $alats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->peminjamanModel->user_id = $user_id;
            $this->peminjamanModel->alat_id = htmlspecialchars($_POST['alat_id'] ?? '');
            $this->peminjamanModel->tanggal_pinjam = htmlspecialchars($_POST['tanggal_pinjam'] ?? '');
            $this->peminjamanModel->tanggal_kembali_estimasi = htmlspecialchars($_POST['tanggal_kembali_estimasi'] ?? '');
            $this->peminjamanModel->status = 'pending';
            $this->peminjamanModel->keterangan = htmlspecialchars($_POST['keterangan'] ?? '');

            if ($this->peminjamanModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE PEMINJAMAN';
                $this->logModel->deskripsi = 'Membuat pengajuan peminjaman alat';
                $this->logModel->create();

                $_SESSION['success'] = 'Pengajuan peminjaman berhasil dibuat!';
                header('Location: ?page=myPeminjaman');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal membuat pengajuan peminjaman!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/peminjaman/create.php';
        return ob_get_clean();
    }

    // Approve peminjaman
    public function approve() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $peminjaman = $this->peminjamanModel->getById($id);

        if (!$peminjaman) {
            $_SESSION['error'] = 'Peminjaman tidak ditemukan!';
            header('Location: ?page=approval');
            exit;
        }

        if ($this->peminjamanModel->approve($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'APPROVE PEMINJAMAN';
            $this->logModel->deskripsi = 'Menyetujui peminjaman alat ID: ' . $id;
            $this->logModel->create();

            $_SESSION['success'] = 'Peminjaman berhasil disetujui!';
        } else {
            $_SESSION['error'] = 'Gagal menyetujui peminjaman!';
        }

        header('Location: ?page=approval');
        exit;
    }

    // Reject peminjaman
    public function reject() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $peminjaman = $this->peminjamanModel->getById($id);

        if (!$peminjaman) {
            $_SESSION['error'] = 'Peminjaman tidak ditemukan!';
            header('Location: ?page=approval');
            exit;
        }

        if ($this->peminjamanModel->reject($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'REJECT PEMINJAMAN';
            $this->logModel->deskripsi = 'Menolak peminjaman alat ID: ' . $id;
            $this->logModel->create();

            $_SESSION['success'] = 'Peminjaman berhasil ditolak!';
        } else {
            $_SESSION['error'] = 'Gagal menolak peminjaman!';
        }

        header('Location: ?page=approval');
        exit;
    }

    // Delete peminjaman
    public function delete() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $peminjaman = $this->peminjamanModel->getById($id);

        if (!$peminjaman) {
            $_SESSION['error'] = 'Peminjaman tidak ditemukan!';
            header('Location: ?page=peminjaman');
            exit;
        }

        if ($this->peminjamanModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE PEMINJAMAN';
            $this->logModel->deskripsi = 'Menghapus peminjaman ID: ' . $id;
            $this->logModel->create();

            $_SESSION['success'] = 'Peminjaman berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus peminjaman!';
        }

        header('Location: ?page=peminjaman');
        exit;
    }
}
?>
