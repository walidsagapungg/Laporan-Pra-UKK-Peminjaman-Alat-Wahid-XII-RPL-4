<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Laporan</h1>
    </div>
    <a href="?page=createLaporan" class="btn btn-primary">+ Buat Laporan</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($laporans)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Petugas</th>
                        <th>Bulan/Tahun</th>
                        <th>Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>Rusak</th>
                        <th>Hilang</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporans as $idx => $laporan): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $laporan['nama_lengkap']; ?></td>
                            <td><?php echo bulan($laporan['bulan']) . ' ' . $laporan['tahun']; ?></td>
                            <td><?php echo $laporan['total_peminjaman']; ?></td>
                            <td><?php echo $laporan['total_pengembalian']; ?></td>
                            <td><?php echo $laporan['total_rusak']; ?></td>
                            <td><?php echo $laporan['total_hilang']; ?></td>
                            <td>Rp <?php echo number_format($laporan['total_denda'], 0, ',', '.'); ?></td>
                            <td class="action-buttons">
                                <a href="?page=editLaporan&id=<?php echo $laporan['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=deleteLaporan&id=<?php echo $laporan['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada laporan</p>
        <?php endif; ?>
    </div>
</div>

<?php 
function bulan($bulan) {
    $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $bulanNama[$bulan] ?? '';
}
include dirname(dirname(__FILE__)) . '/footer.php'; 
?>
