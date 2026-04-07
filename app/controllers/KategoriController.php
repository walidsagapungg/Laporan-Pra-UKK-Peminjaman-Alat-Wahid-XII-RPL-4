<?php
class KategoriController {
    private $db;
    private $kategoriModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->kategoriModel = new Kategori($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all kategori
    public function index() {
        AuthController::requireAdmin();
        
        $stmt = $this->kategoriModel->getAll();
        $kategoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/kategori/index.php';
        return ob_get_clean();
    }

    // Show create form
    public function create() {
        AuthController::requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->kategoriModel->nama_kategori = htmlspecialchars($_POST['nama_kategori'] ?? '');
            $this->kategoriModel->deskripsi = htmlspecialchars($_POST['deskripsi'] ?? '');

            if ($this->kategoriModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE KATEGORI';
                $this->logModel->deskripsi = 'Membuat kategori baru: ' . $this->kategoriModel->nama_kategori;
                $this->logModel->create();

                $_SESSION['success'] = 'Kategori berhasil ditambahkan!';
                header('Location: ?page=kategori');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menambahkan kategori!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/kategori/create.php';
        return ob_get_clean();
    }

    // Show edit form
    public function edit() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $kategori = $this->kategoriModel->getById($id);

        if (!$kategori) {
            $_SESSION['error'] = 'Kategori tidak ditemukan!';
            header('Location: ?page=kategori');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->kategoriModel->id = $id;
            $this->kategoriModel->nama_kategori = htmlspecialchars($_POST['nama_kategori'] ?? '');
            $this->kategoriModel->deskripsi = htmlspecialchars($_POST['deskripsi'] ?? '');

            if ($this->kategoriModel->update()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'UPDATE KATEGORI';
                $this->logModel->deskripsi = 'Mengubah kategori: ' . $this->kategoriModel->nama_kategori;
                $this->logModel->create();

                $_SESSION['success'] = 'Kategori berhasil diubah!';
                header('Location: ?page=kategori');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengubah kategori!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/kategori/edit.php';
        return ob_get_clean();
    }

    // Delete kategori
    public function delete() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $kategori = $this->kategoriModel->getById($id);

        if (!$kategori) {
            $_SESSION['error'] = 'Kategori tidak ditemukan!';
            header('Location: ?page=kategori');
            exit;
        }

        if ($this->kategoriModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE KATEGORI';
            $this->logModel->deskripsi = 'Menghapus kategori: ' . $kategori['nama_kategori'];
            $this->logModel->create();

            $_SESSION['success'] = 'Kategori berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus kategori!';
        }

        header('Location: ?page=kategori');
        exit;
    }
}
?>
