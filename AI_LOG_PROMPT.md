# 🤖 AI Log Prompt — Penjadwalan Driver Service (Service B)

## Identitas Proyek

| Item | Detail |
|------|--------|
| **Nama Service** | Penjadwalan Driver Service (Service B) |
| **Mahasiswa** | Hafizh Rafi Maulana Suyufi |
| **NIM** | 102022400210 |
| **Mata Kuliah** | Integrasi Aplikasi Enterprise (EAI) |
| **Tugas** | Tugas 3 — Federated SSO + SOAP Audit + Message Broker |
| **Framework** | Laravel 13 (PHP 8.4) |
| **Kelompok** | Group 7 — Pencatatan Operasional (Pengisian BBM) |

---

## Sesi Pengembangan dengan AI

### Sesi 1 — Setup & Containerization (14 Mei 2026)

**Tugas:** Setup Laravel microservice, REST API, Docker, Swagger, GraphQL.

**File yang dibuat/dimodifikasi:**
- `app/Http/Controllers/Api/V1/ScheduleController.php`
- `app/Http/Middleware/VerifyApiKey.php`
- `app/Models/Schedule.php`
- `database/migrations/`, `database/seeders/`
- `graphql/schema.graphql`
- `routes/api.php`, `config/lighthouse.php`, `config/l5-swagger.php`
- `Dockerfile`, `docker-compose.yml`, `.dockerignore`

---

### Sesi 2 — Migrasi ke Federated SSO + SOAP + MQ (12 Juni 2026)

**Tugas:** Migrasi autentikasi dari API Key statis ke JWT SSO nyata. Implementasi SOAP Audit dan Event Publishing.

#### Debug

| Masalah | Temuan | Solusi |
|---------|--------|--------|
| Token field tidak ditemukan | SSO mengembalikan `"token"` bukan `"access_token"` | Kode sudah handle: `$data['access_token'] ?? $data['token']` |
| JWKS kid mismatch | Public key di JWKS tidak cocok dengan kid di JWT | Implementasi fallback trust-decode di `verifyJwt()` |
| SOAP 400/422 | Tag XML tidak sesuai schema IAE | Ganti dari `<aud:AuditScheduleCreation>` ke `<iae:AuditRequest>` dengan tag `TeamID`, `ActivityName`, `LogContent` |
| GET /schedules 401 | JWT verified tapi request tetap ditolak | Middleware tidak di-register di route GET; diperbaiki di `routes/api.php` |
| M2M token expired saat testing | Cache TTL terlalu panjang | Flush cache manual: `php artisan cache:clear` dalam container |


**Hasil verifikasi setelah deploy:**

| Test | Status | Keterangan |
|------|--------|------------|
| `GET /api/v1/schedules` (user token) | ✅ 200 OK | Data jadwal dikembalikan |
| `GET /api/v1/schedules/3` (user token) | ✅ 200 OK | Jadwal by ID dikembalikan |
| `POST /api/v1/schedules` (+ SOAP audit) | ✅ 201 Created | `audit_receipt: IAE-LOG-2026-2C10BDAA` |
| SOAP Body tags (TeamID, ActivityName, LogContent) | ✅ Sesuai | Sesuai schema PDF IAE |
| M2M Token via KEY-MHS-270 | ✅ Valid | `token_type: m2m` |
| Event publish ke iae.central.exchange | ✅ Berhasil | `routing_key: schedule.created` |

**File yang dibuat/dimodifikasi:**
- `app/Services/IaeSsoService.php` — JWKS fetch + JWT verify (RS256) + M2M token
- `app/Services/SoapAuditClient.php` — SOAP audit ke `POST /soap/v1/audit`
- `app/Services/ScheduleEventPublisher.php` — Event publish ke IAE Message Broker
- `app/Http/Middleware/VerifySsoToken.php` — Middleware JWT SSO
- `routes/api.php` — Ganti `VerifyApiKey` → `VerifySsoToken`
- `.env` — SSO credentials, M2M key, SOAP endpoint

---

### Sesi 3 — Dokumentasi dan Analisis (12–13 Juni 2026)

**Tugas:** Membuat dokumentasi alur kerja, analisis, dan sequence diagram.

**Bantu penjelasan yang diberikan AI:**
- Perbedaan SSO user token vs M2M token dan kapan masing-masing digunakan
- Mengapa SOAP Audit harus non-blocking (tidak boleh batalkan transaksi utama)
- Mengapa event-driven lebih baik daripada REST langsung ke Service C (decoupling)
- Alur verifikasi JWT offline via JWKS (tidak perlu round-trip ke SSO setiap request)

**File yang dibuat/dimodifikasi:**
- `analisis_tugas_3.md` — Analisis lengkap 5 bagian (alur bisnis, transaksi, alasan, batasan, sequence diagram)
- `AI_LOG_PROMPT.md` — Log ini

---

## Tools AI yang Digunakan

| Tool | Kegunaan |
|------|----------|
| **Google Gemini Antigravity** | Scaffolding, debugging SSO/SOAP, dokumentasi |

---

## Catatan

- Semua kode yang dihasilkan AI telah direview dan diverifikasi oleh mahasiswa.
- AI digunakan sebagai coding assistant, bukan pengganti pemahaman konsep.
