<?php include '../header.php'; ?>

<div class="page-header">
    <h1>Tambah User</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=createUser" class="form">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Petugas">Petugas</option>
                        <option value="Peminjam">Peminjam</option>
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
