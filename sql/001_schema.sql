-- ============================================
-- AcadStaff UNSRAT - Database Schema
-- ============================================

CREATE TABLE IF NOT EXISTS faculties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (faculty_id) REFERENCES faculties(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    nip VARCHAR(30) DEFAULT NULL,
    nidn VARCHAR(30) DEFAULT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    front_title VARCHAR(50) DEFAULT NULL,
    back_title VARCHAR(100) DEFAULT NULL,
    full_title_name VARCHAR(500) DEFAULT NULL,
    position VARCHAR(100) DEFAULT NULL COMMENT 'Jabatan Fungsional: Asisten Ahli, Lektor, Lektor Kepala, Guru Besar',
    `rank` VARCHAR(100) DEFAULT NULL COMMENT 'Pangkat/Golongan',
    email VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    photo VARCHAR(500) DEFAULT NULL,
    expertise VARCHAR(500) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Profile: staff isi sendiri
CREATE TABLE IF NOT EXISTS staff_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL UNIQUE,
    bio TEXT DEFAULT NULL,
    education TEXT DEFAULT NULL COMMENT 'JSON: [{degree, institution, year, field}]',
    research_interest TEXT DEFAULT NULL,
    website VARCHAR(500) DEFAULT NULL,
    google_scholar VARCHAR(500) DEFAULT NULL,
    scopus_id VARCHAR(100) DEFAULT NULL,
    orcid VARCHAR(50) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Course: tarik dari portal
CREATE TABLE IF NOT EXISTS staff_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    course_code VARCHAR(20) DEFAULT NULL,
    course_name VARCHAR(255) NOT NULL,
    semester VARCHAR(20) DEFAULT NULL COMMENT 'Ganjil/Genap',
    academic_year VARCHAR(20) DEFAULT NULL COMMENT '2024/2025',
    credits INT DEFAULT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Grant & Project: staff isi sendiri
CREATE TABLE IF NOT EXISTS staff_grants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    title VARCHAR(500) NOT NULL,
    funder VARCHAR(255) DEFAULT NULL,
    role VARCHAR(100) DEFAULT NULL COMMENT 'Ketua/Anggota',
    year_start YEAR DEFAULT NULL,
    year_end YEAR DEFAULT NULL,
    amount DECIMAL(15,2) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Research & Publication: staff isi sendiri
CREATE TABLE IF NOT EXISTS staff_publications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    title VARCHAR(500) NOT NULL,
    type ENUM('journal', 'conference', 'book', 'book_chapter', 'other') DEFAULT 'journal',
    journal_name VARCHAR(255) DEFAULT NULL,
    year YEAR DEFAULT NULL,
    volume VARCHAR(50) DEFAULT NULL,
    pages VARCHAR(50) DEFAULT NULL,
    doi VARCHAR(255) DEFAULT NULL,
    url VARCHAR(500) DEFAULT NULL,
    authors TEXT DEFAULT NULL,
    abstract TEXT DEFAULT NULL,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- DUMMY DATA
-- ============================================

INSERT INTO faculties (name, slug, icon) VALUES
('Fakultas Kedokteran', 'kedokteran', 'fa-heartbeat'),
('Fakultas Teknik', 'teknik', 'fa-cogs'),
('Fakultas Pertanian', 'pertanian', 'fa-leaf'),
('Fakultas Peternakan', 'peternakan', 'fa-paw'),
('Fakultas Perikanan dan Ilmu Kelautan', 'perikanan', 'fa-water'),
('Fakultas Ekonomi dan Bisnis', 'ekonomi-bisnis', 'fa-chart-line'),
('Fakultas Hukum', 'hukum', 'fa-balance-scale'),
('Fakultas MIPA', 'mipa', 'fa-flask'),
('Fakultas Sastra', 'sastra', 'fa-book'),
('Fakultas Ilmu Sosial dan Politik', 'fisip', 'fa-users'),
('Fakultas Kesehatan Masyarakat', 'fkm', 'fa-medkit');

INSERT INTO departments (faculty_id, name, slug) VALUES
(1, 'Ilmu Kedokteran Dasar', 'ilmu-kedokteran-dasar'),
(1, 'Ilmu Bedah', 'ilmu-bedah'),
(1, 'Ilmu Penyakit Dalam', 'ilmu-penyakit-dalam'),
(2, 'Teknik Elektro', 'teknik-elektro'),
(2, 'Teknik Sipil', 'teknik-sipil'),
(2, 'Teknik Informatika', 'teknik-informatika'),
(2, 'Arsitektur', 'arsitektur'),
(3, 'Agronomi', 'agronomi'),
(3, 'Sosial Ekonomi Pertanian', 'sosek-pertanian'),
(8, 'Matematika', 'matematika'),
(8, 'Fisika', 'fisika'),
(8, 'Biologi', 'biologi'),
(6, 'Manajemen', 'manajemen'),
(6, 'Akuntansi', 'akuntansi'),
(10, 'Ilmu Komunikasi', 'ilmu-komunikasi');

INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, photo, expertise) VALUES
(6, '199001011020011001', '0001019001', 'James Thornton', 'james-thornton', 'Dr.', 'S.Kom., M.Cs.', 'Dr. James Thornton, S.Kom., M.Cs.', 'Lektor Kepala', 'james.thornton@example.ac.id', NULL, 'Artificial Intelligence, Machine Learning'),
(6, '199203152012012001', '0015039201', 'Clara Whitfield', 'clara-whitfield', NULL, 'S.Kom., M.Sc.', 'Clara Whitfield, S.Kom., M.Sc.', 'Lektor', 'clara.whitfield@example.ac.id', NULL, 'Software Engineering, Information Systems'),
(6, '198505202005011002', '0020058502', 'Marcus Bell', 'marcus-bell', 'Dr.', 'S.T., M.T.', 'Dr. Marcus Bell, S.T., M.T.', 'Lektor Kepala', 'marcus.bell@example.ac.id', NULL, 'Network Security, IoT'),
(4, '198806102008011001', '0010068801', 'Oliver Grant', 'oliver-grant', NULL, 'S.T., M.T.', 'Oliver Grant, S.T., M.T.', 'Lektor', 'oliver.grant@example.ac.id', NULL, 'Electrical Engineering, Control Systems'),
(5, '198012302003121001', '0030128001', 'Nathan Cross', 'nathan-cross', 'Ir.', 'M.T.', 'Ir. Nathan Cross, M.T.', 'Lektor Kepala', 'nathan.cross@example.ac.id', NULL, 'Structural Engineering'),
(1, '197008151994031001', '0015087001', 'Edward Blackwell', 'edward-blackwell', 'Prof. Dr.', 'M.Sc., Sp.FK.', 'Prof. Dr. Edward Blackwell, M.Sc., Sp.FK.', 'Guru Besar', 'edward.blackwell@example.ac.id', NULL, 'Pharmacology, Clinical Pharmacology'),
(1, '198001012000032001', '0001018001', 'Helen Carver', 'helen-carver', 'Dr.', 'M.Kes.', 'Dr. Helen Carver, M.Kes.', 'Lektor Kepala', 'helen.carver@example.ac.id', NULL, 'Biochemistry, Molecular Biology'),
(8, '198510102005011001', '0010108501', 'Patrick Sawyer', 'patrick-sawyer', 'Dr.', 'S.Si., M.Si.', 'Dr. Patrick Sawyer, S.Si., M.Si.', 'Lektor', 'patrick.sawyer@example.ac.id', NULL, 'Agronomy, Plant Physiology'),
(10, '199005202010012001', '0020059001', 'Lucy Barton', 'lucy-barton', NULL, 'S.Si., M.Si.', 'Lucy Barton, S.Si., M.Si.', 'Asisten Ahli', 'lucy.barton@example.ac.id', NULL, 'Mathematics, Statistics'),
(13, '198209252003122001', '0025098201', 'Victor Crane', 'victor-crane', 'Dr.', 'S.E., M.Si.', 'Dr. Victor Crane, S.E., M.Si.', 'Lektor Kepala', 'victor.crane@example.ac.id', NULL, 'Management, Marketing'),
(14, '199212012015041001', '0001129201', 'George Harlow', 'george-harlow', NULL, 'S.E., M.Ak.', 'George Harlow, S.E., M.Ak.', 'Lektor', 'george.harlow@example.ac.id', NULL, 'Accounting, Auditing'),
(15, '199303152018012001', '0015039301', 'Sophie Mercer', 'sophie-mercer', NULL, 'S.Sos., M.I.Kom.', 'Sophie Mercer, S.Sos., M.I.Kom.', 'Asisten Ahli', 'sophie.mercer@example.ac.id', NULL, 'Communication Studies, Media');

-- Staff Profiles
INSERT INTO staff_profiles (staff_id, bio, education, research_interest, google_scholar, orcid) VALUES
(1, 'Lecturer active in artificial intelligence and machine learning research. Over 15 years of academic experience.', '[{"degree":"S3","institution":"Example University A","year":"2015","field":"Informatika"},{"degree":"S2","institution":"Example University B","year":"2010","field":"Ilmu Komputer"},{"degree":"S1","institution":"Example University C","year":"2007","field":"Teknik Informatika"}]', 'Deep Learning, Natural Language Processing, Computer Vision', 'https://scholar.google.com/citations?user=example1', '0000-0001-0000-0001'),
(2, 'Junior lecturer focused on software development and information systems.', '[{"degree":"S2","institution":"Example University D","year":"2014","field":"Software Engineering"},{"degree":"S1","institution":"Example University C","year":"2009","field":"Teknik Informatika"}]', 'Agile Development, Cloud Computing', NULL, NULL),
(6, 'Professor of Pharmacology with over 25 years of active clinical pharmacology research.', '[{"degree":"S3","institution":"Example University E","year":"2000","field":"Farmakologi"},{"degree":"S2","institution":"Example University B","year":"1995","field":"Ilmu Kedokteran"},{"degree":"S1","institution":"Example University C","year":"1990","field":"Kedokteran"}]', 'Drug Interaction, Pharmacokinetics, Traditional Medicine', 'https://scholar.google.com/citations?user=example6', '0000-0006-0000-0006');

-- Courses
INSERT INTO staff_courses (staff_id, course_code, course_name, semester, academic_year, credits) VALUES
(1, 'INF101', 'Algoritma dan Pemrograman', 'Ganjil', '2025/2026', 3),
(1, 'INF301', 'Kecerdasan Buatan', 'Ganjil', '2025/2026', 3),
(1, 'INF401', 'Machine Learning', 'Genap', '2025/2026', 3),
(2, 'INF201', 'Rekayasa Perangkat Lunak', 'Ganjil', '2025/2026', 3),
(2, 'INF302', 'Basis Data Lanjut', 'Genap', '2025/2026', 3),
(3, 'INF303', 'Keamanan Jaringan', 'Ganjil', '2025/2026', 3),
(3, 'INF402', 'Internet of Things', 'Genap', '2025/2026', 3),
(6, 'KED201', 'Farmakologi Dasar', 'Ganjil', '2025/2026', 4),
(6, 'KED301', 'Farmakologi Klinis', 'Genap', '2025/2026', 4);

-- Grants
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount, description) VALUES
(1, 'Deep Learning Model for Agricultural Pest Detection', 'Example Ministry', 'Ketua', 2024, 2026, 150000000, 'Applied research using CNN for pest detection'),
(1, 'IoT-Based Smart Campus System', 'Example University', 'Anggota', 2025, 2026, 75000000, 'Smart campus monitoring system development'),
(6, 'Pharmacogenomic Study on Local Population', 'Example Research Institute', 'Ketua', 2023, 2026, 500000000, 'Basic pharmacogenomics research'),
(3, 'Blockchain for Health Data Security', 'Example Ministry', 'Ketua', 2025, 2027, 200000000, 'Medical record security system research');

-- Publications
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, volume, pages, doi, authors) VALUES
(1, 'Deep Learning Approach for Plant Pest Detection', 'journal', 'Journal of Example Informatics', 2025, '12(1)', '45-58', '10.1234/jei.2025.001', 'Thornton, J., Bell, M., Whitfield, C.'),
(1, 'Hybrid CNN-LSTM Model for Text Classification', 'conference', 'Proc. International Conference on ICT', 2024, NULL, '112-119', '10.1234/icict.2024.015', 'Thornton, J., Grant, O.'),
(6, 'Pharmacogenomic Profile of Local Population Study', 'journal', 'Journal of Tropical Medicine Example', 2025, '56(2)', '234-248', '10.1234/jtme.2025.034', 'Blackwell, E., Carver, H.'),
(3, 'Blockchain-Based Electronic Health Record Security Framework', 'journal', 'International Journal of Example Security', 2025, '25(3)', '401-415', '10.1234/ijes.2025.089', 'Bell, M., Thornton, J.'),
(2, 'Agile Methodology Adoption in Higher Education Software Projects', 'conference', 'Proc. Example Conference', 2024, NULL, '88-95', NULL, 'Whitfield, C., Thornton, J.');
