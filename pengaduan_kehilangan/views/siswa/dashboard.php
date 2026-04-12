<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
$role = 'siswa';

ob_start();
?>

<!-- Welcome Message -->
<div class="card mb-4">
    <div class="card-body" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; border-radius: var(--radius-lg);">
        <h2 style="margin-bottom: 0.5rem;">Selamat Datang, <?= htmlspecialchars($nama) ?>! 👋</h2>
        <p style="margin: 0; opacity: 0.9;">Kelas <?= htmlspecialchars($kelas) ?> • NIS: <?= htmlspecialchars($nis) ?></p>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalAspirasi ?></div>
            <div class="stat-label">Total Pengaduan</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalMenunggu ?></div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon info">
            <i class="fas fa-spinner"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalProses ?></div>
            <div class="stat-label">Dalam Proses</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalSelesai ?></div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
