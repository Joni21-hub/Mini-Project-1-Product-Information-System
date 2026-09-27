# Product Information System (KatalogApp)

Proyek ini adalah aplikasi web PHP Native (tanpa framework) yang dibangun untuk memenuhi tugas "Pemrograman Web Pertemuan 2: PHP Fundamental & Data Structure - Mini Project 1".

## 1. Cara Menjalankan Aplikasi

Aplikasi ini tidak memerlukan web server terpisah seperti XAMPP atau Apache jika Anda sudah menginstal PHP di sistem Anda. Anda dapat menggunakan PHP built-in server.

1. Buka terminal (Command Prompt / PowerShell / Terminal).
2. Navigasikan ke direktori tempat file-file proyek ini berada (direktori yang mengandung `index.php`).
3. Jalankan perintah berikut di terminal:
   ```bash
   php -S localhost:8000
   ```
4. Buka web browser Anda dan akses alamat URL: `http://localhost:8000`
5. Untuk menguji mode debugging / state inspection:
   - Akses `http://localhost:8000/?debug=1` untuk melihat hasil inspeksi struktur variabel menggunakan `print_r` dan `var_dump`.
   - Akses `http://localhost:8000/?debug=die` untuk mendemonstrasikan penghentian paksa eksekusi skrip menggunakan fungsi `die()`.

## 2. Arsitektur Separation of Concerns (SoC)

Proyek ini dirancang menggunakan prinsip pemisahan tanggung jawab (Separation of Concerns/Single Responsibility Principle) untuk menjaga kode tetap bersih, modular, dan terstruktur:

- **`config.php` (Configuration Layer)**: Mengelola konfigurasi global dan konstanta aplikasi (seperti tarif PPN dan nama aplikasi). Memisahkan pengaturan statis agar tidak tercampur dalam logika bisnis, sehingga mudah diubah di satu titik (Single Source of Truth).
- **`products.php` (Data Layer)**: Menyimpan simulasi basis data di memori dalam bentuk Multidimensional Array. Pemisahan ini menjaga independensi data dari tampilan UI.
- **`functions.php` (Processing Layer)**: Berisi sekumpulan fungsi helper modular. Semua aturan bisnis (seperti perhitungan total stok, diskon, PPN, status peringatan stok, dan manipulasi tag) diabstraksikan di sini. Jika logika bisnis berubah, kita hanya perlu mengubah fungsi ini tanpa menyentuh *view*.
- **`layout_header.php` & `layout_footer.php` (UI Components)**: Menyimpan template struktur halaman, styling CSS, dan elemen statis lainnya.
- **`index.php` (Presentation Layer)**: Bertindak sebagai controller utama (atau presenter) yang merakit seluruh komponen dengan melakukan injeksi dependensi melalui `require_once` dan `include`, lalu me-render visualisasi datanya dengan melakukan *looping* dan mengikat fungsionalitas dari layer proses (helper bisnis).

## 3. Jawaban Pertanyaan Evaluatif

**Soal 1: Mengapa associative array dinilai jauh lebih representatif dan aman untuk memetakan spesifikasi detail atribut produk dibanding menggunakan indexed array?**

*Jawaban:* Associative array memetakan nilai ke dalam "kunci" (key) bertipe string yang deskriptif dan memiliki konteks semantik yang jelas (misalnya: `"nama" => "Laptop"`, `"harga" => 7500000`). Hal ini menciptakan kode yang *self-documenting* dan jauh lebih representatif. Jika kita menggunakan indexed array, kita terpaksa mengakses nilai berdasarkan urutan indeks numeriknya (misal: `$produk[1]` untuk nama dan `$produk[3]` untuk harga). Masalahnya adalah indexed array sangat rentan (*brittle*). Apabila skema data berubah—misalnya kita menambahkan satu atribut baru di awal atau tengah struktur—maka seluruh urutan indeks akan bergeser, dan seluruh logika akses atau tampilan dalam sistem akan seketika *crash* atau menghasilkan data yang salah kamar (tidak aman). Sebaliknya, associative array tidak terikat pada urutan sehingga aman terhadap pergeseran struktur dan meminimalkan error *hard-coding*.

---

**Soal 2: Berikan analisis konsekuensi fatal yang terjadi jika seorang developer ceroboh menggunakan `include` dibandingkan `require` untuk memuat file database connection vendor!**

*Jawaban:* Perbedaan mendasar antara `include` dan `require` terletak pada level penanganan galat (*error handling*). 
Jika fungsi `include` gagal memuat sebuah file (misal file kredensial database hilang, korup, atau jalurnya salah), PHP hanya akan menerbitkan pesan level peringatan (*Warning*) **tetapi eksekusi skrip akan tetap dilanjutkan ke baris berikutnya**. Konsekuensi fatalnya meliputi:
1. **Cascade Error**: Logika aplikasi akan tetap mencoba menjalankan *query* SQL yang berujung pada rentetan error tidak dikenali dan membingungkan pengguna.
2. **Keamanan / Information Leakage**: Data atau struktur tabel rahasia yang tidak terenkapsulasi dengan benar bisa terekspos karena aplikasi berada dalam state yang tidak terdefinisi (*undefined state*).
3. **Inkonsistensi Data**: Aplikasi berpotensi menulis ke dalam variabel sesi tanpa persetujuan dari sistem autentikasi database.
Sebaliknya, `require` bersifat tegas dengan toleransi nol (Zero Tolerance). Jika gagal memuat file database, `require` akan memicu *Fatal Error* dan seketika menghentikan (meng-*halt*) seluruh eksekusi program demi melindungi stabilitas dan keamanan aplikasi dari kondisi *inconsistent state*.

---

**Soal 3: Mengapa penanganan galat logika (logic error) memakan durasi pencarian yang jauh lebih lama dan sulit dideteksi dibandingkan dengan kesalahan sintaksis (syntax error)? Sertakan penjelasan cara membaca error dari kanan ke kiri serta teknik State Inspection (`var_dump`, `print_r`, `die`).**

*Jawaban:* Kesalahan sintaks (*syntax error*) seperti kurang titik koma (`;`) atau salah ketik *keyword* langsung dicegat dengan mudah oleh PHP *parser/compiler* sebelum program mulai beroperasi. Interpreter akan langsung merujuk persis pada file dan nomor baris lokasi yang salah. 
Sebaliknya, *logic error* adalah bug tak kasat mata di mana program berjalan sempurna tanpa terdeteksi sebagai "error" atau "crash", tetapi perhitungan outputnya salah (misal fungsi `hitungDiskon` malah menambah nilai, bukan mengurangi). Mesin tidak mengerti "logika bisnis", sehingga kita dibiarkan mencari sendiri letak kebocoran tersebut.
- **Teknik Membaca Error dari Kanan ke Kiri (Reverse Trace/Backtracking):** Ketika menemukan *output* salah (ujung kanan di browser), kita harus menelusuri mundur: Pertama lihat bagian tampilan (`index.php`), lalu lacak darimana nilai itu berasal ke fungsi di *processing layer* (`functions.php`), lalu uji perhitungan fungsinya, hingga mundur merunut terus sampai sumber variabel asalnya (`products.php` di hulu).
- **Teknik State Inspection:** Karena kode tidak melaporkan galat, pengembang harus memeriksa keadaan sesungguhnya (*state*) dari mesin/memori pada baris-baris tertentu.
  - `print_r($variabel)`: Sangat baik untuk menampilkan hierarki dan isi elemen dari Multidimensional Array ke dalam format yang manusiawi.
  - `var_dump($variabel)`: Mengungkapkan informasi paling presisi tentang tipe data (apakah nilai "0" tersebut String, Integer, atau NULL). Hal ini mempermudah deteksi mengapa operator *strict identity* (`===`) bisa menghasilkan False padahal tampak serupa.
  - `die("Pesan")` atau `exit`: Dipasang pada baris tertentu untuk mematikan eksekusi skrip secara brutal. Hal ini akan mencegah program melanjutkan sisa kodenya, sehingga developer bisa fokus mengamati isi State Inspection (dari var_dump) tepat di momen baris kode tersebut berjalan.

---

**Soal 4: Tinjau dari sudut pandang optimasi memori: Apa bahaya struktural jangka panjang jika arsitektur database direplikasi ke dalam multidimensional array yang tingkat bersarangnya (nesting) terlalu dalam?**

*Jawaban:* PHP menggunakan implementasi *hash table/Zend engine structs* (zval) pada layer bahasa C di belakangnya. Setiap elemen (baik *key* maupun *value*) membawa overhead metadata, pointer referensi, dan alokasi blok memori tersendiri.
Jika kita mencoba me-replikasi struktur kompleks *relational database* berskala produksi (*ribuan atau jutaan baris*) ke dalam multidimensional array bersarang-dalam (*deep nesting*), maka bahaya strukturalnya:
1. **Memory Bloat (Pembengkakan Memori):** Array akan tumbuh eksponensial di RAM, menyebabkan aplikasi kehabisan *Memory Limit* secara instan.
2. **Overhead Pointer Traversal:** Operasi iterasi perulangan ganda bersarang tinggi (deep nesting loop) membuat prosesor tersendat melakukan pencarian di alamat *heap memory*. 
3. **Hambatan Garbage Collection:** Sistem pembersih memori akan kerepotan dan terbebani hebat ketika harus mendaur ulang ratusan ribu elemen dan menelusuri rantai pointer satu per satu, menurunkan performa I/O aplikasi (bottleneck).
Karena itu, *best practice*-nya untuk meniru database besar bukan menyimpan utuh dalam *in-memory* Multidimensional Array, melainkan mengambil data dengan *Lazy Loading* (membaca baris-per-baris melalui iterator, misalnya *PDO fetch*) agar profil penggunaan memori (*memory footprint*) tetap konstan dan ringan.
