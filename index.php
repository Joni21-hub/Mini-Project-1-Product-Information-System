<?php
// Presentation Layer Utama

// Gabungkan komponen core (wajib) dengan require_once
require_once 'config.php';
require_once 'products.php';
require_once 'functions.php';

// Gabungkan layout header (opsional) dengan include
include 'layout_header.php';

// Fitur Mode Debugging / State Inspection
if (isset($_GET['debug'])) {
    if ($_GET['debug'] === '1') {
        echo "<div class='debug-box'>";
        echo "<h3>Inspeksi Data (\$katalogProduk)</h3>";
        echo "<pre>";
        print_r($katalogProduk);
        echo "</pre>";
        
        echo "<h3>Perbandingan == (Equality) vs === (Strict Identity)</h3>";
        $contohStokStr = "0";
        $contohStokInt = 0;
        
        echo "<div>Variabel <code>\$contohStokStr = '0'</code> (String)</div>";
        echo "<div>Variabel <code>\$contohStokInt = 0</code> (Integer)</div><br>";
        
        echo "<code>var_dump(\$contohStokStr == \$contohStokInt);</code><br>";
        var_dump($contohStokStr == $contohStokInt);
        echo "<div><em>(Equality: true, karena nilainya setara setelah konversi tipe)</em></div><br>";
        
        echo "<code>var_dump(\$contohStokStr === \$contohStokInt);</code><br>";
        var_dump($contohStokStr === $contohStokInt);
        echo "<div><em>(Strict Identity: false, karena tipe datanya berbeda)</em></div>";
        echo "</div>";
    } elseif ($_GET['debug'] === 'die') {
        // Mendemonstrasikan penghentian eksekusi
        die("<div class='debug-box' style='color: #e74c3c; font-size: 1.2em; font-weight: bold;'>Berhenti untuk inspeksi data (State Inspection)</div>");
    }
}

// Hitung ringkasan Total Nilai Aset Gudang
$totalAsetGudang = hitungTotalNilaiStok($katalogProduk);
?>

<div class="summary-card">
    Total Nilai Aset Gudang Keseluruhan: Rp <?= number_format($totalAsetGudang, 0, ',', '.') ?>
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
                <th>Stok & Status</th>
                <th>Tags</th>
                <th>Deskripsi (Panjang)</th>
                <th>Subtotal Nilai Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($katalogProduk as $item): ?>
                <?php 
                    // Terapkan fungsi pembantu (helper) untuk masing-masing baris
                    $kelasBaris = cekWarnaBarisStok($item['stok']);
                    $statusStok = cekStatusStok($item['stok']);
                    $labelKategori = getLabelKategori($item['kategori']);
                    
                    // Hitung harga setelah diskon (misal diskon promo 5%) dan PPN
                    $hargaDiskon = hitungDiskon($item['harga'], 5);
                    $hargaFinal = hitungHargaDenganPpn($hargaDiskon);
                    
                    $tagsFormatted = formatTagsProduk($item['tags']);
                    $panjangDeskripsi = hitungPanjangDeskripsi($item['deskripsi']);
                    $subtotal = $item['harga'] * $item['stok'];
                ?>
                <tr class="<?= $kelasBaris ?>">
                    <td><?= htmlspecialchars($item['id']) ?></td>
                    <td><strong><?= htmlspecialchars($item['nama']) ?></strong></td>
                    <td><?= $labelKategori ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($hargaFinal, 0, ',', '.') ?></td>
                    <td>
                        <span style="font-size: 1.2em; font-weight: bold;"><?= $item['stok'] ?></span><br>
                        <small><?= $statusStok ?></small>
                    </td>
                    <td><?= htmlspecialchars($tagsFormatted) ?></td>
                    <td>
                        <?= htmlspecialchars($item['deskripsi']) ?><br>
                        <small style="color: #666;"><em>(<?= $panjangDeskripsi ?> karakter)</em></small>
                    </td>
                    <td><strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php 
// Gabungkan layout footer (opsional) dengan include
include 'layout_footer.php'; 
?>
