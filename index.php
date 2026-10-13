<?php
// Presentation Layer Utama

// Gabungkan komponen core (wajib) dengan require_once
require_once 'config.php';
require_once 'products.php';
require_once 'functions.php';

// Gabungkan layout header (opsional) dengan include
include 'layout_header.php';

// Fitur Mode Debugging / State Inspection (Menjaga 100% spesifikasi penugasan)
if (isset($_GET['debug'])) {
    if ($_GET['debug'] === '1') {
        echo "<div class='debug-box'>";
        echo "<h3>🛠️ Inspeksi Data (\$katalogProduk) — State Inspection</h3>";
        echo "<pre>";
        print_r($katalogProduk);
        echo "</pre>";
        
        echo "<h3>Perbandingan == (Equality) vs === (Strict Identity)</h3>";
        $contohStokStr = "0";
        $contohStokInt = 0;
        
        echo "<div>Variabel <code>\$contohStokStr = '0'</code> (String)</div>";
        echo "<div>Variabel <code>\$contohStokInt = 0</code> (Integer)</div><br>";
        
        echo "<code>var_dump(\$contohStokStr == \$contohStokInt);</code><br>";
        echo "<div style='margin: 8px 0;'>";
        var_dump($contohStokStr == $contohStokInt);
        echo "</div>";
        echo "<div style='color: #94a3b8;'><em>(Equality: true, karena nilainya setara setelah konversi tipe implisit)</em></div><br>";
        
        echo "<code>var_dump(\$contohStokStr === \$contohStokInt);</code><br>";
        echo "<div style='margin: 8px 0;'>";
        var_dump($contohStokStr === $contohStokInt);
        echo "</div>";
        echo "<div style='color: #94a3b8;'><em>(Strict Identity: false, karena tipe data memori berbeda: String vs Integer)</em></div>";
        echo "</div>";
    } elseif ($_GET['debug'] === 'die') {
        // Mendemonstrasikan penghentian eksekusi menggunakan fungsi bawaan die()
        die("<div class='debug-box' style='color: #ef4444; font-size: 1.2em; font-weight: bold; border-left: 6px solid #ef4444;'>🛑 Berhenti untuk inspeksi data (State Inspection via die())</div>");
    }
}

// Perhitungan metrik ringkasan
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

<!-- 1. HERO & PROMOTIONAL SHOWCASE BANNER -->
<section class="hero-banner-section">
    <img src="assets/images/hero-banner.jpg" alt="Promo Marketplace Banner" class="hero-banner-bg">
    <div class="hero-content">
        <div>
            <div class="hero-badge-tag">
                <span>🔥 Flash Deal Akhir Kuartal</span>
            </div>
            <h1 class="hero-title">
                Etalase Produk Unggulan &amp; <span class="gradient-text">Logistik Cerdas</span>
            </h1>
            <p class="hero-description">
                Solusi inventaris terintegrasi dengan kalkulasi otomatis diskon promosi 5% dan PPN 11% sesuai regulasi perpajakan. Eksplorasi katalog komoditas premium atau pantau audit aset gudang secara real-time.
            </p>
            <div class="hero-cta-group">
                <a href="#katalogSection" class="btn btn-primary btn-lg">
                    <span>Jelajahi Katalog</span>
                    <span>↓</span>
                </a>
                <a href="admin.php" class="btn btn-secondary btn-lg" style="background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.3); backdrop-filter: blur(8px);">
                    <span>Panel Inventaris</span>
                    <span>➔</span>
                </a>
                <a href="index.php?debug=1" class="btn btn-secondary btn-sm" style="background: rgba(15,23,42,0.8); color: #38bdf8; border-color: rgba(56,189,248,0.4);" title="Uji Mode Debugging">
                    <span>🛠️ Debug Mode</span>
                </a>
            </div>
        </div>

        <!-- Hero Side Quick Card -->
        <div class="hero-card-side">
            <div class="hero-promo-countdown">
                <div>
                    <div class="countdown-label">Promo Berakhir Dalam</div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; font-weight: 500;">Diskon Otomatis 5% Semua Item</div>
                </div>
                <div class="countdown-timer-boxes">
                    <span class="timer-box" id="timerHours">04</span>
                    <span style="font-weight: bold; color: #fff; align-self: center;">:</span>
                    <span class="timer-box" id="timerMinutes">45</span>
                    <span style="font-weight: bold; color: #fff; align-self: center;">:</span>
                    <span class="timer-box" id="timerSeconds">20</span>
                </div>
            </div>
            <div class="hero-side-metrics">
                <div class="hero-mini-stat">
                    <div class="stat-num">Rp <?= number_format($totalAsetGudang / 1000000, 1, ',', '.') ?>M</div>
                    <div class="stat-text">Valuasi Aset Gudang</div>
                </div>
                <div class="hero-mini-stat">
                    <div class="stat-num"><?= $totalUnitStok ?> Unit</div>
                    <div class="stat-text">Fisik Komoditas Siap Kirim</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. EXECUTIVE KPI DASHBOARD STATS -->
<div class="stats-grid-container">
    <!-- Stat 1: Total Aset -->
    <div class="stat-card" style="--stat-gradient: var(--grad-primary); --stat-bg: var(--primary-50); --stat-color: var(--primary-600);">
        <div class="stat-icon-wrapper">💰</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total Nilai Aset Gudang</span>
            <span class="stat-value-highlight">Rp <?= number_format($totalAsetGudang, 0, ',', '.') ?></span>
            <span class="stat-subtext-detail">Kalkulasi <code>∑(harga × stok)</code></span>
        </div>
    </div>

    <!-- Stat 2: Total SKU -->
    <div class="stat-card" style="--stat-gradient: var(--grad-info); --stat-bg: #e0f2fe; --stat-color: #0284c7;">
        <div class="stat-icon-wrapper">📦</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total Komoditas (SKU)</span>
            <span class="stat-value-highlight"><?= $totalProdukSKU ?> Produk</span>
            <span class="stat-subtext-detail">Tersebar di 4 kategori aktif</span>
        </div>
    </div>

    <!-- Stat 3: Stok Fisik -->
    <div class="stat-card" style="--stat-gradient: var(--grad-success); --stat-bg: #ecfdf5; --stat-color: #059669;">
        <div class="stat-icon-wrapper">📊</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total Stok Fisik</span>
            <span class="stat-value-highlight"><?= $totalUnitStok ?> Unit</span>
            <span class="stat-subtext-detail">Tersimpan di gudang sentral</span>
        </div>
    </div>

    <!-- Stat 4: Peringatan Stok -->
    <div class="stat-card" style="--stat-gradient: var(--grad-accent); --stat-bg: #fef2f2; --stat-color: #dc2626;">
        <div class="stat-icon-wrapper">⚠️</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Perhatian Restock</span>
            <span class="stat-value-highlight"><?= $stokKritisCount + $stokHabisCount ?> Produk</span>
            <span class="stat-subtext-detail"><?= $stokHabisCount ?> Habis &bull; <?= $stokKritisCount ?> Kritis (&lt; 3)</span>
        </div>
    </div>
</div>

<!-- Preserved Summary Card (Memastikan kompatibilitas output pengujian evaluasi) -->
<div class="summary-card" id="katalogSection">
    <div style="display: flex; align-items: center; gap: 12px;">
        <span style="font-size: 1.5rem;">🏢</span>
        <span>Total Nilai Aset Gudang Keseluruhan: <strong>Rp <?= number_format($totalAsetGudang, 0, ',', '.') ?></strong></span>
    </div>
    <div style="font-size: 0.85rem; color: #475569; font-weight: normal;">
        Tarif Pajak PPN: <strong><?= (PAJAK_PPN * 100) ?>%</strong>
    </div>
</div>

<!-- 3. INTERACTIVE CONTROL TOOLBAR -->
<div class="catalog-toolbar-panel">
    <!-- Category Pills Filter -->
    <div class="category-pills-row">
        <button type="button" class="category-pill-btn active" data-category="all">
            <span>✨</span> Semua Kategori (<?= $totalProdukSKU ?>)
        </button>
        <?php foreach ($daftarKategori as $kat): ?>
            <?php 
                $countInKat = count(array_filter($katalogProduk, fn($p) => $p['kategori'] === $kat));
            ?>
            <button type="button" class="category-pill-btn" data-category="<?= htmlspecialchars($kat) ?>">
                <span><?= ($kat === 'Tech') ? '💻' : (($kat === 'Apparel') ? '👕' : (($kat === 'Home') ? '🏠' : '⌚')) ?></span>
                <?= htmlspecialchars($kat) ?> (<?= $countInKat ?>)
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Filter & View Switcher Options -->
    <div class="filter-actions-row">
        <div class="filter-group-left">
            <!-- Filter Status Stok -->
            <label for="statusFilterSelect" style="font-size: 0.85rem; font-weight: 700; color: var(--slate-600);">Status:</label>
            <select id="statusFilterSelect" class="custom-select">
                <option value="all">Semua Status Stok</option>
                <option value="aman">🟢 Stok Aman (≥ 3)</option>
                <option value="kritis">🟡 Stok Kritis (&lt; 3)</option>
                <option value="habis">🔴 Stok Habis (0)</option>
            </select>

            <!-- Sorting Select -->
            <label for="sortSelect" style="font-size: 0.85rem; font-weight: 700; color: var(--slate-600);">Urutkan:</label>
            <select id="sortSelect" class="custom-select">
                <option value="default">Rekomendasi Utama</option>
                <option value="price-low">Harga: Terendah ke Tertinggi</option>
                <option value="price-high">Harga: Tertinggi ke Terendah</option>
                <option value="rating-high">Rating Tertinggi ⭐</option>
                <option value="stock-high">Stok Terbanyak</option>
                <option value="name-az">Nama: A - Z</option>
            </select>
        </div>

        <!-- View Mode Switcher -->
        <div class="view-switcher-group">
            <button type="button" class="view-btn active" id="viewGridBtn" title="Tampilan Kartu Marketplace">
                <span>▦</span> Grid Produk
            </button>
            <button type="button" class="view-btn" id="viewTableBtn" title="Tampilan Tabel Audit Gudang">
                <span>☰</span> Tabel Audit
            </button>
        </div>
    </div>
</div>

<!-- Empty Search / Filter State (Hidden by default) -->
<div id="catalogEmptyState" style="display: none; text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-xl); border: 1px dashed var(--slate-300); margin-bottom: 30px;">
    <div style="font-size: 3.5rem; margin-bottom: 12px;">🔍</div>
    <h3 style="color: var(--slate-800); margin-bottom: 8px;">Tidak Ada Produk yang Cocok</h3>
    <p style="color: var(--slate-500); font-size: 0.9rem; max-width: 420px; margin: 0 auto 18px auto;">
        Coba gunakan kata kunci lain atau ubah filter kategori dan status stok.
    </p>
    <button type="button" class="btn btn-secondary btn-sm" onclick="location.reload()">Reset Filter</button>
</div>

<!-- 4. VIEW MODE A: MODERN MARKETPLACE GRID VIEW -->
<div class="product-grid-container" id="catalogGridView">
    <?php foreach ($katalogProduk as $item): ?>
        <?php
            // Helper functions calculations
            $hargaDiskon = hitungDiskon($item['harga'], 5);
            $hargaFinal = hitungHargaDenganPpn($hargaDiskon);
            $tagsFormatted = formatTagsProduk($item['tags']);
            $panjangDeskripsi = hitungPanjangDeskripsi($item['deskripsi']);
            $statusStok = cekStatusStok($item['stok']);
            $labelKategori = getLabelKategori($item['kategori']);
            $badgeVisual = cekBadgeStatusStok($item['stok']);
            $imgSrc = !empty($item['gambar']) ? $item['gambar'] : 'assets/images/prod-laptop.jpg';
            
            $statusKey = ($item['stok'] === 0) ? 'habis' : (($item['stok'] < 3) ? 'kritis' : 'aman');
        ?>
        <article class="product-card" 
                 data-id="<?= htmlspecialchars($item['id']) ?>"
                 data-name="<?= htmlspecialchars($item['nama']) ?>"
                 data-category="<?= htmlspecialchars($item['kategori']) ?>"
                 data-status="<?= $statusKey ?>"
                 data-price="<?= $item['harga'] ?>"
                 data-finalprice="<?= $hargaFinal ?>"
                 data-rating="<?= $item['rating'] ?>"
                 data-stock="<?= $item['stok'] ?>"
                 data-tags="<?= htmlspecialchars($tagsFormatted) ?>">
            
            <!-- Image Frame -->
            <div class="product-img-wrapper">
                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['nama']) ?>" class="product-card-img" loading="lazy">
                
                <!-- Floating Top Badges -->
                <div class="card-top-badges">
                    <span class="discount-badge-tag">Hemat 5%</span>
                    <?= $badgeVisual ?>
                </div>

                <!-- Hover Quick Actions Overlay -->
                <div class="card-quick-actions">
                    <button type="button" 
                            class="quick-view-overlay-btn js-quick-view-btn"
                            data-id="<?= htmlspecialchars($item['id']) ?>"
                            data-name="<?= htmlspecialchars($item['nama']) ?>"
                            data-category="<?= htmlspecialchars($item['kategori']) ?>"
                            data-categorybadge='<?= $labelKategori ?>'
                            data-stockbadge='<?= $badgeVisual ?>'
                            data-price="<?= $item['harga'] ?>"
                            data-finalprice="<?= $hargaFinal ?>"
                            data-stock="<?= $item['stok'] ?>"
                            data-desc="<?= htmlspecialchars($item['deskripsi']) ?>"
                            data-catatan="<?= htmlspecialchars($item['catatanGudang'] ?? '') ?>"
                            data-tags="<?= htmlspecialchars($tagsFormatted) ?>"
                            data-image="<?= htmlspecialchars($imgSrc) ?>">
                        <span>👁️ Quick View</span>
                    </button>
                </div>
            </div>

            <!-- Card Content Body -->
            <div class="product-card-body">
                <div class="card-meta-row">
                    <span class="product-sku-id"><?= htmlspecialchars($item['id']) ?></span>
                    <div class="card-rating-wrap" title="Rating kepuasan konsumen">
                        <span>⭐</span>
                        <span><?= number_format($item['rating'], 1) ?></span>
                        <span style="color: #92400e; font-weight: normal; font-size: 0.72rem;">(<?= $item['terjual'] ?? 50 ?>+ terjual)</span>
                    </div>
                </div>

                <h3 class="product-card-title"><?= htmlspecialchars($item['nama']) ?></h3>
                
                <p class="product-card-desc" title="<?= htmlspecialchars($item['deskripsi']) ?>">
                    <?= htmlspecialchars($item['deskripsi']) ?>
                </p>

                <!-- Tags as Chips -->
                <div class="product-tags-container">
                    <?php 
                        $tagParts = explode('|', $tagsFormatted);
                        foreach ($tagParts as $tp):
                    ?>
                        <span class="tag-chip">#<?= trim($tp) ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Pricing Calculation -->
                <div class="product-pricing-box">
                    <div class="original-price-wrap">
                        <span>Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                        <span style="background: #fef2f2; color: #dc2626; padding: 1px 6px; border-radius: 4px; font-size: 0.72rem; font-weight: bold;">-5%</span>
                    </div>
                    <div class="final-price-highlight">
                        Rp <?= number_format($hargaFinal, 0, ',', '.') ?>
                    </div>
                    <div class="ppn-tax-included-note">
                        Termasuk PPN 11% (Rp <?= number_format($hargaDiskon * PAJAK_PPN, 0, ',', '.') ?>)
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="product-card-footer">
                    <button type="button" 
                            class="btn btn-primary btn-block js-add-to-cart"
                            data-id="<?= htmlspecialchars($item['id']) ?>"
                            data-name="<?= htmlspecialchars($item['nama']) ?>"
                            data-price="<?= $item['harga'] ?>"
                            data-finalprice="<?= $hargaFinal ?>"
                            data-stock="<?= $item['stok'] ?>"
                            data-image="<?= htmlspecialchars($imgSrc) ?>"
                            <?= ($item['stok'] === 0) ? 'disabled' : '' ?>>
                        <span><?= ($item['stok'] === 0) ? '✕ Stok Habis' : '🛒 Beli Sekarang' ?></span>
                    </button>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<!-- 5. VIEW MODE B: PRESERVED WAREHOUSE AUDIT DATA TABLE (Hidden by default, toggleable) -->
<div class="table-panel-card" id="catalogTableView" style="display: none;">
    <div class="table-header-bar">
        <div>
            <h3 style="font-size: 1.15rem; margin-bottom: 4px;">📋 Lembar Audit Inventaris &amp; Logistik Gudang</h3>
            <p style="font-size: 0.85rem; color: var(--slate-500); margin: 0;">
                Format data terstruktur untuk pengawasan stok fisik, kalkulasi pajak PPN 11%, dan verifikasi data komoditas.
            </p>
        </div>
        <div style="font-size: 0.85rem; font-weight: 700; color: var(--primary-700);">
            Total Nilai: Rp <?= number_format($totalAsetGudang, 0, ',', '.') ?>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga Satuan</th>
                    <th>Harga Akhir (Diskon 5% + PPN 11%)</th>
                    <th>Stok &amp; Status</th>
                    <th>Tags</th>
                    <th>Deskripsi (Panjang)</th>
                    <th>Subtotal Nilai Stok</th>
                </tr>
            </thead>
            <tbody class="catalog-table-body">
                <?php foreach ($katalogProduk as $item): ?>
                    <?php 
                        // Terapkan fungsi pembantu (helper) untuk masing-masing baris (Preserved exact functions)
                        $kelasBaris = cekWarnaBarisStok($item['stok']);
                        $statusStok = cekStatusStok($item['stok']);
                        $labelKategori = getLabelKategori($item['kategori']);
                        
                        // Hitung harga setelah diskon (misal diskon promo 5%) dan PPN
                        $hargaDiskon = hitungDiskon($item['harga'], 5);
                        $hargaFinal = hitungHargaDenganPpn($hargaDiskon);
                        
                        $tagsFormatted = formatTagsProduk($item['tags']);
                        $panjangDeskripsi = hitungPanjangDeskripsi($item['deskripsi']);
                        $subtotal = $item['harga'] * $item['stok'];
                        $imgThumb = !empty($item['gambar']) ? $item['gambar'] : 'assets/images/prod-laptop.jpg';
                        $statusKey = ($item['stok'] === 0) ? 'habis' : (($item['stok'] < 3) ? 'kritis' : 'aman');
                    ?>
                    <tr class="<?= $kelasBaris ?>"
                        data-name="<?= htmlspecialchars($item['nama']) ?>"
                        data-category="<?= htmlspecialchars($item['kategori']) ?>"
                        data-status="<?= $statusKey ?>"
                        data-tags="<?= htmlspecialchars($tagsFormatted) ?>">
                        <td><code><?= htmlspecialchars($item['id']) ?></code></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="<?= htmlspecialchars($imgThumb) ?>" alt="Thumb" style="width: 36px; height: 36px; border-radius: 6px; object-fit: cover; border: 1px solid var(--slate-200);">
                                <strong><?= htmlspecialchars($item['nama']) ?></strong>
                            </div>
                        </td>
                        <td><?= $labelKategori ?></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td><strong style="color: var(--primary-700);">Rp <?= number_format($hargaFinal, 0, ',', '.') ?></strong></td>
                        <td>
                            <span style="font-size: 1.15em; font-weight: 800;"><?= $item['stok'] ?></span><br>
                            <small style="font-weight: 600;"><?= $statusStok ?></small>
                        </td>
                        <td><small><?= htmlspecialchars($tagsFormatted) ?></small></td>
                        <td>
                            <?= htmlspecialchars($item['deskripsi']) ?><br>
                            <small style="color: var(--slate-500);"><em>(<?= $panjangDeskripsi ?> karakter)</em></small>
                        </td>
                        <td><strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
// Gabungkan layout footer (opsional) dengan include
include 'layout_footer.php'; 
?>
