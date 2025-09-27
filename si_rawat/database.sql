-- SI RAWAT Database (import via phpMyAdmin)
CREATE DATABASE IF NOT EXISTS si_rawat_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE si_rawat_db;

DROP TABLE IF EXISTS maintenance_docs;
DROP TABLE IF EXISTS maintenance_schedule;
DROP TABLE IF EXISTS assets;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin login: admin / admin123  (stored as MD5 to keep setup simple)
INSERT INTO users (username, password, role) VALUES
('admin', MD5('admin123'), 'admin');

CREATE TABLE assets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_aset VARCHAR(50) NOT NULL,
  nama_aset VARCHAR(100) NOT NULL,
  kategori VARCHAR(100),
  lokasi VARCHAR(100),
  tanggal_beli DATE,
  kondisi VARCHAR(50),
  nilai_aset DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE maintenance_schedule (
  id INT AUTO_INCREMENT PRIMARY KEY,
  asset_id INT NOT NULL,
  tanggal DATE NOT NULL,
  jenis_perawatan VARCHAR(100) NOT NULL,
  deskripsi TEXT,
  status ENUM('pending','proses','selesai') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_sched_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE
);

CREATE TABLE maintenance_docs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  asset_id INT NOT NULL,
  tanggal DATE NOT NULL,
  foto VARCHAR(255) NOT NULL,
  keterangan TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_docs_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE
);
