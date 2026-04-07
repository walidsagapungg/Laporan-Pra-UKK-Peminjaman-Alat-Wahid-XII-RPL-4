<?php
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Database Configuration
require_once 'config/database.php';

// Load Models
require_once 'app/models/User.php';
require_once 'app/models/Kategori.php';
require_once 'app/models/Alat.php';
require_once 'app/models/Peminjaman.php';
require_once 'app/models/Pengembalian.php';
require_once 'app/models/LogAktivitas.php';
require_once 'app/models/Laporan.php';

// Load Controllers
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/DashboardController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/KategoriController.php';
require_once 'app/controllers/AlatController.php';
require_once 'app/controllers/PeminjamanController.php';
require_once 'app/controllers/PengembalianController.php';
require_once 'app/controllers/LaporanController.php';

// Initialize Database
$database = new Database();
$db = $database->connect();

// Get page from URL
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'login';
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'index';

// Route Handler
switch ($page) {
    // AUTH ROUTES
    case 'login':
        $auth = new AuthController($db);
        echo $auth->login();
        break;

    case 'logout':
        $auth = new AuthController($db);
        $auth->logout();
        break;

    // DASHBOARD
    case 'dashboard':
        AuthController::requireLogin();
        $dashboard = new DashboardController($db);
        echo $dashboard->index();
        break;

    // USER MANAGEMENT
    case 'user':
        $user = new UserController($db);
        echo $user->index();
        break;

    case 'createUser':
        $user = new UserController($db);
        echo $user->create();
        break;

    case 'editUser':
        $user = new UserController($db);
        echo $user->edit();
        break;

    case 'deleteUser':
        $user = new UserController($db);
        $user->delete();
        break;

    // KATEGORI MANAGEMENT
    case 'kategori':
        $kategori = new KategoriController($db);
        echo $kategori->index();
        break;

    case 'createKategori':
        $kategori = new KategoriController($db);
        echo $kategori->create();
        break;

    case 'editKategori':
        $kategori = new KategoriController($db);
        echo $kategori->edit();
        break;

    case 'deleteKategori':
        $kategori = new KategoriController($db);
        $kategori->delete();
        break;

    // ALAT MANAGEMENT
    case 'alat':
        $alat = new AlatController($db);
        echo $alat->index();
        break;

    case 'listAlat':
        $alat = new AlatController($db);
        echo $alat->list();
        break;

    case 'createAlat':
        $alat = new AlatController($db);
        echo $alat->create();
        break;

    case 'editAlat':
        $alat = new AlatController($db);
        echo $alat->edit();
        break;

    case 'deleteAlat':
        $alat = new AlatController($db);
        $alat->delete();
        break;

    // PEMINJAMAN MANAGEMENT
    case 'peminjaman':
        $peminjaman = new PeminjamanController($db);
        echo $peminjaman->index();
        break;

    case 'approval':
        $peminjaman = new PeminjamanController($db);
        echo $peminjaman->approval();
        break;

    case 'myPeminjaman':
        $peminjaman = new PeminjamanController($db);
        echo $peminjaman->myPeminjaman();
        break;

    case 'createPeminjaman':
        $peminjaman = new PeminjamanController($db);
        echo $peminjaman->create();
        break;

    case 'approvePeminjaman':
        $peminjaman = new PeminjamanController($db);
        $peminjaman->approve();
        break;

    case 'rejectPeminjaman':
        $peminjaman = new PeminjamanController($db);
        $peminjaman->reject();
        break;

    case 'deletePeminjaman':
        $peminjaman = new PeminjamanController($db);
        $peminjaman->delete();
        break;

    // PENGEMBALIAN MANAGEMENT
    case 'pengembalian':
        $pengembalian = new PengembalianController($db);
        echo $pengembalian->index();
        break;

    case 'createPengembalian':
        $pengembalian = new PengembalianController($db);
        echo $pengembalian->create();
        break;

    case 'myReturn':
        $pengembalian = new PengembalianController($db);
        echo $pengembalian->myReturn();
        break;

    case 'editPengembalian':
        $pengembalian = new PengembalianController($db);
        echo $pengembalian->edit();
        break;

    case 'deletePengembalian':
        $pengembalian = new PengembalianController($db);
        $pengembalian->delete();
        break;

    // LAPORAN MANAGEMENT
    case 'laporan':
        $laporan = new LaporanController($db);
        echo $laporan->index();
        break;

    case 'createLaporan':
        $laporan = new LaporanController($db);
        echo $laporan->create();
        break;

    case 'editLaporan':
        $laporan = new LaporanController($db);
        echo $laporan->edit();
        break;

    case 'deleteLaporan':
        $laporan = new LaporanController($db);
        $laporan->delete();
        break;

    // DEFAULT
    default:
        if (AuthController::isLoggedIn()) {
            header('Location: ?page=dashboard');
        } else {
            header('Location: ?page=login');
        }
        break;
}
?>
