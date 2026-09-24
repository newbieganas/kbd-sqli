# Simulasi SQL Injection (PHP + PostgreSQL + Docker)

## Struktur
```
sqli-sim/
├── docker-compose.yml
├── Dockerfile
├── db/init.sql          # skema + data awal (format PostgreSQL)
└── app/                 # vulnerable.php, secure.php, db.php, style.css
```

## Menjalankan (WSL Ubuntu)
Pastikan Docker sudah jalan (`docker --version` dan `docker compose version`).

```bash
cd sqli-sim
docker compose up -d --build
```

Buka di browser Windows:
- http://localhost:8080/vulnerable.php  -> versi rentan
- http://localhost:8080/secure.php      -> versi aman (prepared statement)

## Perintah berguna
```bash
docker compose logs -f web          # lihat log Apache/PHP
docker compose exec db psql -U postgres -d praktikum_kbd -c "SELECT * FROM users;"
docker compose down                 # stop container (data tetap ada)
docker compose down -v              # stop + hapus data (reset database)
```

`init.sql` hanya dijalankan saat volume `pgdata` baru dibuat. Kalau kamu mengubah
`init.sql` atau data rusak akibat percobaan, jalankan `docker compose down -v`
lalu `docker compose up -d --build` lagi.

## Payload contoh (halaman vulnerable)
- Bypass login: username `admin' --`, password bebas
- Bypass login: username & password `' OR '1'='1`
- UNION: `' UNION SELECT 1,username,password FROM users --`

## Catatan keamanan
- Port web hanya di-bind ke `127.0.0.1`, jadi tidak terekspos ke jaringan.
- Port PostgreSQL tidak dipublikasikan ke host.
- Jangan deploy ke server publik. Aplikasi ini sengaja vulnerable.
