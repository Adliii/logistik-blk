# 📦 Kiela Logistik

Sistem Informasi Manajemen Gudang dan Logistik berbasis web. Aplikasi ini dirancang untuk mencatat arus keluar masuk barang, mengelola data master (Pelanggan, Pemasok, dan Produk), serta menghitung ketersediaan stok secara otomatis.

Dibangun dengan antarmuka yang modern, cepat, dan responsif menggunakan **Filament PHP**.

---

## ✨ Fitur Utama

- **📦 Manajemen Master Data:** Pengelolaan data `Products`, `Customers`, dan `Suppliers` dengan *custom primary key* untuk keamanan struktur *database*.
- **🤖 Auto-Generate ID:** Sistem penomoran kode otomatis (contoh: `CST-0001`, `SPL-0001`) setiap kali ada penambahan data master baru.
- **🔄 Transaksi Barang Masuk & Keluar:** Pencatatan logistik harian dengan relasi data yang kuat.
- **⚙️ Robot Penjaga Stok (Auto-Sync):** Ketersediaan stok produk akan bertambah/berkurang secara otomatis setiap kali ada transaksi yang dibuat, diedit, atau dihapus.
- **📊 Export Data:** Mendukung pengunduhan data tabel ke dalam format **Excel (.xlsx)**.
- **📄 Cetak Surat Jalan (PDF):** *(Tahap Pengembangan)*

## 🛠️ Tech Stack

- **Framework:** [Laravel 11](https://laravel.com/)
- **Admin Panel:** [Filament V3](https://filamentphp.com/)
- **Database:** SQLite / MySQL
- **Plugin Tambahan:** `pxlrbt/filament-excel`

---

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer Anda:

**1. Clone Repository & Install Dependencies**
```bash
git clone [https://github.com/username-anda/kiela-logistik.git](https://github.com/username-anda/kiela-logistik.git)
cd kiela-logistik
composer install
npm install
npm run build
