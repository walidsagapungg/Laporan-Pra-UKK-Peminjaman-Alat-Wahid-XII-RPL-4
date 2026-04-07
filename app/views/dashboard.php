<?php include __DIR__ . '/header.php'; ?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['total_users']; ?></div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['total_alat']; ?></div>
            <div class="stat-label">Total Alat</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['alat_tersedia']; ?></div>
            <div class="stat-label">Alat Tersedia</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['total_peminjaman']; ?></div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['pending_peminjaman']; ?></div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🚀</div>
        <div class="stat-content">
            <div class="stat-value"><?php echo $stats['aktif_peminjaman']; ?></div>
            <div class="stat-label">Sedang Dipinjam</div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h3>Aktivitas Terbaru</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($stats['recent_activities'])): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['recent_activities'] as $activity): ?>
                        <tr>
                            <td><?php echo $activity['username']; ?></td>
                            <td><span class="badge badge-info"><?php echo $activity['aksi']; ?></span></td>
                            <td><?php echo $activity['deskripsi']; ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($activity['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada aktivitas</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
