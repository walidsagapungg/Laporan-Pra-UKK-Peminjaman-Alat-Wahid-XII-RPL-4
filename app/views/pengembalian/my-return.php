<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Kembalikan Alat</h1>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($peminjamans)): ?>
            <div class="return-list">
                <?php foreach ($peminjamans as $peminjaman): ?>
                    <div class="return-item">
                        <div class="return-info">
                            <h4><?php echo $peminjaman['nama_alat']; ?></h4>
                            <p>Dipinjam: <?php echo date('d M Y', strtotime($peminjaman['tanggal_pinjam'])); ?></p>
                            <p>Est. Kembali: <?php echo date('d M Y', strtotime($peminjaman['tanggal_kembali_estimasi'])); ?></p>
                        </div>
                        <button type="button" class="btn btn-primary open-return-modal" data-id="<?php echo $peminjaman['id']; ?>">Kembalikan</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Anda tidak memiliki alat yang dipinjam</p>
        <?php endif; ?>
    </div>
</div>

<div id="returnModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Pengembalian Alat</h2>
        <form method="POST" action="?page=createPengembalian" class="form">
            <input type="hidden" id="peminjaman_id" name="peminjaman_id">
            
            <div class="form-group">
                <label>Tanggal Kembali Aktual *</label>
                <input type="date" name="tanggal_kembali_aktual" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Kondisi Alat *</label>
                <select name="kondisi_alat" class="form-control" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="baik">Baik</option>
                    <option value="penyok">Penyok</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Kembalikan</button>
                <button type="button" class="btn btn-secondary close-modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.open-return-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('peminjaman_id').value = this.getAttribute('data-id');
        document.getElementById('returnModal').style.display = 'block';
    });
});

document.querySelectorAll('.close-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('returnModal').style.display = 'none';
    });
});

document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('returnModal').style.display = 'none';
});
</script>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
