<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <h1>Persetujuan Peminjaman</h1>
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
                            <td class="action-buttons">
                                <a href="?page=approvePeminjaman&id=<?php echo $pem['id']; ?>" class="btn btn-sm btn-success">Setujui</a>
                                <a href="?page=rejectPeminjaman&id=<?php echo $pem['id']; ?>" class="btn btn-sm btn-danger">Tolak</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Tidak ada permintaan peminjaman yang pending</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
