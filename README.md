## Laporan & Bukti Pengujian Praktikum Minggu 06 (SIPUS-Del Tahap 2)

### 1. Pengujian Transaksi ACID & Pessimistic Locking (`lockForUpdate`)

#### A. Penolakan Peminjaman Saat Stok Buku Habis (Stok = 0)
Sistem melakukan penguncian baris (*pessimistic lock*) menggunakan `lockForUpdate()` dalam transaksi `DB::transaction()`. Ketika stok buku 0, sistem melempar `RuntimeException` dan melakukan *rollback* otomatis sehingga transaksi dibatalkan dengan aman.

![Pengujian Penolakan Stok Habis](docs/acid-rollback-test.png)

#### B. Transaksi Peminjaman Berhasil (Stok > 0)
Saat stok tersedia, sistem mengurangi stok secara atomik dan mencatat histori peminjaman secara konsisten.

![Pengujian Transaksi Sukses](docs/acid-success-test.png)

---

### 2. Audit Keamanan Sesi & Cookie (`HttpOnly`)

Berdasarkan pemeriksaan pada browser DevTools (Tab **Application** -> **Cookies**):
- **`laravel_session`**: Terkonfigurasi dengan atribut **`HttpOnly`** dan **`SameSite=Lax`** untuk mencegah ancaman pencurian sesi via serangan *Cross-Site Scripting* (XSS) dan *Cross-Site Request Forgery* (CSRF)[cite: 3].
- **`sipus_last_librarian`**: Cookie pengingat pustakawan yang dikirim via `Cookie::queue()`[cite: 6].

![Audit Cookie HttpOnly di DevTools](docs/cookie-audit.png)