<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Edit User</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=editUser&id=<?php echo $user['id']; ?>" class="form">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $user['nama_lengkap']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="Admin" <?php echo $user['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="Petugas" <?php echo $user['role'] === 'Petugas' ? 'selected' : ''; ?>>Petugas</option>
                        <option value="Peminjam" <?php echo $user['role'] === 'Peminjam' ? 'selected' : ''; ?>>Peminjam</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" <?php echo $user['status'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?php echo $user['status'] === 'nonaktif' ? 'selected' : ''; ?>>Non Aktif</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=user" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
