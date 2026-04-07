<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Alat Elektronik</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-box">
            <h1>PEMINJAMAN ALAT ELEKTRONIK</h1>
            <p class="subtitle">Sistem Manajemen Peminjaman Alat</p>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="?page=login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <p class="help-text">Default Login:<br>
                Admin: admin / admin123<br>
                Petugas: petugas / petugas123<br>
                Peminjam: peminjam / peminjam123
            </p>
        </div>
    </div>
</body>
</html>
