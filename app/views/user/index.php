<?php include dirname(__DIR__) . '/header.php'; ?>

<div class="page-header">
    <div class="header-content">
        <h1>Data User</h1>
    </div>
    <a href="?page=createUser" class="btn btn-primary">+ Tambah User</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($users)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $idx => $user): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['nama_lengkap']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><span class="badge badge-<?php echo $user['role'] === 'Admin' ? 'danger' : ($user['role'] === 'Petugas' ? 'warning' : 'success'); ?>"><?php echo $user['role']; ?></span></td>
                            <td><span class="badge badge-<?php echo $user['status'] === 'aktif' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($user['status']); ?></span></td>
                            <td class="action-buttons">
                                <a href="?page=editUser&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="?page=deleteUser&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data user</p>
        <?php endif; ?>
    </div>
</div>

<?php include dirname(dirname(__FILE__)) . '/footer.php'; ?>
