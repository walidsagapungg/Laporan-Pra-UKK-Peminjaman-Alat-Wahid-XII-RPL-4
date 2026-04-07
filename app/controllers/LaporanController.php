<?php
class LaporanController {
    private $db;
    private $laporanModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->laporanModel = new Laporan($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all laporan
    public function index() {
        AuthController::requirePetugas();
        
        $stmt = $this->laporanModel->getAll();
        $laporans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/laporan/index.php';
        return ob_get_clean();
    }

    // Show create form
    public function create() {
        AuthController::requirePetugas();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bulan = htmlspecialchars($_POST['bulan'] ?? '');
            $tahun = htmlspecialchars($_POST['tahun'] ?? '');

            // Generate statistics
            $stats = $this->laporanModel->generateStats($bulan, $tahun);

            $this->laporanModel->petugas_id = $_SESSION['user_id'];
            $this->laporanModel->bulan = $bulan;
            $this->laporanModel->tahun = $tahun;
            $this->laporanModel->total_peminjaman = $stats['total_peminjaman'];
            $this->laporanModel->total_pengembalian = $stats['total_pengembalian'];
            $this->laporanModel->total_rusak = $stats['total_rusak'];
            $this->laporanModel->total_hilang = $stats['total_hilang'];
            $this->laporanModel->total_denda = $stats['total_denda'];
            $this->laporanModel->catatan = htmlspecialchars($_POST['catatan'] ?? '');

            if ($this->laporanModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE LAPORAN';
                $this->logModel->deskripsi = 'Membuat laporan bulan ' . $bulan . ' tahun ' . $tahun;
                $this->logModel->create();

                $_SESSION['success'] = 'Laporan berhasil dibuat!';
                header('Location: ?page=laporan');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal membuat laporan!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/laporan/create.php';
        return ob_get_clean();
    }

    // Show edit form
    public function edit() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $laporan = $this->laporanModel->getById($id);

        if (!$laporan) {
            $_SESSION['error'] = 'Laporan tidak ditemukan!';
            header('Location: ?page=laporan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->laporanModel->id = $id;
            $this->laporanModel->petugas_id = htmlspecialchars($_POST['petugas_id'] ?? '');
            $this->laporanModel->bulan = htmlspecialchars($_POST['bulan'] ?? '');
            $this->laporanModel->tahun = htmlspecialchars($_POST['tahun'] ?? '');
            $this->laporanModel->total_peminjaman = htmlspecialchars($_POST['total_peminjaman'] ?? '');
            $this->laporanModel->total_pengembalian = htmlspecialchars($_POST['total_pengembalian'] ?? '');
            $this->laporanModel->total_rusak = htmlspecialchars($_POST['total_rusak'] ?? '');
            $this->laporanModel->total_hilang = htmlspecialchars($_POST['total_hilang'] ?? '');
            $this->laporanModel->total_denda = htmlspecialchars($_POST['total_denda'] ?? '');
            $this->laporanModel->catatan = htmlspecialchars($_POST['catatan'] ?? '');

            if ($this->laporanModel->update()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'UPDATE LAPORAN';
                $this->logModel->deskripsi = 'Mengubah laporan ID: ' . $id;
                $this->logModel->create();

                $_SESSION['success'] = 'Laporan berhasil diubah!';
                header('Location: ?page=laporan');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengubah laporan!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/laporan/edit.php';
        return ob_get_clean();
    }

    // Delete laporan
    public function delete() {
        AuthController::requirePetugas();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $laporan = $this->laporanModel->getById($id);

        if (!$laporan) {
            $_SESSION['error'] = 'Laporan tidak ditemukan!';
            header('Location: ?page=laporan');
            exit;
        }

        if ($this->laporanModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE LAPORAN';
            $this->logModel->deskripsi = 'Menghapus laporan ID: ' . $id;
            $this->logModel->create();

            $_SESSION['success'] = 'Laporan berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus laporan!';
        }

        header('Location: ?page=laporan');
        exit;
    }
}
?>
