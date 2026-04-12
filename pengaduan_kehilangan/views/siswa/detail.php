<?php
$pageTitle = 'Detail Pengaduan';
$activePage = 'histori';
$role = 'siswa';

ob_start();
?>

<div class="mb-3">
    <a href="index.php?page=siswa_histori" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="detail-grid">
    <!-- Detail Pengaduan -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-alt"></i> Detail Pengaduan
            </h3>
            <span class="badge badge-<?= strtolower($aspirasi['status']) ?>">
                <?= $aspirasi['status'] ?>
            </span>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <div class="detail-label">ID Pelaporan</div>
                    <div class="detail-value">#<?= $aspirasi['id_pelaporan'] ?></div>
                </div>
                <div>
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value"><?= date('d F Y', strtotime($aspirasi['tanggal'])) ?></div>
                </div>
                <div>
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value"><?= htmlspecialchars($aspirasi['ket_kategori']) ?></div>
                </div>
                <div>
                    <div class="detail-label">Kelas</div>
                    <div class="detail-value"><?= htmlspecialchars($aspirasi['kelas']) ?></div>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="detail-label">Deskripsi Kehilangan</div>
                <div class="detail-value" style="background: var(--bg-light); padding: 1rem; border-radius: var(--radius); margin-top: 0.5rem;">
                    <?= nl2br(htmlspecialchars($aspirasi['isi_text'])) ?>
                </div>
            </div>
            
            <?php if (!empty($aspirasi['isi_gambar'])): ?>
            <div class="detail-image mt-4">
                <div class="detail-label">Gambar Bukti</div>
                <img src="assets/uploads/<?= htmlspecialchars($aspirasi['isi_gambar']) ?>" alt="Bukti Kehilangan">
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Status & Feedback -->
    <div>
        <!-- Progress Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks"></i> Progres Penanganan
                </h3>
            </div>
            <div class="card-body">
                <div class="progress-steps">
                    <div class="progress-step <?= $aspirasi['status'] === 'Menunggu' ? 'active' : ($aspirasi['status'] === 'Proses' || $aspirasi['status'] === 'Selesai' ? 'completed' : '') ?>">
                        <div class="progress-step-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="progress-step-label">Menunggu</div>
                    </div>
                    <div class="progress-step <?= $aspirasi['status'] === 'Proses' ? 'active' : ($aspirasi['status'] === 'Selesai' ? 'completed' : '') ?>">
                        <div class="progress-step-icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="progress-step-label">Proses</div>
                    </div>
                    <div class="progress-step <?= $aspirasi['status'] === 'Selesai' ? 'active completed' : '' ?>">
                        <div class="progress-step-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="progress-step-label">Selesai</div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <?php if ($aspirasi['status'] === 'Menunggu'): ?>
                    <div class="alert alert-warning" style="margin: 0;">
                        <i class="fas fa-clock"></i>
                        Pengaduan Anda sedang menunggu untuk ditinjau oleh admin.
                    </div>
                    <?php elseif ($aspirasi['status'] === 'Proses'): ?>
                    <div class="alert alert-info" style="margin: 0;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Pengaduan Anda sedang dalam proses penanganan.
                    </div>
                    <?php else: ?>
                    <div class="alert alert-success" style="margin: 0;">
                        <i class="fas fa-check-circle"></i>
                        Pengaduan Anda telah selesai ditangani.
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Feedback -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-comment-alt"></i> Umpan Balik Admin
                </h3>
            </div>
            <div class="card-body">
                <?php if (!empty($aspirasi['feedback'])): ?>
                <div style="background: var(--success-light); padding: 1rem; border-radius: var(--radius); border-left: 4px solid var(--success);">
                    <?= nl2br(htmlspecialchars($aspirasi['feedback'])) ?>
                </div>
                <?php else: ?>
                <div class="empty-state" style="padding: 1.5rem;">
                    <div class="empty-state-icon"><i class="fas fa-comment-slash"></i></div>
                    <div class="empty-state-title">Belum Ada Feedback</div>
                    <div class="empty-state-desc">Admin belum memberikan umpan balik.</div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
