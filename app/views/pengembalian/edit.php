<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Edit Pengembalian</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=editPengembalian&id=<?php echo $pengembalian['id']; ?>" class="form">
                <div class="form-group">
                    <label>User</label>
                    <input type="text" class="form-control" value="<?php echo $pengembalian['nama_lengkap']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Alat</label>
                    <input type="text" class="form-control" value="<?php echo $pengembalian['nama_alat']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Tanggal Kembali Aktual *</label>
                    <input type="date" name="tanggal_kembali_aktual" class="form-control" value="<?php echo $pengembalian['tanggal_kembali_aktual']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Kondisi Alat *</label>
                    <select name="kondisi_alat" class="form-control" required>
                        <option value="baik" <?php echo $pengembalian['kondisi_alat'] === 'baik' ? 'selected' : ''; ?>>Baik</option>
                        <option value="penyok" <?php echo $pengembalian['kondisi_alat'] === 'penyok' ? 'selected' : ''; ?>>Penyok</option>
                        <option value="rusak" <?php echo $pengembalian['kondisi_alat'] === 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                        <option value="hilang" <?php echo $pengembalian['kondisi_alat'] === 'hilang' ? 'selected' : ''; ?>>Hilang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="4"><?php echo $pengembalian['catatan']; ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=pengembalian" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
