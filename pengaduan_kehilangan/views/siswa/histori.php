<?php
$pageTitle = 'Histori Pengaduan';
$activePage = 'histori';
$role = 'siswa';

ob_start();
?>

<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history"></i> Histori Pengaduan Saya
            <span class="text-muted text-sm">(<?= count($aspirasiList) ?> data)</span>
        </h3>
        <a href="index.php?page=siswa_create" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Buat Baru
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($aspirasiList)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <div class="empty-state-title">Belum Ada Pengaduan</div>
            <div class="empty-state-desc">Anda belum pernah membuat pengaduan kehilangan.</div>
            <a href="index.php?page=siswa_create" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Buat Pengaduan
            </a>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Isi Pengaduan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($aspirasiList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($item['ket_kategori']) ?></td>
                        <td>
                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= htmlspecialchars($item['isi_text']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-<?= strtolower($item['status']) ?>">
                                <?= $item['status'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($item['feedback'])): ?>
                            <span class="text-success"><i class="fas fa-check-circle"></i> Ada</span>
                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=siswa_detail&id=<?= $item['id_pelaporan'] ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
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
