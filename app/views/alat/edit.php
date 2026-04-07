<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Edit Alat</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=editAlat&id=<?php echo $alat['id']; ?>" class="form">
                <div class="form-group">
                    <label>Nama Alat *</label>
                    <input type="text" name="nama_alat" class="form-control" value="<?php echo $alat['nama_alat']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori_id" class="form-control" required>
                        <?php foreach ($kategoris as $kategori): ?>
                            <option value="<?php echo $kategori['id']; ?>" <?php echo $kategori['id'] == $alat['kategori_id'] ? 'selected' : ''; ?>><?php echo $kategori['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?php echo $alat['deskripsi']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="tersedia" <?php echo $alat['status'] === 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                        <option value="dipinjam" <?php echo $alat['status'] === 'dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
                        <option value="rusak" <?php echo $alat['status'] === 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=alat" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
