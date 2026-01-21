# Dokumentasi Keamanan API Panggilan Ghaib

## Ringkasan Security Audit

API ini telah melalui security audit komprehensif dan telah diperkuat dengan berbagai layer keamanan.

---

## ✅ Security Features yang Diimplementasikan

### 1. Autentikasi API Key

- **Timing-safe comparison** menggunakan `hash_equals()` untuk mencegah timing attacks
- **Random delay** (100-300ms) pada login gagal untuk mencegah brute force
- Header `X-API-Key` diperlukan untuk semua operasi tulis (POST/PUT/DELETE)

### 2. Rate Limiting

- **Public endpoints**: 100 request/menit per IP
- **Protected endpoints**: 30 request/menit per IP
- Response 429 dengan `Retry-After` header jika limit tercapai

### 3. Input Validation

- Semua input divalidasi dengan aturan ketat
- Regex untuk format nomor perkara
- Validasi URL untuk link_surat
- Max length untuk semua string fields

### 4. XSS Prevention

- Semua input teks di-sanitize dengan `strip_tags()`
- Content-Type header verification
- `X-Content-Type-Options: nosniff`

### 5. CORS Security

- Strict origin whitelist (tidak menggunakan `*` di production)
- Security headers: X-Frame-Options, X-XSS-Protection
- Vary header untuk proper caching

### 6. SQL Injection Prevention

- Menggunakan Eloquent ORM (parameterized queries)
- Route parameters divalidasi dengan regex

### 7. Mass Assignment Protection

- Hanya field yang di-whitelist yang bisa diupdate
- Menggunakan `$request->only()` bukan `$request->all()`

---

## 🔒 Konfigurasi Production yang WAJIB

### File .env

```
APP_DEBUG=false          # WAJIB false di production
APP_ENV=production       # WAJIB production
API_KEY=xxx              # Minimal 32 karakter, random
CORS_ALLOWED_ORIGINS=    # Whitelist domain, JANGAN pakai *
```

### Rekomendasi API Key

Generate API key yang aman:

```bash
openssl rand -base64 32
```

---

## 🛡️ Checklist Deploy Production

- [ ] APP_DEBUG = false
- [ ] API_KEY sudah diganti dengan key rahasia (min 32 karakter)
- [ ] CORS_ALLOWED_ORIGINS diisi dengan domain yang spesifik
- [ ] File .env tidak terakses publik
- [ ] Folder vendor/ tidak bisa diakses langsung
- [ ] HTTPS aktif di hosting
- [ ] Database password yang kuat
- [ ] Backup database rutin

---

## 📊 Endpoint Security Matrix

| Endpoint                       | Method | Auth       | Rate Limit | Notes     |
| ------------------------------ | ------ | ---------- | ---------- | --------- |
| `/api/panggilan`               | GET    | ❌ Public  | 100/min    | Read only |
| `/api/panggilan/{id}`          | GET    | ❌ Public  | 100/min    | Read only |
| `/api/panggilan/tahun/{tahun}` | GET    | ❌ Public  | 100/min    | Read only |
| `/api/panggilan`               | POST   | ✅ API Key | 30/min     | Create    |
| `/api/panggilan/{id}`          | PUT    | ✅ API Key | 30/min     | Update    |
| `/api/panggilan/{id}`          | DELETE | ✅ API Key | 30/min     | Delete    |

---

## ⚠️ Jika Terjadi Security Incident

1. Ganti API_KEY segera
2. Cek log akses untuk aktivitas mencurigakan
3. Matikan sementara endpoint yang bermasalah
4. Hubungi admin hosting jika diperlukan
