<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Data Peminjaman</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($peminjamans)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Alat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Est. Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjamans as $idx => $pem): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $pem['nama_lengkap']; ?></td>
                            <td><?php echo $pem['nama_alat']; ?></td>
                            <td><?php echo date('d M Y', strtotime($pem['tanggal_pinjam'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($pem['tanggal_kembali_estimasi'])); ?></td>
                            <td><span class="badge badge-<?php echo $pem['status'] === 'disetujui' ? 'success' : ($pem['status'] === 'pending' ? 'warning' : ($pem['status'] === 'ditolak' ? 'danger' : 'info')); ?>"><?php echo ucfirst($pem['status']); ?></span></td>
                            <td class="action-buttons">
                                <a href="?page=deletePeminjaman&id=<?php echo $pem['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data peminjaman</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
