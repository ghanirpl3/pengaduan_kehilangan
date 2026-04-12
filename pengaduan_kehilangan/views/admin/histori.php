<?php
$pageTitle = 'Histori Aspirasi';
$activePage = 'histori';
$role = 'admin';

ob_start();
?>

<!-- Filter Form -->
<form class="filter-form" method="GET">
    <input type="hidden" name="page" value="admin_histori">
    
    <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-control form-select">
            <option value="">-- Semua Status --</option>
            <option value="Menunggu" <?= ($_GET['status'] ?? '') === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
            <option value="Proses" <?= ($_GET['status'] ?? '') === 'Proses' ? 'selected' : '' ?>>Proses</option>
            <option value="Selesai" <?= ($_GET['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
    
    <div class="form-group">
        <label class="form-label">Dari Tanggal</label>
        <input type="date" name="start_date" class="form-control" value="<?= $_GET['start_date'] ?? '' ?>">
    </div>
    
    <div class="form-group">
        <label class="form-label">Sampai Tanggal</label>
        <input type="date" name="end_date" class="form-control" value="<?= $_GET['end_date'] ?? '' ?>">
    </div>
    
    <div class="form-group">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Filter
        </button>
        <a href="index.php?page=admin_histori" class="btn btn-outline">
            <i class="fas fa-times"></i> Reset
        </a>
    </div>
</form>

<!-- Histori Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> Histori Penanganan
            <span class="text-muted text-sm">(<?= count($historiList) ?> data)</span>
        </h3>
    </div>
    <div class="card-body">
        <?php if (empty($historiList)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <div class="empty-state-title">Tidak Ada Data</div>
            <div class="empty-state-desc">Tidak ada histori yang ditemukan.</div>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Lapor</th>
                        <th>Tanggal Update</th>
                        <th>Nama Siswa</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Ditangani Oleh</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($historiList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal_lapor'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td>
                            <strong><?= htmlspecialchars($item['nama_siswa']) ?></strong>
                            <div class="text-sm text-muted"><?= htmlspecialchars($item['kelas']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($item['ket_kategori']) ?></td>
                        <td>
                            <span class="badge badge-<?= strtolower($item['status']) ?>">
                                <?= $item['status'] ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($item['admin_name'] ?? '-') ?></td>
                        <td>
                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= htmlspecialchars($item['feedback'] ?? '-') ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
