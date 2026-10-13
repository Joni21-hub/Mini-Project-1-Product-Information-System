<?php
require_once 'config.php';
require_once 'products.php';
require_once 'functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['user']);
    header("Location: index.php");
    exit;
}

$currentUser = $_SESSION['user'] ?? [
    'name' => 'Budi Santoso',
    'role' => 'Admin Gudang',
    'email' => 'budi.santoso@katalogapp.id',
    'avatar' => 'assets/images/avatar-user.jpg',
    'isLoggedIn' => true
];

include 'layout_header.php';
?>

<!-- Profile Hero Banner -->
<div style="background: var(--grad-dark); border-radius: var(--radius-xl); padding: 36px 40px; color: #ffffff; margin-bottom: 32px; box-shadow: var(--shadow-xl); border: 1px solid rgba(255, 255, 255, 0.1); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <img src="<?= htmlspecialchars($currentUser['avatar']) ?>" alt="Avatar" style="width: 84px; height: 84px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-500); box-shadow: var(--glow-primary);">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <h1 style="font-size: 1.8rem; color: #ffffff; margin: 0;"><?= htmlspecialchars($currentUser['name']) ?></h1>
                <span class="stock-pill stock-pill-success" style="font-size: 0.75rem;">⭐ Member VIP Platinum</span>
            </div>
            <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 4px;">
                <?= htmlspecialchars($currentUser['email']) ?> &bull; <strong style="color: #38bdf8;"><?= htmlspecialchars($currentUser['role']) ?></strong>
            </div>
            <div style="font-size: 0.78rem; color: #64748b;">Bergabung sejak Januari 2026 &bull; Akun Terverifikasi</div>
        </div>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
        <a href="admin.php" class="btn btn-primary btn-sm">
            <span>📊 Kelola Inventaris</span>
        </a>
        <a href="profile.php?action=logout" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.2);">
            <span>Keluar (Logout)</span>
        </a>
    </div>
</div>

<!-- Profile Stats Ribbon -->
<div class="stats-grid-container" style="margin-bottom: 32px;">
    <div class="stat-card" style="--stat-gradient: var(--grad-primary); --stat-bg: var(--primary-50); --stat-color: var(--primary-600);">
        <div class="stat-icon-wrapper">💳</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Saldo Dompet / Pay</span>
            <span class="stat-value-highlight">Rp 3.450.000</span>
            <span class="stat-subtext-detail">Dapat digunakan untuk checkout instan</span>
        </div>
    </div>

    <div class="stat-card" style="--stat-gradient: var(--grad-accent); --stat-bg: #fffbeb; --stat-color: #d97706;">
        <div class="stat-icon-wrapper">🪙</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Koin Reward Aktif</span>
            <span class="stat-value-highlight">12.500 Poin</span>
            <span class="stat-subtext-detail">Setara Rp 12.500 potongan belanja</span>
        </div>
    </div>

    <div class="stat-card" style="--stat-gradient: var(--grad-success); --stat-bg: #ecfdf5; --stat-color: #059669;">
        <div class="stat-icon-wrapper">🛍️</div>
        <div class="stat-info-wrap">
            <span class="stat-label-title">Total Pesanan Sukses</span>
            <span class="stat-value-highlight">18 Transaksi</span>
            <span class="stat-subtext-detail">Semua faktur PPN 11% terbit</span>
        </div>
    </div>
</div>

<!-- Tabs & Order History -->
<div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 40px;">
    <div style="padding: 20px 28px; border-bottom: 1px solid var(--slate-200); background: var(--slate-50); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 1.2rem; margin: 0;">📜 Riwayat Transaksi &amp; Faktur Pembelian</h3>
        <span style="font-size: 0.85rem; color: var(--slate-500);">Menampilkan 3 pesanan terbaru</span>
    </div>

    <div style="padding: 24px 28px; display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Transaction Item 1 -->
        <div style="border: 1px solid var(--slate-200); border-radius: var(--radius-lg); padding: 20px; background: #ffffff;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--slate-100); padding-bottom: 12px; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-family: monospace; font-weight: 700; color: var(--slate-700);">INV/20261011/MP1/8821</span>
                    <span style="color: var(--slate-400);">&bull;</span>
                    <span style="font-size: 0.85rem; color: var(--slate-500);">11 Oktober 2026</span>
                </div>
                <span class="stock-pill stock-pill-success"><span class="pulse-dot pulse-success"></span> Paket Telah Diterima</span>
            </div>

            <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 14px;">
                <img src="assets/images/prod-laptop.jpg" alt="Laptop" style="width: 56px; height: 56px; border-radius: 8px; object-fit: cover; border: 1px solid var(--slate-200);">
                <div style="flex: 1;">
                    <strong style="color: var(--slate-900); font-size: 0.95rem;">Laptop Asus Pro</strong>
                    <div style="font-size: 0.8rem; color: var(--slate-500);">1 barang &bull; Kurir JNE Express Kilat (Resi: JNE882910398)</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.78rem; color: var(--slate-500);">Total Belanja (Inc. PPN 11%):</div>
                    <strong style="font-size: 1.1rem; color: var(--primary-700);">Rp 7.875.000</strong>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="showToast('Mengunduh faktur PDF resmi PPN 11%...', 'info')">
                    <span>📄 Unduh Faktur Pajak</span>
                </button>
                <a href="index.php" class="btn btn-outline btn-sm">Beli Lagi</a>
            </div>
        </div>

        <!-- Transaction Item 2 -->
        <div style="border: 1px solid var(--slate-200); border-radius: var(--radius-lg); padding: 20px; background: #ffffff;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--slate-100); padding-bottom: 12px; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-family: monospace; font-weight: 700; color: var(--slate-700);">INV/20261008/MP1/7732</span>
                    <span style="color: var(--slate-400);">&bull;</span>
                    <span style="font-size: 0.85rem; color: var(--slate-500);">08 Oktober 2026</span>
                </div>
                <span class="stock-pill stock-pill-success"><span class="pulse-dot pulse-success"></span> Selesai</span>
            </div>

            <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 14px;">
                <img src="assets/images/prod-headphone.jpg" alt="Headphone" style="width: 56px; height: 56px; border-radius: 8px; object-fit: cover; border: 1px solid var(--slate-200);">
                <div style="flex: 1;">
                    <strong style="color: var(--slate-900); font-size: 0.95rem;">Headphone Noise Cancelling</strong>
                    <div style="font-size: 0.8rem; color: var(--slate-500);">1 barang &bull; Kurir GoSend Instant</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.78rem; color: var(--slate-500);">Total Belanja (Inc. PPN 11%):</div>
                    <strong style="font-size: 1.1rem; color: var(--primary-700);">Rp 1.575.000</strong>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="showToast('Mengunduh faktur PDF resmi PPN 11%...', 'info')">
                    <span>📄 Unduh Faktur Pajak</span>
                </button>
                <a href="index.php" class="btn btn-outline btn-sm">Beli Lagi</a>
            </div>
        </div>

    </div>
</div>

<?php
include 'layout_footer.php';
?>
