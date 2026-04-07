<?php
class AuthController {
    private $db;
    private $userModel;
    private $logModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
        $this->logModel = new LogAktivitas($db);
    }

    // Login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username'] ?? '');
            $password = htmlspecialchars($_POST['password'] ?? '');

            if (!empty($username) && !empty($password)) {
                $user = $this->userModel->verifyLogin($username, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];

                    // Log aktivitas
                    $this->logModel->user_id = $user['id'];
                    $this->logModel->aksi = 'LOGIN';
                    $this->logModel->deskripsi = 'User berhasil login';
                    $this->logModel->create();

                    header('Location: ?page=dashboard');
                    exit;
                } else {
                    $error = 'Username atau Password salah!';
                }
            } else {
                $error = 'Mohon isi semua field!';
            }
        }

        ob_start();
        include dirname(dirname(__DIR__)) . '/app/views/login.php';
        return ob_get_clean();
    }

    // Logout
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $this->logModel->user_id = $_SESSION['user_id'];
            $this->logModel->aksi = 'LOGOUT';
            $this->logModel->deskripsi = 'User berhasil logout';
            $this->logModel->create();
        }
        
        session_destroy();
        header('Location: ?page=login');
        exit;
    }

    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Check role
    public static function hasRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    // Require login
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ?page=login');
            exit;
        }
    }

    // Require admin role
    public static function requireAdmin() {
        self::requireLogin();
        if (!self::hasRole('Admin')) {
            header('Location: ?page=unauthorized');
            exit;
        }
    }

    // Require petugas role
    public static function requirePetugas() {
        self::requireLogin();
        if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Petugas') {
            header('Location: ?page=unauthorized');
            exit;
        }
    }

    // Require peminjam role
    public static function requirePeminjam() {
        self::requireLogin();
        if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Peminjam') {
            header('Location: ?page=unauthorized');
            exit;
        }
    }
}
?>
