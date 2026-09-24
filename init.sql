-- Dijalankan otomatis oleh container postgres saat pertama kali volume dibuat.
-- Database praktikum_kbd sudah dibuat via POSTGRES_DB, jadi langsung buat tabel.
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO users (username, password) VALUES
('admin','admin123'),
('developer','dev123'),
('auditor','audit123');
