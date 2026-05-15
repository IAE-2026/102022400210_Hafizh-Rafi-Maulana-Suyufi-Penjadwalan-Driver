# 🤖 AI Log Prompt — Penjadwalan Driver Service (Service B)

## Identitas Proyek

| Item | Detail |
|------|--------|
| **Nama Service** | Penjadwalan Driver Service (Service B) |
| **Mahasiswa** | Hafizh Rafi Maulana Suyufi |
| **NIM** | 102022400210 |
| **Mata Kuliah** | Integrasi Aplikasi Enterprise (EAI) |
| **Tugas** | Tugas 2 — Microservice Integration |
| **Framework** | Laravel 13 (PHP 8.4) |
| **Kelompok** | Group 7 — Pencatatan Operasional (Pengisian BBM) |

---

## Deskripsi Umum

Service B adalah microservice untuk mengelola **jadwal operasional driver** di dalam ekosistem Group 7. Service ini menyediakan data jadwal driver melalui **REST API** dan **GraphQL**, yang digunakan oleh Service C (Tikta) untuk memvalidasi bahwa driver yang mengisi BBM memang sedang bertugas pada hari tersebut.

---

## Riwayat Pengembangan dengan AI

### Sesi 1 — Inisialisasi & Setup Project

**Tanggal:** 14 Mei 2026

**Prompt/Tugas yang diberikan:**
- Setup project Laravel 13 sebagai microservice untuk penjadwalan driver
- Buat struktur database untuk tabel `schedules`
- Implementasi REST API dengan endpoint CRUD (GET all, GET by ID, POST)
- Implementasi API Key authentication menggunakan middleware (`X-IAE-KEY: 102022400210`)
- Integrasi Swagger (OpenAPI) untuk dokumentasi API
- Integrasi GraphQL menggunakan Lighthouse

**Hasil yang diperoleh:**
1. **Model & Migration** — Tabel `schedules` dengan kolom: `driver_name`, `vehicle_id`, `plate_number`, `schedule_date`, `shift`, `status`, `notes`
2. **ScheduleController** — Controller REST API di `App\Http\Controllers\Api\V1\ScheduleController` dengan 3 endpoint:
   - `GET /api/v1/schedules` — Ambil semua jadwal
   - `GET /api/v1/schedules/{id}` — Ambil jadwal spesifik
   - `POST /api/v1/schedules` — Buat jadwal baru
3. **VerifyApiKey Middleware** — Middleware untuk validasi header `X-IAE-KEY` di setiap request REST API
4. **Swagger/OpenAPI** — Dokumentasi interaktif di `/api/documentation` menggunakan L5-Swagger dengan PHP Attributes
5. **ScheduleSchema** — Schema OpenAPI terpisah di `App\Swagger\ScheduleSchema`
6. **GraphQL** — Schema GraphQL dengan query `schedules` dan `schedule(id)` menggunakan Lighthouse
7. **Seeder** — 5 data sampel driver jadwal dengan berbagai shift dan status

**Modifikasi yang dilakukan oleh AI:**
- Membuat file: `app/Http/Controllers/Api/V1/ScheduleController.php`
- Membuat file: `app/Http/Middleware/VerifyApiKey.php`
- Membuat file: `app/Models/Schedule.php`
- Membuat file: `app/Swagger/ScheduleSchema.php`
- Membuat file: `database/migrations/2026_05_14_172927_create_schedules_table.php`
- Membuat file: `database/seeders/ScheduleSeeder.php`
- Membuat file: `graphql/schema.graphql`
- Memodifikasi file: `routes/api.php`
- Memodifikasi file: `config/lighthouse.php`
- Memodifikasi file: `config/l5-swagger.php`

---

### Sesi 2 — Containerization & Docker Setup

**Tanggal:** 14 Mei 2026

**Prompt/Tugas yang diberikan:**
- Setup Docker container untuk menjalankan service
- Konfigurasi Docker Compose dengan MySQL 8.0 sebagai database
- Pastikan aplikasi dapat berjalan di environment Docker secara otomatis (migrate, seed, generate docs)

**Hasil yang diperoleh:**
1. **Dockerfile** — Container berbasis `php:8.4-cli` dengan Composer, ekstensi PHP yang diperlukan, dan startup script otomatis
2. **docker-compose.yml** — Orkestrasi 2 container:
   - `app` — Laravel application (port 8000 → 80)
   - `db` — MySQL 8.0 (port 3306)
3. **.env.example** — Konfigurasi environment untuk koneksi MySQL Docker
4. **.dockerignore** — File exclusion untuk build Docker

**Modifikasi yang dilakukan oleh AI:**
- Membuat file: `Dockerfile`
- Membuat file: `docker-compose.yml`
- Membuat file: `.dockerignore`
- Memodifikasi file: `.env.example`

---

### Sesi 3 — Optimasi Swagger & Bug Fixing

**Tanggal:** 14–15 Mei 2026

**Prompt/Tugas yang diberikan:**
- Optimasi tampilan Swagger UI — menghapus redundant success-case body schemas untuk response 200/201
- Memperbaiki issue GraphQL performance (query cache deserialization error)
- Menambahkan API Key authentication untuk GraphQL endpoint

**Hasil yang diperoleh:**
1. **Swagger Response Cleanup** — Response 200/201 hanya menampilkan description tanpa inline schema (menghindari duplikasi dengan ScheduleSchema)
2. **GraphQL Query Cache Fix** — Menonaktifkan file-based query cache (`LIGHTHOUSE_QUERY_CACHE_ENABLE=false`) yang menyebabkan deserialization error
3. **GraphQL Auth** — Menambahkan `VerifyApiKey::class` middleware ke route GraphQL di `config/lighthouse.php`

**Modifikasi yang dilakukan oleh AI:**
- Memodifikasi file: `app/Http/Controllers/Api/V1/ScheduleController.php` (Swagger response cleanup)
- Memodifikasi file: `config/lighthouse.php` (API Key middleware + query cache fix)

---

### Sesi 4 — Dokumentasi Final

**Tanggal:** 15 Mei 2026

**Prompt/Tugas yang diberikan:**
- Perbarui `README.md` agar sesuai dengan state project terkini
- Buat file `AI_LOG_PROMPT.md` sebagai log penggunaan AI

**Hasil yang diperoleh:**
1. **README.md** — Dokumentasi lengkap yang diperbarui:
   - Memperbaiki info framework (PHP 8.4, bukan 8.x)
   - Menambahkan info database MySQL 8.0 (Docker)
   - Memperbaiki info GraphQL (sekarang membutuhkan API Key)
   - Menambahkan tabel teknologi yang digunakan
   - Menambahkan tabel data sampel seeder
   - Menambahkan environment variables Docker
   - Menambahkan tabel HTTP status codes
   - Menyertakan contoh GraphQL dengan header API Key
   - Memperjelas validasi request body
2. **AI_LOG_PROMPT.md** — Dokumen ini

**Modifikasi yang dilakukan oleh AI:**
- Menulis ulang file: `README.md`
- Membuat file: `AI_LOG_PROMPT.md`

---

## Ringkasan File yang Dibuat/Dimodifikasi oleh AI

| File | Aksi | Keterangan |
|------|------|------------|
| `app/Http/Controllers/Api/V1/ScheduleController.php` | Dibuat + Dimodifikasi | Controller REST API + Swagger annotations |
| `app/Http/Middleware/VerifyApiKey.php` | Dibuat | Middleware autentikasi API Key |
| `app/Models/Schedule.php` | Dibuat | Model Eloquent untuk tabel schedules |
| `app/Swagger/ScheduleSchema.php` | Dibuat | Schema OpenAPI terpisah |
| `database/migrations/2026_05_14_..._create_schedules_table.php` | Dibuat | Migrasi tabel schedules |
| `database/seeders/ScheduleSeeder.php` | Dibuat | 5 data sampel |
| `database/seeders/DatabaseSeeder.php` | Dimodifikasi | Memanggil ScheduleSeeder |
| `graphql/schema.graphql` | Dibuat | Schema GraphQL |
| `routes/api.php` | Dimodifikasi | Routing REST API v1 |
| `config/lighthouse.php` | Dimodifikasi | Middleware + cache config |
| `config/l5-swagger.php` | Dimodifikasi | Konfigurasi Swagger |
| `Dockerfile` | Dibuat | Docker container config |
| `docker-compose.yml` | Dibuat | Docker Compose orkestrasi |
| `.dockerignore` | Dibuat | Docker build exclusions |
| `.env.example` | Dimodifikasi | Environment template |
| `README.md` | Ditulis ulang | Dokumentasi project |
| `AI_LOG_PROMPT.md` | Dibuat | Log penggunaan AI (dokumen ini) |

---

## Tools AI yang Digunakan

| Tool | Kegunaan |
|------|----------|
| **Google Gemini (Antigravity / Claude)** | Coding assistant untuk scaffolding, debugging, dan dokumentasi |

---

## Catatan

- Semua kode yang dihasilkan AI telah direview dan diverifikasi oleh mahasiswa sebelum digunakan.
- AI digunakan sebagai alat bantu pengembangan (coding assistant), bukan sebagai pengganti pemahaman konsep.
- Mahasiswa memahami sepenuhnya arsitektur microservice, REST API, GraphQL, dan integrasi antar service yang diimplementasikan.
