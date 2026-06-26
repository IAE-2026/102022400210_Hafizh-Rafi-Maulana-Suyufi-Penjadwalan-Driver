# Checklist Pengecekan Testing

## Security & Standard
- [x] Endpoint menolak request tanpa `X-IAE-KEY`
  - *Catatan: Status tanpa key: 404 (Diperbaiki: Sudah mengembalikan 401)*
- [x] Request dengan `X-IAE-KEY` (NIM) berhasil
  - *Catatan: Status: 404 (Diperbaiki: Endpoint kini tereksekusi dengan benar)*

## Fungsionalitas REST
- [x] `GET /api/v1/[resource]` → 200 + JSON wrapper
  - *Catatan: Status 404, wrapper=invalid (Diperbaiki: Route string literal dan parameter kini dikenali dengan benar)*
- [x] `GET /api/v1/[resource]/{id}` → 404 + error wrapper
  - *Catatan: Status 404, wrapper=invalid (Diperbaiki)*
- [x] `POST /api/v1/[resource]` → 201 + JSON wrapper
  - *Catatan: Status 404, wrapper=invalid (Diperbaiki)*
- [x] Service berjalan di Docker

## API Documentation
- [x] Swagger UI dapat diakses
- [x] Swagger mencerminkan endpoint REST
  - *Catatan: OpenAPI paths: 2 (Aman: Path `/schedules` dan `/schedules/{id}` tercatat)*

## GraphQL Implementation
- [x] GraphQL Playground / endpoint dapat diakses
- [x] Query GraphQL (introspection) berhasil
