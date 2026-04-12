<?php
$pageTitle = 'Detail Aspirasi';
$activePage = 'aspirasi';
$role = 'admin';

ob_start();
?>

<div class="mb-3">
    <a href="index.php?page=admin_aspirasi" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<div class="detail-grid">
    <!-- Detail Aspirasi -->
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
                    <div class="detail-label">Nama Siswa</div>
                    <div class="detail-value"><strong><?= htmlspecialchars($aspirasi['nama_siswa']) ?></strong></div>
                </div>
                <div>
                    <div class="detail-label">Kelas</div>
                    <div class="detail-value"><?= htmlspecialchars($aspirasi['kelas']) ?></div>
                </div>
                <div>
                    <div class="detail-label">NIS</div>
                    <div class="detail-value"><?= htmlspecialchars($aspirasi['nis']) ?></div>
                </div>
                <div>
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value"><?= htmlspecialchars($aspirasi['ket_kategori']) ?></div>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="detail-label">Isi Pengaduan</div>
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
            
            <?php if (!empty($aspirasi['feedback'])): ?>
            <div class="mt-4">
                <div class="detail-label">Feedback Admin</div>
                <div class="detail-value" style="background: var(--success-light); padding: 1rem; border-radius: var(--radius); margin-top: 0.5rem; border-left: 4px solid var(--success);">
                    <?= nl2br(htmlspecialchars($aspirasi['feedback'])) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Form Update Status -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Update Status
            </h3>
        </div>
        <div class="card-body">
            <!-- Progress -->
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
            
            <?php if ($aspirasi['status'] === 'Selesai'): ?>
            <!-- Status sudah selesai, tidak bisa diubah lagi -->
            <div class="mt-4" style="text-align: center; padding: 2rem 1rem;">
                <div style="font-size: 3rem; color: var(--success); margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4 style="color: var(--success); margin-bottom: 0.5rem;">Pengaduan Telah Selesai</h4>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Pengaduan ini sudah selesai diproses dan tidak dapat diubah lagi.
                </p>
                <a href="index.php?page=admin_histori" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-history"></i> Lihat di Histori
                </a>
            </div>
            <?php else: ?>
            <form action="index.php?page=admin_update_status" method="POST" class="mt-4">
                <input type="hidden" name="id_pelaporan" value="<?= $aspirasi['id_pelaporan'] ?>">
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control form-select" required>
                        <option value="Menunggu" <?= $aspirasi['status'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Proses" <?= $aspirasi['status'] === 'Proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= $aspirasi['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Feedback / Umpan Balik</label>
                    <textarea name="feedback" class="form-control" rows="5" placeholder="Berikan feedback untuk siswa..."><?= htmlspecialchars($aspirasi['feedback'] ?? '') ?></textarea>
                </div>
                
                <button type="submit" class="btn btn-success" style="width: 100%;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
