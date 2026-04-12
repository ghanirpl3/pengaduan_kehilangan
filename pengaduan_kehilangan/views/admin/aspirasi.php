<?php
$pageTitle = 'List Aspirasi';
$activePage = 'aspirasi';
$role = 'admin';

ob_start();
?>

<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<?php if (!empty($error)): ?>
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<!-- Filter Form -->
<form class="filter-form" method="GET">
    <input type="hidden" name="page" value="admin_aspirasi">
    
    <div class="form-group">
        <label class="form-label">Filter</label>
        <select name="filter" class="form-control form-select" onchange="toggleFilterInputs(this.value)">
            <option value="">-- Pilih Filter --</option>
            <option value="kategori" <?= ($_GET['filter'] ?? '') === 'kategori' ? 'selected' : '' ?>>Kategori</option>
            <option value="status" <?= ($_GET['filter'] ?? '') === 'status' ? 'selected' : '' ?>>Status</option>
            <option value="tanggal" <?= ($_GET['filter'] ?? '') === 'tanggal' ? 'selected' : '' ?>>Tanggal</option>
        </select>
    </div>
    
    <div class="form-group" id="kategori-filter" style="display: <?= ($_GET['filter'] ?? '') === 'kategori' ? 'block' : 'none' ?>;">
        <label class="form-label">Kategori</label>
        <select name="value" class="form-control form-select">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategoriList as $kat): ?>
            <option value="<?= $kat['id_kategori'] ?>" <?= ($_GET['value'] ?? '') == $kat['id_kategori'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($kat['ket_kategori']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group" id="status-filter" style="display: <?= ($_GET['filter'] ?? '') === 'status' ? 'block' : 'none' ?>;">
        <label class="form-label">Status</label>
        <select name="value" class="form-control form-select">
            <option value="">-- Pilih Status --</option>
            <option value="Menunggu" <?= ($_GET['value'] ?? '') === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
            <option value="Proses" <?= ($_GET['value'] ?? '') === 'Proses' ? 'selected' : '' ?>>Proses</option>
            <option value="Selesai" <?= ($_GET['value'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
    </div>
    
    <div class="form-group" id="tanggal-filter-start" style="display: <?= ($_GET['filter'] ?? '') === 'tanggal' ? 'block' : 'none' ?>;">
        <label class="form-label">Dari Tanggal</label>
        <input type="date" name="start_date" class="form-control" value="<?= $_GET['start_date'] ?? '' ?>">
    </div>
    
    <div class="form-group" id="tanggal-filter-end" style="display: <?= ($_GET['filter'] ?? '') === 'tanggal' ? 'block' : 'none' ?>;">
        <label class="form-label">Sampai Tanggal</label>
        <input type="date" name="end_date" class="form-control" value="<?= $_GET['end_date'] ?? '' ?>">
    </div>
    
    <div class="form-group">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Filter
        </button>
        <a href="index.php?page=admin_aspirasi" class="btn btn-outline">
            <i class="fas fa-times"></i> Reset
        </a>
    </div>
</form>

<!-- Aspirasi Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Daftar Aspirasi
            <span class="text-muted text-sm">(<?= count($aspirasiList) ?> data)</span>
        </h3>
    </div>
    <div class="card-body">
        <?php if (empty($aspirasiList)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <div class="empty-state-title">Tidak Ada Data</div>
            <div class="empty-state-desc">Tidak ada aspirasi yang ditemukan.</div>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Isi Pengaduan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($aspirasiList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                        <td><strong><?= htmlspecialchars($item['nama_siswa']) ?></strong></td>
                        <td><?= htmlspecialchars($item['kelas']) ?></td>
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
                            <a href="index.php?page=admin_detail&id=<?= $item['id_pelaporan'] ?>" class="btn btn-sm btn-primary" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="index.php?page=admin_archive" style="display: inline;" onsubmit="return confirm('Arsipkan aspirasi ini ke Histori?')">
                                <input type="hidden" name="id_pelaporan" value="<?= $item['id_pelaporan'] ?>">
                                <button type="submit" class="btn btn-sm btn-warning" title="Arsipkan">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleFilterInputs(filter) {
    document.getElementById('kategori-filter').style.display = filter === 'kategori' ? 'block' : 'none';
    document.getElementById('status-filter').style.display = filter === 'status' ? 'block' : 'none';
    document.getElementById('tanggal-filter-start').style.display = filter === 'tanggal' ? 'block' : 'none';
    document.getElementById('tanggal-filter-end').style.display = filter === 'tanggal' ? 'block' : 'none';
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
