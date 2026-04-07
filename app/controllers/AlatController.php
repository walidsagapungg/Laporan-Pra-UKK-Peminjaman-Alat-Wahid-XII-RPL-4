<?php
class AlatController {
    private $db;
    private $alatModel;
    private $kategoriModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->alatModel = new Alat($db);
        $this->kategoriModel = new Kategori($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all alat
    public function index() {
        AuthController::requireAdmin();
        
        $stmt = $this->alatModel->getAll();
        $alats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/alat/index.php';
        return ob_get_clean();
    }

    // Show alat list for peminjam
    public function list() {
        AuthController::requirePeminjam();
        
        $stmt = $this->alatModel->getAvailable();
        $alats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/alat/list.php';
        return ob_get_clean();
    }

    // Show create form
    public function create() {
        AuthController::requireAdmin();
        
        $stmt = $this->kategoriModel->getAll();
        $kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->alatModel->nama_alat = htmlspecialchars($_POST['nama_alat'] ?? '');
            $this->alatModel->kategori_id = htmlspecialchars($_POST['kategori_id'] ?? '');
            $this->alatModel->deskripsi = htmlspecialchars($_POST['deskripsi'] ?? '');
            $this->alatModel->status = 'tersedia';

            if ($this->alatModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE ALAT';
                $this->logModel->deskripsi = 'Menambahkan alat baru: ' . $this->alatModel->nama_alat;
                $this->logModel->create();

                $_SESSION['success'] = 'Alat berhasil ditambahkan!';
                header('Location: ?page=alat');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menambahkan alat!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/alat/create.php';
        return ob_get_clean();
    }

    // Show edit form
    public function edit() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $alat = $this->alatModel->getById($id);

        if (!$alat) {
            $_SESSION['error'] = 'Alat tidak ditemukan!';
            header('Location: ?page=alat');
            exit;
        }

        $stmt = $this->kategoriModel->getAll();
        $kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->alatModel->id = $id;
            $this->alatModel->nama_alat = htmlspecialchars($_POST['nama_alat'] ?? '');
            $this->alatModel->kategori_id = htmlspecialchars($_POST['kategori_id'] ?? '');
            $this->alatModel->deskripsi = htmlspecialchars($_POST['deskripsi'] ?? '');
            $this->alatModel->status = htmlspecialchars($_POST['status'] ?? '');

            if ($this->alatModel->update()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'UPDATE ALAT';
                $this->logModel->deskripsi = 'Mengubah alat: ' . $this->alatModel->nama_alat;
                $this->logModel->create();

                $_SESSION['success'] = 'Alat berhasil diubah!';
                header('Location: ?page=alat');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengubah alat!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/alat/edit.php';
        return ob_get_clean();
    }

    // Delete alat
    public function delete() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $alat = $this->alatModel->getById($id);

        if (!$alat) {
            $_SESSION['error'] = 'Alat tidak ditemukan!';
            header('Location: ?page=alat');
            exit;
        }

        if ($this->alatModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE ALAT';
            $this->logModel->deskripsi = 'Menghapus alat: ' . $alat['nama_alat'];
            $this->logModel->create();

            $_SESSION['success'] = 'Alat berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus alat!';
        }

        header('Location: ?page=alat');
        exit;
    }
}
?>
