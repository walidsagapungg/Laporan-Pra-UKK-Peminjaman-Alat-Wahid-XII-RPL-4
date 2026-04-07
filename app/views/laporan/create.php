<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Buat Laporan</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=createLaporan" class="form">
                <div class="form-group">
                    <label>Bulan *</label>
                    <select name="bulan" class="form-control" required>
                        <option value="">-- Pilih Bulan --</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tahun *</label>
                    <input type="number" name="tahun" class="form-control" value="<?php echo date('Y'); ?>" required>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="4"></textarea>
                </div>

                <p class="text-muted">* Sistem akan otomatis menghitung statistik berdasarkan data peminjaman dan pengembalian bulan tersebut</p>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Buat Laporan</button>
                    <a href="?page=laporan" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
