<?php
// Data Layer

// Multidimensional Array dengan minimal 6 data komoditas produk
$katalogProduk = [
    [
        "id" => "PROD-01",
        "nama" => "Laptop Asus Pro",
        "kategori" => "Tech",
        "harga" => 7500000,
        "stok" => 5, // Stok aman (>= 3)
        "rating" => 4.8,
        "isActive" => true,
        "catatanGudang" => "Barang kondisi baik, segel utuh",
        "tags" => "komputer, laptop, asus-pro",
        "deskripsi" => "Laptop dengan performa tinggi cocok untuk pekerja profesional.",
        "gambar" => "assets/images/prod-laptop.jpg",
        "diskonPersen" => 5,
        "terjual" => 142
    ],
    [
        "id" => "PROD-02",
        "nama" => "Kemeja Flanel Kotak",
        "kategori" => "Apparel",
        "harga" => 250000,
        "stok" => 2, // Stok kritis (< 3)
        "rating" => 4.5,
        "isActive" => true,
        "catatanGudang" => null, // Special NULL
        "tags" => "pakaian, kemeja, lengan-panjang",
        "deskripsi" => "Kemeja flanel pria bahan premium yang nyaman digunakan.",
        "gambar" => "assets/images/prod-flanel.jpg",
        "diskonPersen" => 5,
        "terjual" => 89
    ],
    [
        "id" => "PROD-03",
        "nama" => "Sofa Minimalis",
        "kategori" => "Home",
        "harga" => 2100000,
        "stok" => 0, // Stok habis (0)
        "rating" => 4.2,
        "isActive" => false,
        "catatanGudang" => "Menunggu restock dari supplier luar kota",
        "tags" => "furnitur, sofa, ruang-tamu",
        "deskripsi" => "Sofa elegan 3 seater dengan desain minimalis modern.",
        "gambar" => "assets/images/prod-sofa.jpg",
        "diskonPersen" => 5,
        "terjual" => 35
    ],
    [
        "id" => "PROD-04",
        "nama" => "Smartwatch Z",
        "kategori" => "Accessories",
        "harga" => 1200000,
        "stok" => 1, // Stok kritis (< 3)
        "rating" => 4.6,
        "isActive" => true,
        "catatanGudang" => "Edisi terbatas warna hitam",
        "tags" => "jam-tangan, smart-watch, aksesoris",
        "deskripsi" => "Jam tangan pintar dengan pelacak kesehatan.",
        "gambar" => "assets/images/prod-smartwatch.jpg",
        "diskonPersen" => 5,
        "terjual" => 210
    ],
    [
        "id" => "PROD-05",
        "nama" => "Meja Belajar Kayu",
        "kategori" => "Home",
        "harga" => 850000,
        "stok" => 12, // Stok aman (>= 3)
        "rating" => 4.4,
        "isActive" => true,
        "catatanGudang" => "Siap rakit dalam kotak",
        "tags" => "meja, kayu, ruang-belajar",
        "deskripsi" => "Meja belajar kokoh terbuat dari kayu jati Belanda.",
        "gambar" => "assets/images/prod-meja.jpg",
        "diskonPersen" => 5,
        "terjual" => 64
    ],
    [
        "id" => "PROD-06",
        "nama" => "Headphone Noise Cancelling",
        "kategori" => "Tech",
        "harga" => 1500000,
        "stok" => 8, // Stok aman (>= 3)
        "rating" => 4.9,
        "isActive" => true,
        "catatanGudang" => "Garansi resmi distributor 2 tahun",
        "tags" => "audio, headphone, noise-cancelling",
        "deskripsi" => "Headphone nirkabel dengan teknologi peredam bising aktif terbaik.",
        "gambar" => "assets/images/prod-headphone.jpg",
        "diskonPersen" => 5,
        "terjual" => 312
    ]
];
