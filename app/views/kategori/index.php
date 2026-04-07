<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Kategori Alat</h1>
    </div>
    <a href="?page=createKategori" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($kategoris)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kategoris as $idx => $kategori): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $kategori['nama_kategori']; ?></td>
                            <td><?php echo substr($kategori['deskripsi'], 0, 50); ?></td>
                            <td class="action-buttons">
                                <a href="?page=editKategori&id=<?php echo $kategori['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=deleteKategori&id=<?php echo $kategori['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data kategori</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
