<?php
// Halaman Checkout & Pembayaran Terintegrasi
require_once 'config.php';
require_once 'products.php';
require_once 'functions.php';

include 'layout_header.php';
?>

<!-- Breadcrumbs -->
<div style="margin-bottom: 24px; font-size: 0.88rem; color: var(--slate-500); display: flex; align-items: center; gap: 8px;">
    <a href="index.php" style="color: var(--slate-600); font-weight: 600;">Beranda</a>
    <span>›</span>
    <span style="color: var(--slate-600); font-weight: 600;">Keranjang</span>
    <span>›</span>
    <span style="color: var(--primary-600); font-weight: 700;">Checkout &amp; Pembayaran</span>
</div>

<div style="margin-bottom: 32px;">
    <h1 style="font-size: 2.2rem; margin-bottom: 8px;">Checkout Pesanan &amp; Faktur PPN</h1>
    <p style="color: var(--slate-500); font-size: 0.95rem; margin: 0;">
        Lengkapi rincian pengiriman dan pilih metode pembayaran resmi dengan kalkulasi PPN 11% otomatis.
    </p>
</div>

<!-- 2-Column Grid Checkout Layout -->
<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 32px; align-items: start; margin-bottom: 60px;">
    
    <!-- LEFT COLUMN: Forms -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Section 1: Alamat Pengiriman -->
        <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); padding: 28px; box-shadow: var(--shadow-sm);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-50); color: var(--primary-600); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">1</span>
                <h3 style="font-size: 1.2rem; margin: 0;">Data Penerima &amp; Alamat Pengiriman</h3>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="custName">Nama Penerima</label>
                    <input type="text" id="custName" class="form-control" value="Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="custPhone">Nomor WhatsApp / HP</label>
                    <input type="tel" id="custPhone" class="form-control" value="0812-3456-7890" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="custAddress">Alamat Lengkap</label>
                <textarea id="custAddress" class="form-control" rows="2" placeholder="Jl. Sudirman No. 45, Gedung Bursa Efek, Jakarta Selatan" required>Jl. Gatot Subroto Kav. 52, RT 02/RW 01, Mampang Prapatan, Jakarta Selatan</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="custCity">Kota / Kabupaten</label>
                    <input type="text" id="custCity" class="form-control" value="Jakarta Selatan" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="custPostal">Kode Pos</label>
                    <input type="text" id="custPostal" class="form-control" value="12710" required>
                </div>
            </div>
        </div>

        <!-- Section 2: Kurir & Logistik -->
        <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); padding: 28px; box-shadow: var(--shadow-sm);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-50); color: var(--primary-600); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">2</span>
                <h3 style="font-size: 1.2rem; margin: 0;">Pilihan Layanan Ekspedisi</h3>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border: 1.5px solid var(--primary-600); border-radius: var(--radius-md); background: var(--primary-50); cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="shippingMethod" value="25000" checked onchange="updateCheckoutTotals()">
                        <div>
                            <strong style="color: var(--slate-900);">⚡ JNE Express Kilat (1-2 Hari Kerja)</strong>
                            <div style="font-size: 0.78rem; color: var(--slate-500);">Asuransi kehilangan &amp; pelacakan langsung</div>
                        </div>
                    </div>
                    <strong style="color: var(--primary-700);">Rp 25.000</strong>
                </label>

                <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border: 1.5px solid var(--slate-200); border-radius: var(--radius-md); background: #ffffff; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="radio" name="shippingMethod" value="45000" onchange="updateCheckoutTotals()">
                        <div>
                            <strong style="color: var(--slate-900);">🚀 GoSend Instant Sameday (3 Jam Sampai)</strong>
                            <div style="font-size: 0.78rem; color: var(--slate-500);">Khusus Jabodetabek &amp; Kurir Terverifikasi</div>
                        </div>
                    </div>
                    <strong style="color: var(--slate-800);">Rp 45.000</strong>
                </label>
            </div>
        </div>

        <!-- Section 3: Metode Pembayaran -->
        <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); padding: 28px; box-shadow: var(--shadow-sm);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <span style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-50); color: var(--primary-600); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">3</span>
                <h3 style="font-size: 1.2rem; margin: 0;">Metode Pembayaran Resmi</h3>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <label style="border: 1.5px solid var(--primary-600); border-radius: var(--radius-md); padding: 14px; background: var(--primary-50); cursor: pointer; display: flex; align-items: center; gap: 10px;">
                    <input type="radio" name="paymentGateway" value="qris" checked>
                    <div>
                        <strong style="font-size: 0.9rem; color: var(--slate-900);">QRIS Otomatis</strong>
                        <div style="font-size: 0.72rem; color: var(--slate-500);">BCA, GoPay, OVO, Dana</div>
                    </div>
                </label>

                <label style="border: 1.5px solid var(--slate-200); border-radius: var(--radius-md); padding: 14px; background: #fff; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                    <input type="radio" name="paymentGateway" value="va">
                    <div>
                        <strong style="font-size: 0.9rem; color: var(--slate-900);">Virtual Account Bank</strong>
                        <div style="font-size: 0.72rem; color: var(--slate-500);">BCA, Mandiri, BNI, BRI</div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Order Summary -->
    <div style="background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); padding: 28px; box-shadow: var(--shadow-lg); position: sticky; top: 100px;">
        <h3 style="font-size: 1.25rem; margin-bottom: 18px; border-bottom: 1px solid var(--slate-100); padding-bottom: 14px;">
            📦 Ringkasan Pesanan
        </h3>

        <!-- Cart Items List Container -->
        <div id="checkoutItemsList" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; max-height: 280px; overflow-y: auto;">
            <!-- Populated via JavaScript -->
        </div>

        <!-- Voucher Code Input -->
        <div style="margin-bottom: 20px; padding: 14px; background: var(--slate-50); border-radius: var(--radius-md); border: 1px solid var(--slate-200);">
            <label class="form-label" style="font-size: 0.8rem;" for="promoInput">Kupon Promosi / Diskon Tambahan</label>
            <div style="display: flex; gap: 8px;">
                <input type="text" id="promoInput" class="form-control" placeholder="Coba: STARTUPVIP" style="text-transform: uppercase;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="applyPromoCode()">Pakai</button>
            </div>
            <div id="promoFeedback" style="font-size: 0.75rem; margin-top: 6px; display: none;"></div>
        </div>

        <!-- Price Breakdown -->
        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.9rem; border-top: 1px solid var(--slate-100); padding-top: 16px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; color: var(--slate-600);">
                <span>Subtotal Komoditas:</span>
                <span id="ckSubtotal">Rp 0</span>
            </div>
            <div style="display: flex; justify-content: space-between; color: var(--slate-600);">
                <span>Diskon Promo Toko (5%):</span>
                <span id="ckDiscount" style="color: #10b981;">-Rp 0</span>
            </div>
            <div style="display: flex; justify-content: space-between; color: var(--slate-600);">
                <span>Pajak PPN (11%):</span>
                <span id="ckPpn">Rp 0</span>
            </div>
            <div style="display: flex; justify-content: space-between; color: var(--slate-600);">
                <span>Biaya Pengiriman:</span>
                <span id="ckShipping">Rp 25.000</span>
            </div>
            <div id="voucherDiscountRow" style="display: none; justify-content: space-between; color: #10b981; font-weight: bold;">
                <span>Kupon Diskon (STARTUPVIP):</span>
                <span id="ckVoucher">-Rp 50.000</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: var(--slate-900); border-top: 1.5px dashed var(--slate-200); padding-top: 12px; margin-top: 6px;">
                <span>Total Tagihan:</span>
                <span id="ckGrandTotal" style="color: var(--primary-700);">Rp 0</span>
            </div>
        </div>

        <button type="button" class="btn btn-primary btn-block btn-lg" onclick="processOrderPayment()">
            <span>🔒 Bayar Sekarang</span>
        </button>

        <div style="text-align: center; margin-top: 14px; font-size: 0.78rem; color: var(--slate-400);">
            Transaksi dilindungi enkripsi TLS 256-bit &bull; Faktur diterbitkan otomatis
        </div>
    </div>
</div>

<!-- Order Success Modal Simulation -->
<div class="modal-backdrop" id="orderSuccessModal">
    <div class="modal-dialog" style="max-width: 540px; text-align: center;">
        <div class="modal-body" style="padding: 40px 32px;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px auto; border: 2px solid #a7f3d0;">
                ✓
            </div>
            <h2 style="font-size: 1.6rem; color: var(--slate-900); margin-bottom: 8px;">Pembayaran Berhasil!</h2>
            <p style="color: var(--slate-600); font-size: 0.9rem; line-height: 1.6; margin-bottom: 24px;">
                Terima kasih atas pesanan Anda. Faktur pajak resmi PPN 11% dan bukti pembayaran telah dikirimkan ke email Anda.
            </p>

            <div style="background: var(--slate-50); border: 1px solid var(--slate-200); border-radius: var(--radius-md); padding: 18px; margin-bottom: 28px; text-align: left; font-size: 0.88rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: var(--slate-500);">Nomor Invoice:</span>
                    <strong style="font-family: monospace;" id="invoiceNum">INV/20261013/MP1/<?= rand(1000, 9999) ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: var(--slate-500);">Status:</span>
                    <span class="stock-pill stock-pill-success"><span class="pulse-dot pulse-success"></span> Lunas (Terverifikasi)</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--slate-500);">Total Terbayar:</span>
                    <strong style="color: var(--primary-700);" id="invoicePaidAmount">Rp 0</strong>
                </div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="window.print()">
                    <span>🖨️ Cetak Faktur</span>
                </button>
                <a href="index.php" class="btn btn-primary" style="flex: 1;">
                    <span>Belanja Lagi</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let voucherApplied = false;
let voucherAmount = 50000;

document.addEventListener('DOMContentLoaded', () => {
    loadCheckoutItems();
});

function loadCheckoutItems() {
    let items = Cart.getItems();
    const container = document.getElementById('checkoutItemsList');
    
    // Jika keranjang masih kosong, sediakan 2 produk default untuk pengujian checkout langsung
    if (items.length === 0) {
        items = [
            {
                id: 'PROD-01',
                name: 'Laptop Asus Pro',
                price: 7500000,
                finalPrice: 7875000,
                image: 'assets/images/prod-laptop.jpg',
                qty: 1
            },
            {
                id: 'PROD-06',
                name: 'Headphone Noise Cancelling',
                price: 1500000,
                finalPrice: 1575000,
                image: 'assets/images/prod-headphone.jpg',
                qty: 1
            }
        ];
    }

    let html = '';
    items.forEach(i => {
        html += `
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-bottom: 10px; border-bottom: 1px solid var(--slate-100);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="${i.image}" alt="${escapeHtml(i.name)}" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid var(--slate-200);">
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--slate-800);">${escapeHtml(i.name)}</div>
                        <div style="font-size: 0.75rem; color: var(--slate-500);">${i.qty} x Rp ${formatRupiahJs(i.finalPrice)}</div>
                    </div>
                </div>
                <strong style="font-size: 0.88rem; color: var(--slate-900);">Rp ${formatRupiahJs(i.finalPrice * i.qty)}</strong>
            </div>
        `;
    });

    container.innerHTML = html;
    updateCheckoutTotals(items);
}

function updateCheckoutTotals(customItems = null) {
    let items = customItems || Cart.getItems();
    if (!items || items.length === 0) {
        items = [
            { price: 7500000, finalPrice: 7875000, qty: 1 },
            { price: 1500000, finalPrice: 1575000, qty: 1 }
        ];
    }

    const shippingRadio = document.querySelector('input[name="shippingMethod"]:checked');
    const shippingCost = shippingRadio ? parseInt(shippingRadio.value) : 25000;

    let rawSubtotal = 0;
    items.forEach(i => {
        rawSubtotal += (i.price * i.qty);
    });

    // 5% discount
    const discountVal = Math.round(rawSubtotal * 0.05);
    const netAfterDiscount = rawSubtotal - discountVal;

    // PPN 11%
    const ppnVal = Math.round(netAfterDiscount * 0.11);

    let grandTotal = netAfterDiscount + ppnVal + shippingCost;
    if (voucherApplied) {
        grandTotal = Math.max(0, grandTotal - voucherAmount);
    }

    document.getElementById('ckSubtotal').textContent = `Rp ${formatRupiahJs(rawSubtotal)}`;
    document.getElementById('ckDiscount').textContent = `-Rp ${formatRupiahJs(discountVal)}`;
    document.getElementById('ckPpn').textContent = `Rp ${formatRupiahJs(ppnVal)}`;
    document.getElementById('ckShipping').textContent = `Rp ${formatRupiahJs(shippingCost)}`;
    document.getElementById('ckGrandTotal').textContent = `Rp ${formatRupiahJs(grandTotal)}`;
}

function applyPromoCode() {
    const code = (document.getElementById('promoInput').value || '').trim().toUpperCase();
    const feedback = document.getElementById('promoFeedback');
    const row = document.getElementById('voucherDiscountRow');

    if (code === 'STARTUPVIP') {
        voucherApplied = true;
        feedback.style.display = 'block';
        feedback.style.color = '#059669';
        feedback.textContent = '✓ Kupon berhasil digunakan! Potongan Rp 50.000 diterapkan.';
        row.style.display = 'flex';
        updateCheckoutTotals();
        showToast('Kupon STARTUPVIP berhasil diterapkan!', 'success');
    } else {
        feedback.style.display = 'block';
        feedback.style.color = '#dc2626';
        feedback.textContent = '✕ Kupon tidak valid. Coba gunakan: STARTUPVIP';
        voucherApplied = false;
        row.style.display = 'none';
        updateCheckoutTotals();
    }
}

function processOrderPayment() {
    const grandTotalText = document.getElementById('ckGrandTotal').textContent;
    document.getElementById('invoicePaidAmount').textContent = grandTotalText;
    
    // Clear cart and show modal
    Cart.clear();
    const modal = document.getElementById('orderSuccessModal');
    if (modal) modal.classList.add('active');
}
</script>

<?php
include 'layout_footer.php';
?>
