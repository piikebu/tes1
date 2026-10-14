-- ============================================
-- Migration 005: Academic profile IDs
-- Adds Scopus, SINTA, Google Scholar columns
-- to staff table for manual input by dosen.
-- ============================================

ALTER TABLE staff
    ADD COLUMN scopus_id      VARCHAR(100) DEFAULT NULL,
    ADD COLUMN sinta_id       VARCHAR(100) DEFAULT NULL,
    ADD COLUMN google_scholar VARCHAR(255) DEFAULT NULL;
