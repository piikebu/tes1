-- ============================================
-- Migration 004: Flatten faculty structure
-- Removes program_studi layer; departments IS
-- program studi directly under faculty.
-- Structure: faculties → departments → staff
-- WARNING: Clears all staff and dependent data.
-- ============================================

-- 1. Add program_type to departments (idempotent)
SET @col_exists = (
    SELECT COUNT(*) FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'departments'
      AND COLUMN_NAME  = 'program_type'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE departments ADD COLUMN program_type VARCHAR(20) NOT NULL DEFAULT ''S1'' COMMENT ''S1 / S2 / S3 / Profesi / Spesialis''',
    'SELECT 1'
);
PREPARE _stmt FROM @sql; EXECUTE _stmt; DEALLOCATE PREPARE _stmt;

-- 2. Drop prodi_id FK + column from staff (idempotent)
SET @fk_exists = (
    SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'staff'
      AND CONSTRAINT_NAME = 'fk_staff_prodi'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
);
SET @sql2 = IF(@fk_exists > 0,
    'ALTER TABLE staff DROP FOREIGN KEY fk_staff_prodi',
    'SELECT 1'
);
PREPARE _stmt2 FROM @sql2; EXECUTE _stmt2; DEALLOCATE PREPARE _stmt2;

SET @col2_exists = (
    SELECT COUNT(*) FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'staff'
      AND COLUMN_NAME  = 'prodi_id'
);
SET @sql3 = IF(@col2_exists > 0,
    'ALTER TABLE staff DROP COLUMN prodi_id',
    'SELECT 1'
);
PREPARE _stmt3 FROM @sql3; EXECUTE _stmt3; DEALLOCATE PREPARE _stmt3;

-- 3. Clear all data
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM staff_community_service;
DELETE FROM staff_research;
DELETE FROM staff_publications;
DELETE FROM staff_grants;
DELETE FROM staff;
DELETE FROM departments;
DELETE FROM faculties;

ALTER TABLE staff_community_service AUTO_INCREMENT = 1;
ALTER TABLE staff_research AUTO_INCREMENT = 1;
ALTER TABLE staff_publications AUTO_INCREMENT = 1;
ALTER TABLE staff_grants AUTO_INCREMENT = 1;
ALTER TABLE staff AUTO_INCREMENT = 1;
ALTER TABLE departments AUTO_INCREMENT = 1;
ALTER TABLE faculties AUTO_INCREMENT = 1;
SET FOREIGN_KEY_CHECKS = 1;

-- 4. Drop program_studi (no longer needed)
DROP TABLE IF EXISTS program_studi;

-- ============================================
-- Faculties
-- ============================================
INSERT INTO faculties (id, name, slug, icon) VALUES
( 1, 'Fakultas Kedokteran',                           'kedokteran',     'fa-heartbeat'),
( 2, 'Fakultas Teknik',                               'teknik',         'fa-cogs'),
( 3, 'Fakultas Pertanian',                            'pertanian',      'fa-leaf'),
( 4, 'Fakultas Peternakan',                           'peternakan',     'fa-paw'),
( 5, 'Fakultas Perikanan dan Ilmu Kelautan',          'perikanan',      'fa-water'),
( 6, 'Fakultas Ekonomi dan Bisnis',                   'ekonomi-bisnis', 'fa-chart-line'),
( 7, 'Fakultas Kesehatan Masyarakat',                 'fkm',            'fa-medkit'),
( 8, 'Fakultas Hukum',                                'hukum',          'fa-balance-scale'),
( 9, 'Fakultas Ilmu Budaya',                          'ilmu-budaya',    'fa-book'),
(10, 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'mipa',           'fa-flask'),
(11, 'Fakultas Ilmu Sosial dan Politik',              'fisip',          'fa-users'),
(12, 'Pascasarjana',                                  'pascasarjana',   'fa-graduation-cap');

-- ============================================
-- Departments = Program Studi per faculty
-- ============================================

-- Fakultas Kedokteran
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 1, 'Pendidikan Dokter',                      'pendidikan-dokter',             'S1'),
( 1, 'Kedokteran Gigi',                        'kedokteran-gigi',               'S1'),
( 1, 'Keperawatan',                            'keperawatan',                   'S1'),
( 1, 'Profesi Dokter',                         'profesi-dokter',                'Profesi'),
( 1, 'Profesi Dokter Gigi',                    'profesi-dokter-gigi',           'Profesi'),
( 1, 'Profesi Ners',                           'profesi-ners',                  'Profesi'),
( 1, 'Ilmu Penyakit Mata',                     'ilmu-penyakit-mata',            'Spesialis'),
( 1, 'Ilmu Kesehatan Anak',                    'ilmu-kesehatan-anak',           'Spesialis'),
( 1, 'Ilmu Bedah',                             'ilmu-bedah',                    'Spesialis'),
( 1, 'Ilmu Penyakit Dalam',                    'ilmu-penyakit-dalam',           'Spesialis'),
( 1, 'Obstetri dan Ginekologi',                'obstetri-ginekologi',           'Spesialis'),
( 1, 'Dermatologi dan Venereologi',            'dermatologi-venereologi',       'Spesialis'),
( 1, 'Ilmu Kedokteran Fisik dan Rehabilitasi', 'kedokteran-fisik-rehabilitasi', 'Spesialis'),
( 1, 'Jantung dan Pembuluh Darah',             'jantung-pembuluh-darah',        'Spesialis'),
( 1, 'Ilmu Penyakit Saraf',                    'ilmu-penyakit-saraf',           'Spesialis'),
( 1, 'Anestesiologi dan Terapi Intensif',      'anestesiologi-terapi-intensif', 'Spesialis');

-- Fakultas Teknik
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 2, 'Teknik Sipil',                'teknik-sipil',             'S1'),
( 2, 'Arsitektur',                  'arsitektur',               'S1'),
( 2, 'Teknik Elektro',              'teknik-elektro',           'S1'),
( 2, 'Teknik Mesin',                'teknik-mesin',             'S1'),
( 2, 'Perencanaan Wilayah dan Kota','perencanaan-wilayah-kota', 'S1'),
( 2, 'Teknik Informatika',          'teknik-informatika',       'S1'),
( 2, 'Teknik Lingkungan',           'teknik-lingkungan',        'S1'),
( 2, 'Teknik Industri',             'teknik-industri',          'S1'),
( 2, 'Teknik Pertambangan',         'teknik-pertambangan',      'S1');

-- Fakultas Pertanian
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 3, 'Agronomi',         'agronomi',         'S1'),
( 3, 'Ilmu Tanah',       'ilmu-tanah',       'S1'),
( 3, 'Agribisnis',       'agribisnis',       'S1'),
( 3, 'Teknologi Pangan', 'teknologi-pangan', 'S1'),
( 3, 'Teknik Pertanian', 'teknik-pertanian', 'S1'),
( 3, 'Kehutanan',        'kehutanan',        'S1'),
( 3, 'Agroteknologi',    'agroteknologi',    'S1'),
( 3, 'Proteksi Tanaman', 'proteksi-tanaman', 'S1');

-- Fakultas Peternakan
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 4, 'Peternakan', 'peternakan-s1', 'S1');

-- Fakultas Perikanan dan Ilmu Kelautan
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 5, 'Manajemen Sumberdaya Perairan',    'manajemen-sumberdaya-perairan',    'S1'),
( 5, 'Budidaya Perairan',                'budidaya-perairan',                'S1'),
( 5, 'Ilmu Kelautan',                    'ilmu-kelautan',                    'S1'),
( 5, 'Teknologi Hasil Perikanan',        'teknologi-hasil-perikanan',        'S1'),
( 5, 'Pemanfaatan Sumberdaya Perikanan', 'pemanfaatan-sumberdaya-perikanan', 'S1'),
( 5, 'Agrobisnis Perikanan',             'agrobisnis-perikanan',             'S1');

-- Fakultas Ekonomi dan Bisnis
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 6, 'Ekonomi Pembangunan', 'ekonomi-pembangunan', 'S1'),
( 6, 'Manajemen',           'manajemen',           'S1'),
( 6, 'Akuntansi',           'akuntansi',           'S1');

-- Fakultas Kesehatan Masyarakat
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 7, 'Ilmu Kesehatan Masyarakat', 'ilmu-kesehatan-masyarakat', 'S1');

-- Fakultas Hukum
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 8, 'Ilmu Hukum', 'ilmu-hukum', 'S1');

-- Fakultas Ilmu Budaya
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
( 9, 'Sastra Indonesia', 'sastra-indonesia', 'S1'),
( 9, 'Sastra Inggris',   'sastra-inggris',   'S1'),
( 9, 'Sastra Jerman',    'sastra-jerman',    'S1'),
( 9, 'Ilmu Sejarah',     'ilmu-sejarah',     'S1');

-- Fakultas MIPA
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
(10, 'Kimia',            'kimia',            'S1'),
(10, 'Biologi',          'biologi',          'S1'),
(10, 'Matematika',       'matematika',       'S1'),
(10, 'Fisika',           'fisika',           'S1'),
(10, 'Farmasi',          'farmasi',          'S1'),
(10, 'Sistem Informasi', 'sistem-informasi', 'S1'),
(10, 'Profesi Apoteker', 'profesi-apoteker', 'Profesi');

-- Fakultas Ilmu Sosial dan Politik
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
(11, 'Ilmu Administrasi Negara',       'ilmu-administrasi-negara',  'S1'),
(11, 'Ilmu Administrasi Bisnis/Niaga', 'ilmu-administrasi-bisnis',  'S1'),
(11, 'Ilmu Pemerintahan',              'ilmu-pemerintahan',         'S1'),
(11, 'Ilmu Politik',                   'ilmu-politik',              'S1'),
(11, 'Ilmu Komunikasi',                'ilmu-komunikasi',           'S1'),
(11, 'Sosiologi',                      'sosiologi',                 'S1'),
(11, 'Antropologi Sosial',             'antropologi-sosial',        'S1'),
(11, 'Ilmu Perpustakaan',              'ilmu-perpustakaan',         'S1');

-- Pascasarjana — S2
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
(12, 'Pengelolaan Sumberdaya Pembangunan',   'pengelolaan-sumberdaya-pembangunan', 'S2'),
(12, 'Linguistik',                           'linguistik-s2',                      'S2'),
(12, 'Ilmu Perencanaan Pembangunan Wilayah', 'perencanaan-pembangunan-wilayah',    'S2'),
(12, 'Ilmu Pangan',                          'ilmu-pangan-s2',                     'S2'),
(12, 'Entomologi',                           'entomologi-s2',                      'S2'),
(12, 'Agronomi',                             'agronomi-s2',                        'S2'),
(12, 'Kesehatan Masyarakat',                 'kesehatan-masyarakat-s2',            'S2'),
(12, 'Teknik Sipil',                         'teknik-sipil-s2',                    'S2'),
(12, 'Arsitektur',                           'arsitektur-s2',                      'S2'),
(12, 'Informatika',                          'informatika-s2',                     'S2'),
(12, 'Ilmu Perairan',                        'ilmu-perairan-s2',                   'S2'),
(12, 'Ilmu Ekonomi',                         'ilmu-ekonomi-s2',                    'S2'),
(12, 'Manajemen',                            'manajemen-s2',                       'S2'),
(12, 'Akuntansi',                            'akuntansi-s2',                       'S2'),
(12, 'Biologi',                              'biologi-s2',                         'S2'),
(12, 'Ilmu Hukum',                           'ilmu-hukum-s2',                      'S2'),
(12, 'Peternakan',                           'peternakan-s2',                      'S2'),
(12, 'Ilmu Pemerintahan',                    'ilmu-pemerintahan-s2',               'S2');

-- Pascasarjana — S3
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
(12, 'Ilmu Linguistik', 'ilmu-linguistik-s3', 'S3'),
(12, 'Entomologi',      'entomologi-s3',      'S3'),
(12, 'Teknik Sipil',    'teknik-sipil-s3',    'S3'),
(12, 'Arsitektur',      'arsitektur-s3',      'S3'),
(12, 'Ilmu Kelautan',   'ilmu-kelautan-s3',   'S3'),
(12, 'Ilmu Manajemen',  'ilmu-manajemen-s3',  'S3'),
(12, 'Ilmu Hukum',      'ilmu-hukum-s3',      'S3');

-- Pascasarjana — Profesi
INSERT INTO departments (faculty_id, name, slug, program_type) VALUES
(12, 'Profesi Insinyur', 'profesi-insinyur',       'Profesi'),
(12, 'Profesi Akuntan',  'profesi-akuntan',        'Profesi'),
(12, 'Profesi Apoteker', 'profesi-apoteker-pasca', 'Profesi');
