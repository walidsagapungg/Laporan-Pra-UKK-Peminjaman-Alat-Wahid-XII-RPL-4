<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Sistem Peminjaman Alat Elektronik</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <h2>PEMINJAMAN ALAT</h2>
            </div>
            <div class="navbar-menu">
                <span class="navbar-text">Hai, <?php echo $_SESSION['nama_lengkap']; ?> (<?php echo $_SESSION['role']; ?>)</span>
                <a href="?page=logout" class="btn btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <aside class="sidebar">
            <ul class="menu">
                <li><a href="?page=dashboard" class="menu-item">Dashboard</a></li>
                
                <?php if ($_SESSION['role'] === 'Admin'): ?>
                    <li><strong>Management</strong>
                        <ul class="submenu">
                            <li><a href="?page=user" class="menu-item">Data User</a></li>
                            <li><a href="?page=kategori" class="menu-item">Kategori Alat</a></li>
                            <li><a href="?page=alat" class="menu-item">Daftar Alat</a></li>
                            <li><a href="?page=peminjaman" class="menu-item">Data Peminjaman</a></li>
                            <li><a href="?page=pengembalian" class="menu-item">Data Pengembalian</a></li>
                        </ul>
                    </li>
                    <li><strong>Sistem</strong>
                        <ul class="submenu">
                            <li><a href="?page=logAktivitas" class="menu-item">Log Aktivitas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'Petugas'): ?>
                    <li><strong>Fitur Petugas</strong>
                        <ul class="submenu">
                            <li><a href="?page=approval" class="menu-item">Persetujuan Peminjaman</a></li>
                            <li><a href="?page=pengembalian" class="menu-item">Pengembalian Alat</a></li>
                            <li><a href="?page=laporan" class="menu-item">Laporan</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'Peminjam'): ?>
                    <li><strong>Fitur Peminjam</strong>
                        <ul class="submenu">
                            <li><a href="?page=listAlat" class="menu-item">Daftar Alat</a></li>
                            <li><a href="?page=createPeminjaman" class="menu-item">Ajukan Peminjaman</a></li>
                            <li><a href="?page=myPeminjaman" class="menu-item">Peminjaman Saya</a></li>
                            <li><a href="?page=myReturn" class="menu-item">Kembalikan Alat</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>

        <main class="content">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
