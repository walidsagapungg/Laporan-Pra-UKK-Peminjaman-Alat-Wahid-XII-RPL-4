<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Catat Pengembalian</h1>
</div>

<div class="form-container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="?page=createPengembalian" class="form">
                <div class="form-group">
                    <label>Peminjaman *</label>
                    <select name="peminjaman_id" class="form-control" required>
                        <option value="">-- Pilih Peminjaman --</option>
                        <?php foreach ($peminjamans as $peminjaman): ?>
                            <option value="<?php echo $peminjaman['id']; ?>"><?php echo $peminjaman['nama_lengkap']; ?> - <?php echo $peminjaman['nama_alat']; ?> (<?php echo date('d M Y', strtotime($peminjaman['tanggal_pinjam'])); ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Kembali Aktual *</label>
                    <input type="date" name="tanggal_kembali_aktual" class="form-control" required>
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
                    <textarea name="catatan" class="form-control" rows="4"></textarea>
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
