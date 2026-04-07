<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Edit Laporan</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=editLaporan&id=<?php echo $laporan['id']; ?>" class="form">
                <div class="form-group">
                    <label>Petugas</label>
                    <input type="text" class="form-control" value="<?php echo $laporan['nama_lengkap']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Bulan *</label>
                    <input type="number" name="bulan" class="form-control" value="<?php echo $laporan['bulan']; ?>" min="1" max="12" required>
                </div>

                <div class="form-group">
                    <label>Tahun *</label>
                    <input type="number" name="tahun" class="form-control" value="<?php echo $laporan['tahun']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Peminjaman *</label>
                    <input type="number" name="total_peminjaman" class="form-control" value="<?php echo $laporan['total_peminjaman']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Pengembalian *</label>
                    <input type="number" name="total_pengembalian" class="form-control" value="<?php echo $laporan['total_pengembalian']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Rusak *</label>
                    <input type="number" name="total_rusak" class="form-control" value="<?php echo $laporan['total_rusak']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Hilang *</label>
                    <input type="number" name="total_hilang" class="form-control" value="<?php echo $laporan['total_hilang']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Denda *</label>
                    <input type="number" name="total_denda" class="form-control" value="<?php echo $laporan['total_denda']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="4"><?php echo $laporan['catatan']; ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="?page=laporan" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
