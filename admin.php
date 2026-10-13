<?php
// Admin Inventory Management Dashboard
require_once 'config.php';
require_once 'products.php';
require_once 'functions.php';

include 'layout_header.php';

// Hitung metrik agregat
$totalAsetGudang = hitungTotalNilaiStok($katalogProduk);
$totalProdukSKU = count($katalogProduk);
$totalUnitStok = array_sum(array_column($katalogProduk, 'stok'));
$stokKritisCount = 0;
$stokHabisCount = 0;

foreach ($katalogProduk as $item) {
    if ($item['stok'] === 0) {
        $stokHabisCount++;
    } elseif ($item['stok'] < 3) {
        $stokKritisCount++;
    }
}
?>

<!-- Header Section -->
<div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: gap; gap: 16px;">
    <div>
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #e0e7ff; color: #4338ca; padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 700; margin-bottom: 8px;">
            <span>🛡️ Area Manajemen Logistik</span>
        </div>
        <h1 style="font-size: 2rem; margin-bottom: 6px;">Dashboard Inventaris &amp; Kontrol Gudang</h1>
        <p style="color: var(--slate-500); font-size: 0.95rem; margin: 0;">
            Pantau arus stok fisik komoditas, status peringatan restock, dan valuasi aset riil berbasis PHP Fundamental.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="index.php" class="btn btn-secondary">
            <span>← Kembali ke Katalog</span>
        </a>
        <button type="button" class="btn btn-primary" onclick="showToast('Data inventaris berhasil disinkronisasi dengan gudang pusat.', 'success')">
            <span>🔄 Sinkronisasi Stok</span>
        </button>
    </div>
</div>

<!-- KPI Dashboard Cards -->
<div class="stats-grid-container" style="margin-bottom: 32px;">
    <div class="stat-card" style="--stat-gradient: var(--grad-primary); --stat-bg: var(--primary-50); --stat-color: var(--primary-600);">
        <div class="stat-icon-wrapper">💎</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total Valuasi Aset</span>
            <span class="stat-value-highlight">Rp <?= number_format($totalAsetGudang, 0, ',', '.') ?></span>
            <span class="stat-subtext-detail">Aset dalam pengawasan aktif</span>
        </div>
    </div>

    <div class="stat-card" style="--stat-gradient: var(--grad-info); --stat-bg: #e0f2fe; --stat-color: #0284c7;">
        <div class="stat-icon-wrapper">📦</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total SKU Aktif</span>
            <span class="stat-value-highlight"><?= $totalProdukSKU ?> Komoditas</span>
            <span class="stat-subtext-detail"><?= count($daftarKategori) ?> Kategori bisnis</span>
        </div>
    </div>

    <div class="stat-card" style="--stat-gradient: var(--grad-success); --stat-bg: #ecfdf5; --stat-color: #059669;">
        <div class="stat-icon-wrapper">📈</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Ketersediaan Barang</span>
            <span class="stat-value-highlight"><?= round((($totalProdukSKU - $stokHabisCount) / $totalProdukSKU) * 100) ?>%</span>
            <span class="stat-subtext-detail"><?= $totalUnitStok ?> unit siap jual</span>
        </div>
    </div>

    <div class="stat-card" style="--stat-gradient: var(--grad-accent); --stat-bg: #fef2f2; --stat-color: #dc2626;">
        <div class="stat-icon-wrapper">🚨</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Perlu Tindakan Restock</span>
            <span class="stat-value-highlight"><?= $stokKritisCount + $stokHabisCount ?> Produk</span>
            <span class="stat-subtext-detail"><?= $stokHabisCount ?> Kehabisan total &bull; <?= $stokKritisCount ?> Kritis</span>
        </div>
    </div>
</div>

<!-- Admin Table Panel -->
<div class="table-panel-card">
    <div class="table-header-bar" style="flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 1.4rem;">📑</span>
            <div>
                <h3 style="font-size: 1.15rem; margin-bottom: 2px;">Daftar Master Data Inventaris</h3>
                <div style="font-size: 0.82rem; color: var(--slate-500);">Klik aksi pada baris untuk menambah kuantitas atau mengupdate catatan logistik.</div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; align-items: center;">
            <select id="adminCategoryFilter" class="custom-select" style="padding: 7px 12px; font-size: 0.85rem;" onchange="filterAdminTable()">
                <option value="all">Semua Kategori</option>
                <?php foreach ($daftarKategori as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="adminStatusFilter" class="custom-select" style="padding: 7px 12px; font-size: 0.85rem;" onchange="filterAdminTable()">
                <option value="all">Semua Status</option>
                <option value="aman">Stok Aman</option>
                <option value="kritis">Stok Kritis</option>
                <option value="habis">Stok Habis</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>SKU ID</th>
                    <th>Visual Produk</th>
                    <th>Kategori</th>
                    <th>Harga Satuan</th>
                    <th>Stok Fisik &amp; Status</th>
                    <th>Catatan Gudang</th>
                    <th>Subtotal Valuasi</th>
                    <th>Aksi Logistik</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <?php foreach ($katalogProduk as $item): ?>
                    <?php 
                        $statusClass = cekWarnaBarisStok($item['stok']);
                        $statusText = cekStatusStok($item['stok']);
                        $statusBadge = cekBadgeStatusStok($item['stok']);
                        $catBadge = getLabelKategori($item['kategori']);
                        $subtotal = $item['harga'] * $item['stok'];
                        $img = !empty($item['gambar']) ? $item['gambar'] : 'assets/images/prod-laptop.jpg';
                        $statusType = ($item['stok'] === 0) ? 'habis' : (($item['stok'] < 3) ? 'kritis' : 'aman');
                    ?>
                    <tr class="<?= $statusClass ?>" id="admin-row-<?= htmlspecialchars($item['id']) ?>"
                        data-category="<?= htmlspecialchars($item['kategori']) ?>"
                        data-status="<?= $statusType ?>">
                        <td><code><?= htmlspecialchars($item['id']) ?></code></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="<?= htmlspecialchars($img) ?>" alt="Thumb" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid var(--slate-200);">
                                <div>
                                    <strong style="color: var(--slate-900);"><?= htmlspecialchars($item['nama']) ?></strong>
                                    <div style="font-size: 0.75rem; color: var(--slate-400);">Rating: ⭐ <?= $item['rating'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= $catBadge ?></td>
                        <td><strong>Rp <?= number_format($item['harga'], 0, ',', '.') ?></strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 1.25rem; font-weight: 800; min-width: 28px;" id="stock-val-<?= $item['id'] ?>"><?= $item['stok'] ?></span>
                                <span id="stock-badge-<?= $item['id'] ?>"><?= $statusBadge ?></span>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem; max-width: 220px;" id="note-val-<?= $item['id'] ?>">
                                <?php if ($item['catatanGudang'] !== null): ?>
                                    <span style="color: var(--slate-700);"><?= htmlspecialchars($item['catatanGudang']) ?></span>
                                <?php else: ?>
                                    <em style="color: var(--slate-400);">Tidak ada catatan (NULL)</em>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <strong style="color: var(--slate-900);">Rp <?= number_format($subtotal, 0, ',', '.') ?></strong>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="quickRestock('<?= $item['id'] ?>', '<?= htmlspecialchars($item['nama']) ?>', 5)" title="Tambah 5 Unit">+5 Stok</button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="editNote('<?= $item['id'] ?>', '<?= htmlspecialchars($item['nama']) ?>')" title="Ubah Catatan">✏️ Catatan</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function quickRestock(id, name, amount) {
    const el = document.getElementById(`stock-val-${id}`);
    const badgeEl = document.getElementById(`stock-badge-${id}`);
    const rowEl = document.getElementById(`admin-row-${id}`);
    if (!el) return;

    let current = parseInt(el.textContent) || 0;
    current += amount;
    el.textContent = current;

    // Update visual badge and row class
    if (current >= 3) {
        if (badgeEl) badgeEl.innerHTML = `<span class="stock-pill stock-pill-success"><span class="pulse-dot pulse-success"></span> ${current} Tersedia</span>`;
        if (rowEl) {
            rowEl.className = '';
            rowEl.dataset.status = 'aman';
        }
    } else {
        if (badgeEl) badgeEl.innerHTML = `<span class="stock-pill stock-pill-warning"><span class="pulse-dot pulse-warning"></span> Sisa ${current} (Kritis)</span>`;
        if (rowEl) {
            rowEl.className = 'table-warning';
            rowEl.dataset.status = 'kritis';
        }
    }

    showToast(`Stok untuk <strong>${name}</strong> berhasil ditambah +${amount} unit! Total sekarang: ${current}.`, 'success');
}

function editNote(id, name) {
    const noteEl = document.getElementById(`note-val-${id}`);
    const current = noteEl ? noteEl.textContent.trim() : '';
    const updated = prompt(`Masukkan catatan gudang baru untuk "${name}":`, current);
    if (updated !== null) {
        if (noteEl) noteEl.innerHTML = `<span style="color: #4338ca; font-weight: 600;">${escapeHtml(updated)}</span>`;
        showToast(`Catatan gudang untuk <strong>${name}</strong> berhasil diperbarui.`, 'info');
    }
}

function filterAdminTable() {
    const cat = document.getElementById('adminCategoryFilter').value.toLowerCase();
    const status = document.getElementById('adminStatusFilter').value;
    const rows = document.querySelectorAll('#adminTableBody tr');

    rows.forEach(r => {
        const rowCat = (r.dataset.category || '').toLowerCase();
        const rowStat = r.dataset.status || '';

        const matchCat = (cat === 'all' || rowCat === cat);
        const matchStat = (status === 'all' || rowStat === status);

        r.style.display = (matchCat && matchStat) ? '' : 'none';
    });
}
</script>

<?php
include 'layout_footer.php';
?>
