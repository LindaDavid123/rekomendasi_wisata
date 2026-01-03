-- Fix users table - add missing 'nama' column if not exists

USE rekomendasi_wisata;

-- Check and add nama column if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS nama VARCHAR(100) NOT NULL AFTER password;

-- If the above doesn't work in your MySQL version, try this:
-- First check if column exists, if not, add it
-- ALTER TABLE users ADD COLUMN nama VARCHAR(100) NOT NULL AFTER password;

-- You can also update existing users with username as nama if needed:
-- UPDATE users SET nama = username WHERE nama IS NULL OR nama = '';
