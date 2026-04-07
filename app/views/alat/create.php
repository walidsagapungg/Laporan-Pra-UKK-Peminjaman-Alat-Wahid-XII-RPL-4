<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Tambah Alat</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=createAlat" class="form">
                <div class="form-group">
                    <label>Nama Alat *</label>
                    <input type="text" name="nama_alat" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori *</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategoris as $kategori): ?>
                            <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
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
