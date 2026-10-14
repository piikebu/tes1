-- ============================================
-- Migration 003: Remove Unused Columns & Tables
-- Removes columns never rendered in the UI:
--   staff.rank, staff.phone, staff.photo
-- Drops tables whose data is never rendered:
--   staff_courses, staff_profiles
-- ============================================

-- Drop child tables first (they hold FK → staff, not the other way)
DROP TABLE IF EXISTS staff_courses;
DROP TABLE IF EXISTS staff_profiles;

-- Remove unused columns from staff
ALTER TABLE staff
    DROP COLUMN `rank`,
    DROP COLUMN phone,
    DROP COLUMN photo;
