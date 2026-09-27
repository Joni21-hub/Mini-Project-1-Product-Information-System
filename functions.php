<?php
// Processing Layer / Helper Bisnis

// 1. Mengalkulasi dan mengembalikan total nilai aset gudang
function hitungTotalNilaiStok($daftarProduk) {
    $totalNilai = 0;
    foreach ($daftarProduk as $produk) {
        $totalNilai += ($produk['harga'] * $produk['stok']);
    }
    return $totalNilai;
}

// 2. Menghitung potongan harga dan mengembalikan harga netto
function hitungDiskon($harga, $persen) {
    return $harga - ($harga * ($persen / 100));
}

// 3. Menghitung harga ditambah pajak menggunakan konstanta
function hitungHargaDenganPpn($harga) {
    return $harga + ($harga * PAJAK_PPN);
}

// 4. Logika conditional untuk menyaring warna baris tabel HTML
function cekWarnaBarisStok($stok) {
    if ($stok === 0) {
        return "table-danger";
    } elseif ($stok < 3) {
        return "table-warning";
    } else {
        return "";
    }
}

// 5. Mengembalikan status stok dengan struktur if-elseif-else
function cekStatusStok($stok) {
    if ($stok === 0) {
        return "Stok Habis!";
    } elseif ($stok < 3) {
        return "Stok Kritis/Menipis!";
    } else {
        return "Stok Aman";
    }
}

// 6. Mencocokkan nilai kategori dan mengembalikan label badge
function getLabelKategori($kategori) {
    switch ($kategori) {
        case "Tech":
            return "<span class='badge badge-tech'>💻 Tech</span>";
        case "Apparel":
            return "<span class='badge badge-apparel'>👕 Apparel</span>";
        case "Home":
            return "<span class='badge badge-home'>🏠 Home</span>";
        case "Accessories":
            return "<span class='badge badge-accessories'>⌚ Accessories</span>";
        default:
            return "<span class='badge badge-default'>📦 Lainnya</span>";
    }
}

// 7. Demonstrasi fungsi bawaan manipulasi string
function formatTagsProduk($rawTags) {
    // Normalisasi tanda hubung menjadi spasi
    $normalizedTags = str_replace("-", " ", $rawTags);
    
    // Pecah string menjadi array
    $tagsArray = explode(",", $normalizedTags);
    
    // Trim whitespace (opsional namun baik untuk kebersihan data)
    $tagsArray = array_map('trim', $tagsArray);
    
    // Rajut kembali array menjadi string terformat rapi
    $formattedTags = implode(" | ", $tagsArray);
    
    return $formattedTags;
}

// 8. Menghitung jumlah karakter deskripsi
function hitungPanjangDeskripsi($deskripsi) {
    return strlen($deskripsi);
}
