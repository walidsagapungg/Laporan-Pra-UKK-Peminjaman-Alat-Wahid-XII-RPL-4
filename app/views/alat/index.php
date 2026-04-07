<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Daftar Alat</h1>
    </div>
    <a href="?page=createAlat" class="btn btn-primary">+ Tambah Alat</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($alats)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alats as $idx => $alat): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $alat['nama_alat']; ?></td>
                            <td><?php echo $alat['nama_kategori']; ?></td>
                            <td><span class="badge badge-<?php echo $alat['status'] === 'tersedia' ? 'success' : ($alat['status'] === 'dipinjam' ? 'warning' : 'danger'); ?>"><?php echo ucfirst($alat['status']); ?></span></td>
                            <td class="action-buttons">
                                <a href="?page=editAlat&id=<?php echo $alat['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=deleteAlat&id=<?php echo $alat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data alat</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
