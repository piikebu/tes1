-- ============================================
-- Migration 006: Dummy staff seed
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM staff_community_service;
DELETE FROM staff_research;
DELETE FROM staff_publications;
DELETE FROM staff_grants;
DELETE FROM staff;

ALTER TABLE staff_community_service AUTO_INCREMENT = 1;
ALTER TABLE staff_research AUTO_INCREMENT = 1;
ALTER TABLE staff_publications AUTO_INCREMENT = 1;
ALTER TABLE staff_grants AUTO_INCREMENT = 1;
ALTER TABLE staff AUTO_INCREMENT = 1;
SET FOREIGN_KEY_CHECKS = 1;

-- Fakultas Teknik — dept 17 (Teknik Sipil), 22 (Teknik Informatika)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (17, '197801012006041001', '0001018001', 'Budi Santoso', 'budi-santoso', 'Dr.', 'M.T.', 'Dr. Budi Santoso, M.T.', 'Lektor Kepala', 'budi.santoso@unsrat.ac.id', 'Struktur Beton, Rekayasa Gempa');
SET @s1 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s1, 'Analisis Kerentanan Struktur Bangunan terhadap Gempa di Sulawesi Utara', 'Kemenristek Dikti', 'Ketua', 2022, 2023, 75000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s1, 'Perilaku Lentur Balok Beton Bertulang dengan Serat Bambu', 'journal', 'Jurnal Teknik Sipil', 2023, 'Budi Santoso, Eko Wahyudi', 'Nasional Terakreditasi', 'Terbit'),
(@s1, 'Seismic Vulnerability Assessment of Low-Rise Buildings in Manado', 'journal', 'Civil Engineering Journal', 2022, 'Budi Santoso', 'Internasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s1, 'Pemetaan Zona Rawan Gempa dan Dampaknya pada Infrastruktur Jalan', 'Budi Santoso, Eko Wahyudi', '2023-02-01', 'Nasional', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s1, 'Sosialisasi Konstruksi Bangunan Tahan Gempa bagi Masyarakat Amurang', 'Budi Santoso', '2023-09-10', 'Lokal', 'Selesai');

INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (22, '198505202010011002', '0020058502', 'Dewi Pramesti', 'dewi-pramesti', 'Dr.', 'M.Kom.', 'Dr. Dewi Pramesti, M.Kom.', 'Lektor', 'dewi.pramesti@unsrat.ac.id', 'Kecerdasan Buatan, Machine Learning');
SET @s2 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s2, 'Klasifikasi Penyakit Tanaman Menggunakan Deep Learning', 'LPPM UNSRAT', 'Ketua', 2023, 2024, 50000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s2, 'Deteksi Objek Real-Time dengan YOLO untuk Aplikasi Smart Farming', 'journal', 'Jurnal Ilmu Komputer dan Informasi', 2023, 'Dewi Pramesti', 'Nasional Terakreditasi', 'Terbit'),
(@s2, 'Sentiment Analysis of Local Government Services Using BERT', 'conference', 'International Conference on Information Technology', 2022, 'Dewi Pramesti, Agus Suryadi', 'Internasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s2, 'Pengembangan Sistem Rekomendasi Wisata Sulawesi Utara Berbasis Collaborative Filtering', 'Dewi Pramesti', '2023-04-15', 'Lokal', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s2, 'Pelatihan Literasi Digital bagi Pelaku UMKM Kota Manado', 'Dewi Pramesti', '2023-07-05', 'Lokal', 'Selesai');

-- Fakultas Ekonomi dan Bisnis — dept 42 (Manajemen), 43 (Akuntansi)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (42, '197603102005011003', '0010037601', 'Hendra Gunawan', 'hendra-gunawan', 'Prof. Dr.', 'M.Si.', 'Prof. Dr. Hendra Gunawan, M.Si.', 'Guru Besar', 'hendra.gunawan@unsrat.ac.id', 'Manajemen Strategik, Kewirausahaan');
SET @s3 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s3, 'Model Pengembangan UMKM Berbasis Inovasi di Sulawesi Utara', 'Kemenristek Dikti', 'Ketua', 2022, 2024, 120000000),
(@s3, 'Strategi Daya Saing Industri Pariwisata Pasca Pandemi', 'LPPM UNSRAT', 'Ketua', 2021, 2022, 60000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s3, 'Pengaruh Inovasi Produk terhadap Kinerja UMKM di Manado', 'journal', 'Jurnal Manajemen dan Bisnis', 2023, 'Hendra Gunawan', 'Nasional Terakreditasi', 'Terbit'),
(@s3, 'Corporate Governance and Firm Performance: Evidence from Indonesian SMEs', 'journal', 'Asian Journal of Business', 2022, 'Hendra Gunawan, Maya Putri', 'Internasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s3, 'Pemetaan Potensi Wirausaha Muda di Kawasan Timur Indonesia', 'Hendra Gunawan, Maya Putri', '2023-01-20', 'Nasional', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s3, 'Pendampingan Manajemen Keuangan bagi Koperasi di Kabupaten Minahasa', 'Hendra Gunawan', '2023-10-12', 'Lokal', 'Selesai');

INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (43, '198811252015042004', '0025118801', 'Maya Putri', 'maya-putri', 'Dr.', 'M.Ak.', 'Dr. Maya Putri, M.Ak.', 'Asisten Ahli', 'maya.putri@unsrat.ac.id', 'Akuntansi Publik, Audit');
SET @s4 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s4, 'Transparansi Laporan Keuangan Desa di Sulawesi Utara', 'LPPM UNSRAT', 'Ketua', 2023, 2024, 35000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s4, 'Kualitas Laporan Keuangan Pemerintah Daerah dan Opini Audit BPK', 'journal', 'Jurnal Akuntansi Pemerintah', 2023, 'Maya Putri', 'Nasional Terakreditasi', 'Terbit'),
(@s4, 'Pengaruh Kompetensi SDM dan Penerapan SAP terhadap Kualitas Laporan Keuangan', 'journal', 'Jurnal Riset Akuntansi', 2022, 'Maya Putri, Hendra Gunawan', 'Nasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s4, 'Analisis Penyerapan Anggaran dan Efisiensi Belanja Pemerintah Daerah', 'Maya Putri', '2023-06-01', 'Lokal', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s4, 'Pelatihan Penyusunan Laporan Keuangan Desa bagi Aparatur Desa Minahasa Selatan', 'Maya Putri', '2023-08-22', 'Lokal', 'Selesai');

-- Fakultas MIPA — dept 52 (Matematika), 55 (Sistem Informasi)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (52, '198002142008011005', '0014028001', 'Eko Wahyudi', 'eko-wahyudi', 'Dr.', 'M.Si.', 'Dr. Eko Wahyudi, M.Si.', 'Lektor', 'eko.wahyudi@unsrat.ac.id', 'Matematika Terapan, Persamaan Diferensial');
SET @s5 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s5, 'Model Matematika Penyebaran Penyakit Menular di Populasi Heterogen', 'Kemenristek Dikti', 'Ketua', 2022, 2023, 55000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s5, 'Analisis Kestabilan Model SIR dengan Laju Penularan Bervariasi', 'journal', 'Jurnal Matematika dan Aplikasinya', 2023, 'Eko Wahyudi', 'Nasional Terakreditasi', 'Terbit'),
(@s5, 'Numerical Solution of Fractional Differential Equations in Epidemic Modelling', 'journal', 'Applied Mathematics and Computation', 2022, 'Eko Wahyudi, Tono Widodo', 'Internasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s5, 'Pemodelan Optimasi Rute Distribusi Logistik Kebencanaan', 'Eko Wahyudi', '2023-03-10', 'Nasional', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s5, 'Workshop Statistika Dasar bagi Guru SMA di Tomohon', 'Eko Wahyudi', '2023-05-18', 'Lokal', 'Selesai');

-- Fakultas Ilmu Sosial dan Politik — dept 61 (Ilmu Komunikasi)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (61, '198708032012042006', '0003088701', 'Rina Kusuma', 'rina-kusuma', 'Dr.', 'M.I.Kom.', 'Dr. Rina Kusuma, M.I.Kom.', 'Lektor', 'rina.kusuma@unsrat.ac.id', 'Komunikasi Massa, Media Digital');
SET @s6 = LAST_INSERT_ID();
INSERT INTO staff_grants (staff_id, title, funder, role, year_start, year_end, amount) VALUES
(@s6, 'Penggunaan Media Sosial sebagai Sarana Kampanye Politik di Sulawesi Utara', 'LPPM UNSRAT', 'Ketua', 2023, 2024, 38000000);
INSERT INTO staff_publications (staff_id, title, type, journal_name, year, authors, level, status) VALUES
(@s6, 'Disinformasi Politik di Media Sosial: Studi Pemilihan Kepala Daerah', 'journal', 'Jurnal Komunikasi Indonesia', 2023, 'Rina Kusuma', 'Nasional Terakreditasi', 'Terbit'),
(@s6, 'Peran Jurnalisme Warga dalam Liputan Bencana Alam di Indonesia', 'journal', 'Jurnal Ilmu Komunikasi', 2022, 'Rina Kusuma, Galih Saputro', 'Nasional', 'Terbit');
INSERT INTO staff_research (staff_id, title, authors, research_date, level, status) VALUES
(@s6, 'Pola Konsumsi Berita Digital Generasi Z di Sulawesi Utara', 'Rina Kusuma', '2023-07-01', 'Lokal', 'Selesai');
INSERT INTO staff_community_service (staff_id, title, authors, service_date, level, status) VALUES
(@s6, 'Literasi Media dan Anti-Hoaks bagi Remaja di SMA Negeri Bitung', 'Rina Kusuma', '2023-11-05', 'Lokal', 'Selesai');

-- Fakultas Kedokteran — dept 1 (Pendidikan Dokter)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (1, '197501012003011001', '0001017501', 'Agus Purnomo', 'agus-purnomo', 'Dr.', 'Sp.PD.', 'Dr. Agus Purnomo, Sp.PD.', 'Lektor', 'agus.purnomo@unsrat.ac.id', 'Penyakit Dalam, Kardiologi');

-- Fakultas Pertanian — dept 26 (Agronomi)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (26, '197803022007011002', '0002037801', 'Bambang Setiawan', 'bambang-setiawan', 'Dr.', 'M.P.', 'Dr. Bambang Setiawan, M.P.', 'Lektor', 'bambang.setiawan@unsrat.ac.id', 'Agronomi, Fisiologi Tanaman');

-- Fakultas Peternakan — dept 34
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (34, '198104152009011003', '0015048101', 'Lina Wulandari', 'lina-wulandari', 'Dr.', 'M.Si.', 'Dr. Lina Wulandari, M.Si.', 'Lektor', 'lina.wulandari@unsrat.ac.id', 'Nutrisi Ternak, Peternakan');

-- Fakultas Perikanan dan Ilmu Kelautan — dept 35 (Manajemen Sumberdaya Perairan)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (35, '198606072013011004', '0007068601', 'Nanda Saputra', 'nanda-saputra', 'Dr.', 'M.Si.', 'Dr. Nanda Saputra, M.Si.', 'Asisten Ahli', 'nanda.saputra@unsrat.ac.id', 'Manajemen Sumberdaya Perairan');

-- Fakultas Kesehatan Masyarakat — dept 44
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (44, '198903122015042005', '0012038901', 'Fitri Andriani', 'fitri-andriani', 'S.KM.', 'M.Kes.', 'Fitri Andriani, S.KM., M.Kes.', 'Asisten Ahli', 'fitri.andriani@unsrat.ac.id', 'Epidemiologi, Kesehatan Masyarakat');

-- Fakultas Hukum — dept 45 (Ilmu Hukum)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (45, '197709202004011006', '0020097701', 'Rizal Mahendra', 'rizal-mahendra', 'Dr.', 'S.H., M.H.', 'Dr. Rizal Mahendra, S.H., M.H.', 'Lektor Kepala', 'rizal.mahendra@unsrat.ac.id', 'Hukum Pidana, Hukum Internasional');

-- Fakultas Ilmu Budaya — dept 46 (Sastra Indonesia)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (46, '198207112010042007', '0011078201', 'Nurul Azizah', 'nurul-azizah', 'Dr.', 'M.Hum.', 'Dr. Nurul Azizah, M.Hum.', 'Lektor', 'nurul.azizah@unsrat.ac.id', 'Sastra Indonesia, Linguistik');

-- Pascasarjana — dept 74 (Informatika S2)
INSERT INTO staff (department_id, nip, nidn, name, slug, front_title, back_title, full_title_name, position, email, expertise)
VALUES (74, '197502182001011008', '0018027501', 'Surya Darma', 'surya-darma', 'Prof. Dr.', 'M.T.', 'Prof. Dr. Surya Darma, M.T.', 'Guru Besar', 'surya.darma@unsrat.ac.id', 'Informatika, Sistem Terdistribusi');
