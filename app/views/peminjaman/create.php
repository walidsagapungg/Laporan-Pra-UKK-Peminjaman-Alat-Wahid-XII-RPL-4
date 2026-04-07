<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Ajukan Peminjaman</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=createPeminjaman" class="form">
                <div class="form-group">
                    <label>Alat *</label>
                    <select name="alat_id" class="form-control" required>
                        <option value="">-- Pilih Alat --</option>
                        <?php foreach ($alats as $alat): ?>
                            <option value="<?php echo $alat['id']; ?>"><?php echo $alat['nama_alat']; ?> (<?php echo $alat['nama_kategori']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Pinjam *</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Est. Tanggal Kembali *</label>
                    <input type="date" name="tanggal_kembali_estimasi" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                    <a href="?page=listAlat" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
