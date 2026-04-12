<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
$role = 'admin';

ob_start();
?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalAspirasi ?></div>
            <div class="stat-label">Total Aspirasi</div>
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

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalSiswa ?></div>
            <div class="stat-label">Total Siswa</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?= $totalKategori ?></div>
            <div class="stat-label">Kategori</div>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
