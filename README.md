# SIPUS-Del (Sistem Informasi Perpustakaan)
Tugas Praktikum Minggu 5 PPW - Theresia Oktaviani Samosir (12S24055)

## Fitur Utama
- Arsitektur MVC terpisah untuk entitas Buku dan Kategori.
- Proteksi Mass Assignment menggunakan properti `$fillable`.
- Routing RESTful dengan Validasi Form Sisi Server (Server-Side Validation).
- UI menggunakan Blade Components dengan tema warna institut.

## Bukti Audit Optimasi Kinerja (Eager Loading)
Implementasi Eager Loading melalui `Buku::with('kategori')` berhasil mereduksi N+1 Query Problem pada pemuatan relasi data. Alih-alih mengeksekusi kueri kategori berulang kali untuk setiap baris buku, sistem mengompresinya menjadi satu kueri efisien menggunakan klausa `IN`. 

Berikut adalah rekaman log SQL dari sistem saat memuat halaman index katalog buku dan melakukan paginasi:

```text
[2026-10-09 08:59:12] local.INFO: [SQL AUDIT] (13.82 ms) select count(*) as `aggregate` from `bukus`  
[2026-10-09 08:59:12] local.INFO: [SQL AUDIT] (1.44 ms) select * from `bukus` order by `created_at` desc limit 10 offset 0  
[2026-10-09 08:59:12] local.INFO: [SQL AUDIT] (1.54 ms) select * from `kategoris` where `kategoris`.`id` in (1, 2, 4, 5)  
[2026-10-09 08:59:22] local.INFO: [SQL AUDIT] (5.77 ms) select count(*) as `aggregate` from `bukus`  
[2026-10-09 08:59:22] local.INFO: [SQL AUDIT] (1.19 ms) select * from `bukus` order by `created_at` desc limit 10 offset 10  
[2026-10-09 08:59:22] local.INFO: [SQL AUDIT] (1.28 ms) select * from `kategoris` where `kategoris`.`id` in (2, 3, 4, 5)