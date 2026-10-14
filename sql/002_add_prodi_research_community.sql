-- ============================================
-- Migration 002: Program Studi, Penelitian, Pengabdian Masyarakat
-- Adds: program_studi table, staff_research table,
--       staff_community_service table,
--       prodi_id FK on staff,
--       5 new columns on staff_publications
-- ============================================

CREATE TABLE IF NOT EXISTS program_studi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE staff
    ADD COLUMN prodi_id INT DEFAULT NULL,
    ADD CONSTRAINT fk_staff_prodi FOREIGN KEY (prodi_id) REFERENCES program_studi(id) ON DELETE SET NULL;

ALTER TABLE staff_grants
    ADD COLUMN document_path VARCHAR(500) DEFAULT NULL;

ALTER TABLE staff_publications
    ADD COLUMN group_of_knowledge VARCHAR(255) DEFAULT NULL,
    ADD COLUMN original_language  VARCHAR(100) DEFAULT NULL,
    ADD COLUMN level              VARCHAR(100) DEFAULT NULL COMMENT 'Nasional/Internasional',
    ADD COLUMN status             VARCHAR(100) DEFAULT NULL COMMENT 'Published/Submitted/Accepted',
    ADD COLUMN document_path      VARCHAR(500) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS staff_research (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    title VARCHAR(500) NOT NULL,
    authors TEXT DEFAULT NULL,
    research_date DATE DEFAULT NULL,
    abstract TEXT DEFAULT NULL,
    group_of_knowledge VARCHAR(255) DEFAULT NULL,
    original_language VARCHAR(100) DEFAULT NULL,
    level VARCHAR(100) DEFAULT NULL COMMENT 'Nasional/Internasional',
    status VARCHAR(100) DEFAULT NULL COMMENT 'Ongoing/Completed',
    document_path VARCHAR(500) DEFAULT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS staff_community_service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    title VARCHAR(500) NOT NULL,
    authors TEXT DEFAULT NULL,
    service_date DATE DEFAULT NULL,
    abstract TEXT DEFAULT NULL,
    group_of_knowledge VARCHAR(255) DEFAULT NULL,
    original_language VARCHAR(100) DEFAULT NULL,
    level VARCHAR(100) DEFAULT NULL COMMENT 'Lokal/Nasional/Internasional',
    status VARCHAR(100) DEFAULT NULL COMMENT 'Ongoing/Completed',
    document_path VARCHAR(500) DEFAULT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Seed: Program Studi
-- ============================================
INSERT INTO program_studi (department_id, name, slug) VALUES
(1,  'Pendidikan Dokter',  'pendidikan-dokter'),
(2,  'Bedah',              'bedah'),
(3,  'Penyakit Dalam',     'penyakit-dalam'),
(4,  'Teknik Elektro',     'teknik-elektro-s1'),
(5,  'Teknik Sipil',       'teknik-sipil-s1'),
(6,  'Teknik Informatika', 'teknik-informatika-s1'),
(6,  'Sistem Informasi',   'sistem-informasi'),
(7,  'Arsitektur',         'arsitektur-s1'),
(8,  'Agroteknologi',      'agroteknologi'),
(9,  'Agribisnis',         'agribisnis'),
(10, 'Matematika',         'matematika-s1'),
(11, 'Fisika',             'fisika-s1'),
(12, 'Biologi',            'biologi-s1'),
(13, 'Manajemen',          'manajemen-s1'),
(14, 'Akuntansi',          'akuntansi-s1'),
(15, 'Ilmu Komunikasi',    'ilmu-komunikasi-s1');
