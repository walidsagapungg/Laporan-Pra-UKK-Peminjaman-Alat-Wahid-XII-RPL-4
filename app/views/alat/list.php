<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Daftar Alat Tersedia</h1>
</div>

<div class="alat-list">
    <?php if (!empty($alats)): ?>
        <div class="alat-grid">
            <?php foreach ($alats as $alat): ?>
                <div class="alat-card">
                    <div class="alat-icon">📦</div>
                    <h3><?php echo $alat['nama_alat']; ?></h3>
                    <p class="alat-category"><?php echo $alat['nama_kategori']; ?></p>
                    <p class="alat-desc"><?php echo substr($alat['deskripsi'] ?? '', 0, 80); ?></p>
                    <p class="alat-status"><span class="badge badge-success">Tersedia</span></p>
                    <a href="?page=createPeminjaman&alat_id=<?php echo $alat['id']; ?>" class="btn btn-primary btn-block">Pinjam Alat</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Tidak ada alat yang tersedia saat ini
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__) . '/footer.php'; ?>
