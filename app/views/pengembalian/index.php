<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Data Pengembalian</h1>
    </div>
    <a href="?page=createPengembalian" class="btn btn-primary">+ Catat Pengembalian</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($pengembalians)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Alat</th>
                        <th>Tgl Kembali</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengembalians as $idx => $pengembalian): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $pengembalian['nama_lengkap']; ?></td>
                            <td><?php echo $pengembalian['nama_alat']; ?></td>
                            <td><?php echo date('d M Y', strtotime($pengembalian['tanggal_kembali_aktual'])); ?></td>
                            <td><span class="badge badge-<?php echo $pengembalian['kondisi_alat'] === 'baik' ? 'success' : ($pengembalian['kondisi_alat'] === 'rusak' ? 'warning' : ($pengembalian['kondisi_alat'] === 'hilang' ? 'danger' : 'secondary')); ?>"><?php echo ucfirst($pengembalian['kondisi_alat']); ?></span></td>
                            <td>Rp <?php echo number_format($pengembalian['denda'], 0, ',', '.'); ?></td>
                            <td class="action-buttons">
                                <a href="?page=editPengembalian&id=<?php echo $pengembalian['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=deletePengembalian&id=<?php echo $pengembalian['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data pengembalian</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
