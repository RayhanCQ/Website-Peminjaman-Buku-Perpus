CREATE DATABASE IF NOT EXISTS `perpus_db`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `perpus_db`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `peminjaman`;
DROP TABLE IF EXISTS `buku`;
DROP TABLE IF EXISTS `kategori_buku`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `nim` VARCHAR(30) NULL,
    `phone` VARCHAR(30) NULL,
    `address` TEXT NULL,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(20) NOT NULL DEFAULT 'user',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    UNIQUE KEY `users_nim_unique` (`nim`),
    KEY `users_role_index` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT NOT NULL,
    PRIMARY KEY (`key`),
    KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kategori_buku` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `kategori_buku_nama_unique` (`nama`),
    UNIQUE KEY `kategori_buku_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `buku` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kategori_buku_id` BIGINT UNSIGNED NULL,
    `judul` VARCHAR(255) NOT NULL,
    `penulis` VARCHAR(255) NOT NULL,
    `tahun_terbit` SMALLINT UNSIGNED NULL,
    `penerbit` VARCHAR(255) NULL,
    `isbn` VARCHAR(30) NULL,
    `sinopsis` TEXT NULL,
    `stok_total` INT UNSIGNED NOT NULL DEFAULT 0,
    `stok_tersedia` INT UNSIGNED NOT NULL DEFAULT 0,
    `lokasi_rak` VARCHAR(50) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    `deleted_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `buku_isbn_unique` (`isbn`),
    KEY `buku_kategori_buku_id_foreign` (`kategori_buku_id`),
    KEY `buku_judul_penulis_index` (`judul`, `penulis`),
    KEY `buku_stok_tersedia_index` (`stok_tersedia`),
    CONSTRAINT `buku_kategori_buku_id_foreign`
        FOREIGN KEY (`kategori_buku_id`) REFERENCES `kategori_buku` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `peminjaman` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `kode_peminjaman` VARCHAR(30) NOT NULL,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `buku_id` BIGINT UNSIGNED NOT NULL,
    `tanggal_pinjam` DATETIME NOT NULL,
    `tanggal_jatuh_tempo` DATETIME NOT NULL,
    `tanggal_kembali` DATETIME NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'dipinjam',
    `kondisi_kembali` TEXT NULL,
    `denda` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `peminjaman_kode_peminjaman_unique` (`kode_peminjaman`),
    KEY `peminjaman_status_index` (`status`),
    KEY `peminjaman_user_id_status_index` (`user_id`, `status`),
    KEY `peminjaman_buku_id_status_index` (`buku_id`, `status`),
    KEY `peminjaman_tanggal_jatuh_tempo_index` (`tanggal_jatuh_tempo`),
    CONSTRAINT `peminjaman_user_id_foreign`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `peminjaman_buku_id_foreign`
        FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users`
    (`id`, `name`, `email`, `nim`, `phone`, `address`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`)
VALUES
    (1, 'Admin Perpus', 'admin@perpus.local', NULL, NULL, NULL, NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/f.r.1FEzf3miUo', 'admin', NULL, NOW(), NOW()),
    (2, 'Chico Diar Ramadhan', 'chico@student.undip.ac.id', '21120124140150', NULL, NULL, NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/f.r.1FEzf3miUo', 'user', NULL, NOW(), NOW()),
    (3, 'Siti Aminah', 'siti.a@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/f.r.1FEzf3miUo', 'user', NULL, NOW(), NOW());

INSERT INTO `kategori_buku` (`id`, `nama`, `slug`, `created_at`, `updated_at`)
VALUES
    (1, 'Fiksi / Novel', 'fiksi-novel', NOW(), NOW()),
    (2, 'Pendidikan / Akademik', 'pendidikan-akademik', NOW(), NOW()),
    (3, 'Teknologi / Sains', 'teknologi-sains', NOW(), NOW()),
    (4, 'Sejarah', 'sejarah', NOW(), NOW()),
    (5, 'Pengembangan Diri', 'pengembangan-diri', NOW(), NOW());

INSERT INTO `buku`
    (`id`, `kategori_buku_id`, `judul`, `penulis`, `tahun_terbit`, `penerbit`, `isbn`, `sinopsis`, `stok_total`, `stok_tersedia`, `lokasi_rak`, `created_at`, `updated_at`, `deleted_at`)
VALUES
    (1, 2, 'Morfologi: Kajian Proses Pembentukan Kata', 'Prof. Dr. Drs. I Wayan Simpen, M.Hum.', 2021, NULL, NULL, 'Kajian proses pembentukan kata dalam bahasa Indonesia.', 3, 2, 'A-01', NOW(), NOW(), NULL),
    (2, 5, 'Atomic Habits', 'James Clear', 2018, NULL, NULL, 'Perubahan kecil yang memberikan hasil luar biasa.', 4, 3, 'B-02', NOW(), NOW(), NULL),
    (3, 3, 'Sistem Digital', 'Ronald J. Tocci', 2017, NULL, NULL, NULL, 2, 1, 'C-03', NOW(), NOW(), NULL),
    (4, 1, 'Bumi Manusia', 'Pramoedya Ananta Toer', 1980, NULL, NULL, NULL, 5, 5, 'D-01', NOW(), NOW(), NULL),
    (5, 1, 'Naruto Vol 1', 'Masashi Kishimoto', 1999, NULL, NULL, NULL, 1, 0, 'D-05', NOW(), NOW(), NULL);

INSERT INTO `peminjaman`
    (`id`, `kode_peminjaman`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_jatuh_tempo`, `tanggal_kembali`, `status`, `kondisi_kembali`, `denda`, `created_at`, `updated_at`)
VALUES
    (1, 'PJM-20260501-001', 2, 1, '2026-05-01 09:00:00', '2026-05-10 10:30:00', '2026-05-10 10:30:00', 'kembali', 'Baik', 0.00, NOW(), NOW()),
    (2, 'PJM-20260508-002', 2, 2, '2026-05-08 14:00:00', '2026-05-15 14:00:00', NULL, 'dipinjam', NULL, 0.00, NOW(), NOW()),
    (3, 'PJM-20260428-003', 3, 3, '2026-04-28 09:00:00', '2026-05-05 09:00:00', NULL, 'terlambat', NULL, 0.00, NOW(), NOW());
