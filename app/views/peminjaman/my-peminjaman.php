<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Peminjaman Saya</h1>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($peminjamans)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alat</th>
                        <th>Kategori</th>
                        <th>Tanggal Pinjam</th>
                        <th>Est. Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjamans as $idx => $pem): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $pem['nama_alat']; ?></td>
                            <td><?php echo $pem['nama_kategori']; ?></td>
                            <td><?php echo date('d M Y', strtotime($pem['tanggal_pinjam'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($pem['tanggal_kembali_estimasi'])); ?></td>
                            <td><span class="badge badge-<?php echo $pem['status'] === 'disetujui' || $pem['status'] === 'dipinjam' ? 'success' : ($pem['status'] === 'pending' ? 'warning' : ($pem['status'] === 'ditolak' ? 'danger' : 'info')); ?>"><?php echo ucfirst($pem['status']); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Anda belum melakukan peminjaman</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
