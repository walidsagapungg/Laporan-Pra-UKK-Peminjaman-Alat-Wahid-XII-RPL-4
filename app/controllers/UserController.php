<?php
class UserController {
    private $db;
    private $userModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Get all users
    public function index() {
        AuthController::requireAdmin();
        
        $stmt = $this->userModel->getAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/user/index.php';
        return ob_get_clean();
    }

    // Show create form
    public function create() {
        AuthController::requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->username = htmlspecialchars($_POST['username'] ?? '');
            $this->userModel->password = htmlspecialchars($_POST['password'] ?? '');
            $this->userModel->email = htmlspecialchars($_POST['email'] ?? '');
            $this->userModel->nama_lengkap = htmlspecialchars($_POST['nama_lengkap'] ?? '');
            $this->userModel->role = htmlspecialchars($_POST['role'] ?? '');
            $this->userModel->status = 'aktif';

            if ($this->userModel->create()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'CREATE USER';
                $this->logModel->deskripsi = 'Membuat user baru: ' . $this->userModel->username;
                $this->logModel->create();

                $_SESSION['success'] = 'User berhasil ditambahkan!';
                header('Location: ?page=user');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menambahkan user!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/user/create.php';
        return ob_get_clean();
    }

    // Show edit form
    public function edit() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $user = $this->userModel->getById($id);

        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: ?page=user');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->id = $id;
            $this->userModel->username = htmlspecialchars($_POST['username'] ?? '');
            $this->userModel->email = htmlspecialchars($_POST['email'] ?? '');
            $this->userModel->nama_lengkap = htmlspecialchars($_POST['nama_lengkap'] ?? '');
            $this->userModel->role = htmlspecialchars($_POST['role'] ?? '');
            $this->userModel->status = htmlspecialchars($_POST['status'] ?? '');
            $this->userModel->password = htmlspecialchars($_POST['password'] ?? '');

            if ($this->userModel->update()) {
                $this->logModel->user_id = $_SESSION['user_id'];
                $this->logModel->aksi = 'UPDATE USER';
                $this->logModel->deskripsi = 'Mengubah user: ' . $this->userModel->username;
                $this->logModel->create();

                $_SESSION['success'] = 'User berhasil diubah!';
                header('Location: ?page=user');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengubah user!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/user/edit.php';
        return ob_get_clean();
    }

    // Delete user
    public function delete() {
        AuthController::requireAdmin();
        
        $id = htmlspecialchars($_GET['id'] ?? '');
        $user = $this->userModel->getById($id);

        if (!$user) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: ?page=user');
            exit;
        }

        if ($this->userModel->delete($id)) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'DELETE USER';
            $this->logModel->deskripsi = 'Menghapus user: ' . $user['username'];
            $this->logModel->create();

            $_SESSION['success'] = 'User berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus user!';
        }

        header('Location: ?page=user');
        exit;
    }
}
?>
