<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Edit Kategori</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=editKategori&id=<?php echo $kategori['id']; ?>" class="form">
                <div class="form-group">
                    <label>Nama Kategori *</label>
                    <input type="text" name="nama_kategori" class="form-control" value="<?php echo $kategori['nama_kategori']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?php echo $kategori['deskripsi']; ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=kategori" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
