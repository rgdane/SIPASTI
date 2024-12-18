-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2024 at 03:11 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipasti`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_certification` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(certification_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_certification
                WHERE certification_id LIKE CONCAT("CRT", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CRT", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_certification_type` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(certification_type_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_certification_type
                WHERE certification_type_id LIKE CONCAT("CTP", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CTP", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_certification_vendor` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(certification_vendor_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_certification_vendor
                WHERE certification_vendor_id LIKE CONCAT("CVD", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CVD", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_course` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(course_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_course
                WHERE course_id LIKE CONCAT("CRS", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CRS", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_course_certification` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(course_certification_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_course_certification
                WHERE course_certification_id LIKE CONCAT("CRC", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CRC", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_course_member` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(course_member_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_course_member
                WHERE course_member_id LIKE CONCAT("CRM", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CRM", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_course_training` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(course_training_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_course_training
                WHERE course_training_id LIKE CONCAT("CTR", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("CTR", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_interest` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(interest_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_interest
                WHERE interest_id LIKE CONCAT("INT", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("INT", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_interest_certification` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(interest_certification_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_interest_certification
                WHERE interest_certification_id LIKE CONCAT("INC", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("INC", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_interest_member` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(interest_member_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_interest_member
                WHERE interest_member_id LIKE CONCAT("INM", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("INM", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_interest_training` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(interest_training_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_interest_training
                WHERE interest_training_id LIKE CONCAT("INT", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("INT", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_period` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(period_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_period
                WHERE period_id LIKE CONCAT("PRD", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("PRD", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_training` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(training_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_training
                WHERE training_id LIKE CONCAT("TRN", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("TRN", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_training_member` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(training_member_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM t_training_member
                WHERE training_member_id LIKE CONCAT("TMB", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("TMB", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_training_vendor` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(training_vendor_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_training_vendor
                WHERE training_vendor_id LIKE CONCAT("TVD", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("TVD", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_user` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(user_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_user
                WHERE user_id LIKE CONCAT("USR", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("USR", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_user_detail` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(user_detail_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_user_detail
                WHERE user_detail_id LIKE CONCAT("UDT", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("UDT", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `generate_id_user_type` () RETURNS VARCHAR(20) CHARSET utf8mb4 DETERMINISTIC BEGIN
                DECLARE var_year VARCHAR(4);
                DECLARE var_month VARCHAR(2);
                DECLARE var_day VARCHAR(2);
                DECLARE last_sequence INT DEFAULT 0;
                DECLARE new_sequence VARCHAR(4);
                DECLARE new_id VARCHAR(20);

                -- Mengambil nilai tahun, bulan, dan hari saat ini
                SET var_year = YEAR(NOW());
                SET var_month = LPAD(MONTH(NOW()), 2, "0"); -- Menambahkan padding nol di depan bulan jika hanya satu digit
                SET var_day = LPAD(DAY(NOW()), 2, "0");     -- Menambahkan padding nol di depan hari jika hanya satu digit

                -- Membuat query untuk mengambil nilai ID terakhir
                SELECT COALESCE(MAX(CAST(SUBSTRING(user_type_id, 12, 4) AS UNSIGNED)), 0) INTO last_sequence
                FROM m_user_type
                WHERE user_type_id LIKE CONCAT("UTP", var_year, var_month, var_day, "%");

                -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
                SET new_sequence = LPAD(last_sequence + 1, 4, "0");

                -- Menggabungkan semua bagian menjadi new_id
                SET new_id = CONCAT("UTP", var_year, var_month, var_day, new_sequence);

                RETURN new_id;
            END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tmp_ems_so_193` (`arg_table_code` VARCHAR(3)) RETURNS VARCHAR(255) CHARSET utf8mb4 DETERMINISTIC BEGIN
    DECLARE var_id VARCHAR(255);
    DECLARE var_year VARCHAR(4);
    DECLARE var_month VARCHAR(2);
    DECLARE var_day VARCHAR(2);
    DECLARE last_sequence INT DEFAULT 0;
    DECLARE new_sequence VARCHAR(4);

    -- Mengambil nilai tahun, bulan, dan hari saat ini
    SET var_year = YEAR(NOW());
    SET var_month = LPAD(MONTH(NOW()), 2, '0'); -- Menambahkan padding nol di depan bulan jika hanya satu digit
    SET var_day = LPAD(DAY(NOW()), 2, '0');     -- Menambahkan padding nol di depan hari jika hanya satu digit

    -- Mengambil nilai ID terakhir dari tabel yang memiliki awalan sama dengan arg_table_code
    SELECT COALESCE(MAX(CAST(SUBSTRING(id_column, 12, 4) AS UNSIGNED)), 0)
    INTO last_sequence
    FROM your_table
    WHERE id_column LIKE CONCAT(arg_table_code, var_year, var_month, var_day, '%');

    -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
    SET new_sequence = LPAD(last_sequence + 1, 4, '0');

    -- Menggabungkan semua bagian menjadi var_id
    SET var_id = CONCAT(arg_table_code, var_year, var_month, var_day, new_sequence);

    RETURN var_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tmp_ems_so_194` (`arg_table_code` VARCHAR(3)) RETURNS VARCHAR(255) CHARSET utf8mb4 DETERMINISTIC BEGIN
    DECLARE var_id VARCHAR(255);
    DECLARE var_year VARCHAR(4);
    DECLARE var_month VARCHAR(2);
    DECLARE var_day VARCHAR(2);
    DECLARE last_sequence INT DEFAULT 0;
    DECLARE new_sequence VARCHAR(4);

    -- Mengambil nilai tahun, bulan, dan hari saat ini
    SET var_year = YEAR(NOW());
    SET var_month = LPAD(MONTH(NOW()), 2, '0'); -- Menambahkan padding nol di depan bulan jika hanya satu digit
    SET var_day = LPAD(DAY(NOW()), 2, '0');     -- Menambahkan padding nol di depan hari jika hanya satu digit

    -- Mengambil nilai ID terakhir dari tabel yang memiliki awalan sama dengan arg_table_code
    SELECT COALESCE(MAX(CAST(SUBSTRING(id_column, 12, 4) AS UNSIGNED)), 0)
    INTO last_sequence
    FROM your_table
    WHERE id_column LIKE CONCAT(arg_table_code, var_year, var_month, var_day, '%');

    -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
    SET new_sequence = LPAD(last_sequence + 1, 4, '0');

    -- Menggabungkan semua bagian menjadi var_id
    SET var_id = CONCAT(arg_table_code, var_year, var_month, var_day, new_sequence);

    RETURN var_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_11_06_071225_create_m_certification_table', 0),
(2, '2024_11_06_071225_create_m_certification_type_table', 0),
(3, '2024_11_06_071225_create_m_certification_vendor_table', 0),
(4, '2024_11_06_071225_create_m_course_table', 0),
(5, '2024_11_06_071225_create_m_interest_table', 0),
(6, '2024_11_06_071225_create_m_training_table', 0),
(7, '2024_11_06_071225_create_m_training_type_table', 0),
(8, '2024_11_06_071225_create_m_training_vendor_table', 0),
(9, '2024_11_06_071225_create_m_user_table', 0),
(10, '2024_11_06_071225_create_m_user_detail_table', 0),
(11, '2024_11_06_071225_create_m_user_type_table', 0),
(12, '2024_11_06_071225_create_t_course_member_table', 0),
(13, '2024_11_06_071225_create_t_interest_member_table', 0),
(14, '2024_11_06_071225_create_t_training_member_table', 0),
(15, '2024_11_06_071227_create_generate_id_proc', 0),
(16, '2024_11_06_071228_add_foreign_keys_to_m_certification_table', 0),
(17, '2024_11_06_071228_add_foreign_keys_to_m_training_table', 0),
(18, '2024_11_06_071228_add_foreign_keys_to_m_user_table', 0),
(19, '2024_11_06_071228_add_foreign_keys_to_m_user_detail_table', 0),
(20, '2024_11_06_071228_add_foreign_keys_to_t_course_member_table', 0),
(21, '2024_11_06_071228_add_foreign_keys_to_t_interest_member_table', 0),
(22, '2024_11_06_071228_add_foreign_keys_to_t_training_member_table', 0),
(23, '2014_10_12_000000_create_users_table', 1),
(24, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(25, '2019_08_19_000000_create_failed_jobs_table', 1),
(26, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(27, '2024_11_09_231555_add_update_at_user_type', 1),
(28, '2024_11_10_023626_create_failed_jobs_table', 0),
(29, '2024_11_10_023626_create_m_certification_table', 0),
(30, '2024_11_10_023626_create_m_certification_type_table', 0),
(31, '2024_11_10_023626_create_m_certification_vendor_table', 0),
(32, '2024_11_10_023626_create_m_course_table', 0),
(33, '2024_11_10_023626_create_m_interest_table', 0),
(34, '2024_11_10_023626_create_m_training_table', 0),
(35, '2024_11_10_023626_create_m_training_type_table', 0),
(36, '2024_11_10_023626_create_m_training_vendor_table', 0),
(37, '2024_11_10_023626_create_m_user_table', 0),
(38, '2024_11_10_023626_create_m_user_detail_table', 0),
(39, '2024_11_10_023626_create_m_user_type_table', 0),
(40, '2024_11_10_023626_create_password_reset_tokens_table', 0),
(41, '2024_11_10_023626_create_personal_access_tokens_table', 0),
(42, '2024_11_10_023626_create_t_course_member_table', 0),
(43, '2024_11_10_023626_create_t_interest_member_table', 0),
(44, '2024_11_10_023626_create_t_training_member_table', 0),
(45, '2024_11_10_023626_create_users_table', 0),
(46, '2024_11_10_023629_add_foreign_keys_to_m_certification_table', 0),
(47, '2024_11_10_023629_add_foreign_keys_to_m_training_table', 0),
(48, '2024_11_10_023629_add_foreign_keys_to_m_user_table', 0),
(49, '2024_11_10_023629_add_foreign_keys_to_m_user_detail_table', 0),
(50, '2024_11_10_023629_add_foreign_keys_to_t_course_member_table', 0),
(51, '2024_11_10_023629_add_foreign_keys_to_t_interest_member_table', 0),
(52, '2024_11_10_023629_add_foreign_keys_to_t_training_member_table', 0),
(53, '2024_11_10_135214_add_update_at_user', 2),
(54, '2024_11_13_051229_add_update_at_certification_type', 3),
(55, '2024_11_13_060727_add_generate_id_certification_type_function', 4),
(56, '2024_11_13_061143_add_generate_id_user_type_function', 5),
(57, '2024_11_13_061250_add_generate_id_user_function', 6),
(58, '2024_11_13_061358_add_before_insert_certification_type_trigger', 7),
(59, '2024_11_13_061450_add_before_insert_user_trigger', 7),
(60, '2024_11_13_061540_add_before_insert_user_type_trigger', 7),
(61, '2024_11_15_185333_add_update_at_certification_vendor', 7),
(65, '2024_11_15_193556_add_generate_id_certification_vendor_function', 8),
(66, '2024_11_15_193830_add_before_insert_certification_vendor_trigger', 8),
(67, '2024_11_16_023452_add_generate_id_certification_function', 9),
(68, '2024_11_16_023619_add_before_insert_certification_trigger', 10),
(69, '2024_11_23_143338_add_updated_at_user_detail', 11),
(70, '2024_11_30_040317_add_updated_at_t_course_certification', 12),
(71, '2024_11_30_044700_add_updated_at_t_interest_certification', 13),
(72, '2024_12_01_001556_add_updated_at_m_course', 14),
(73, '2024_12_01_032430_add_updated_at_m_training', 15),
(74, '2024_12_03_061745_add_update_at_t_training_member', 16);

-- --------------------------------------------------------

--
-- Table structure for table `m_certification`
--

CREATE TABLE `m_certification` (
  `certification_id` varchar(255) NOT NULL,
  `certification_name` varchar(255) DEFAULT NULL,
  `certification_number` varchar(255) DEFAULT NULL,
  `certification_date_start` date DEFAULT NULL,
  `certification_date_expired` date DEFAULT NULL,
  `period_id` varchar(20) DEFAULT NULL,
  `certification_vendor_id` varchar(255) DEFAULT NULL,
  `certification_level` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '0 = Nasional\r\n1 = Internasional',
  `certification_type` enum('0','1') DEFAULT NULL COMMENT '0 = Profesi\r\n1 = Keahlian',
  `user_id` varchar(255) DEFAULT NULL,
  `certification_file` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_certification`
--

INSERT INTO `m_certification` (`certification_id`, `certification_name`, `certification_number`, `certification_date_start`, `certification_date_expired`, `period_id`, `certification_vendor_id`, `certification_level`, `certification_type`, `user_id`, `certification_file`, `created_at`, `updated_at`) VALUES
('CRT202411300004', 'Sertifikasi Data Mining', 'S001201202', '2024-11-30', '2027-11-30', 'PRD202411300001', 'CVD202411160002', '1', '1', 'USR202411290001', 'uploads/certification/1732956365_sertifikat_course_251_3002395_120723165236.pdf', '2024-11-29 21:58:46', '2024-11-30 01:46:23'),
('CRT202411300005', 'Cloud Computing', 'S001201205', '2024-11-30', '2027-11-30', 'PRD202411300001', 'CVD202411160001', '1', '1', 'USR202411240001', 'uploads/certification/1732956163_sertifikat_course_251_3002395_120723165236.pdf', '2024-11-30 01:42:43', '2024-11-30 01:42:43');

--
-- Triggers `m_certification`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_certification` BEFORE INSERT ON `m_certification` FOR EACH ROW BEGIN
                IF NEW.certification_id IS NULL OR NEW.certification_id = "" THEN
                    SET NEW.certification_id = generate_id_certification();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_certification_type`
--

CREATE TABLE `m_certification_type` (
  `certification_type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certification_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `certification_type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_certification_type`
--

INSERT INTO `m_certification_type` (`certification_type_id`, `certification_type_code`, `certification_type_name`, `created_at`, `updated_at`) VALUES
('CTP202411130001', 'ISN', 'Internasional', '2024-11-12 22:22:34', '2024-11-12 22:22:34'),
('CTP202411130006', 'NISN', 'Nasional', '2024-11-12 22:39:50', '2024-11-12 22:39:50');

--
-- Triggers `m_certification_type`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_certification_type` BEFORE INSERT ON `m_certification_type` FOR EACH ROW BEGIN
                IF NEW.certification_type_id IS NULL OR NEW.certification_type_id = "" THEN
                    SET NEW.certification_type_id = generate_id_certification_type();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_certification_vendor`
--

CREATE TABLE `m_certification_vendor` (
  `certification_vendor_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certification_vendor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `certification_vendor_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `certification_vendor_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `certification_vendor_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `certification_vendor_web` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_certification_vendor`
--

INSERT INTO `m_certification_vendor` (`certification_vendor_id`, `certification_vendor_name`, `certification_vendor_address`, `certification_vendor_city`, `certification_vendor_phone`, `certification_vendor_web`, `created_at`, `updated_at`) VALUES
('CVD202411160001', 'PT Merdeka', 'Jl.Sekolahan', 'Malang', '08970852650', 'https://www.merdeka.com', '2024-11-15 12:07:12', '2024-11-15 12:07:12'),
('CVD202411160002', 'PT Paros', 'Jl.Mawar', 'Bogor', '08970823123', 'https://www.paros.com', '2024-11-15 12:28:48', NULL),
('CVD202411160003', 'PT Nestle', 'Jl.Anggur', 'Depok', '08970824343', 'https://www.nestle.com', '2024-11-15 12:28:48', NULL);

--
-- Triggers `m_certification_vendor`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_certification_vendor` BEFORE INSERT ON `m_certification_vendor` FOR EACH ROW BEGIN
                IF NEW.certification_vendor_id IS NULL OR NEW.certification_vendor_id = "" THEN
                    SET NEW.certification_vendor_id = generate_id_certification_vendor();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_course`
--

CREATE TABLE `m_course` (
  `course_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `course_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `course_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_course`
--

INSERT INTO `m_course` (`course_id`, `course_code`, `course_name`, `created_at`, `updated_at`) VALUES
('CRS202411190001', 'PWL', 'Pemrograman Web Lanjut', NULL, NULL),
('CRS202411190002', 'WRK', 'Workshop', NULL, NULL),
('CRS202412010001', 'AUS', 'Audit Sistem Informasi', '2024-11-30 17:28:48', NULL),
('CRS202412010002', 'MPN', 'Metodologi Penelitian', '2024-11-30 17:28:48', NULL);

--
-- Triggers `m_course`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_course` BEFORE INSERT ON `m_course` FOR EACH ROW BEGIN
                IF NEW.course_id IS NULL OR NEW.course_id = "" THEN
                    SET NEW.course_id = generate_id_course();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_interest`
--

CREATE TABLE `m_interest` (
  `interest_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `interest_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `interest_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_interest`
--

INSERT INTO `m_interest` (`interest_id`, `interest_code`, `interest_name`, `created_at`, `updated_at`) VALUES
('INT202411200001', 'PWB', 'Pemrograman Web', NULL, NULL),
('INT202411200002', 'PHP', 'Bahasa Pemograman PHP', NULL, NULL);

--
-- Triggers `m_interest`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_interest` BEFORE INSERT ON `m_interest` FOR EACH ROW BEGIN
                IF NEW.interest_id IS NULL OR NEW.interest_id = "" THEN
                    SET NEW.interest_id = generate_id_interest();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_period`
--

CREATE TABLE `m_period` (
  `period_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `period_year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_period`
--

INSERT INTO `m_period` (`period_id`, `period_year`) VALUES
('PRD202411300001', '2024');

--
-- Triggers `m_period`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_period_new` BEFORE INSERT ON `m_period` FOR EACH ROW BEGIN
                IF NEW.period_id IS NULL OR NEW.period_id = "" THEN
                    SET NEW.period_id = generate_id_period();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_training`
--

CREATE TABLE `m_training` (
  `training_id` varchar(255) NOT NULL,
  `training_name` varchar(255) DEFAULT NULL,
  `period_id` varchar(20) DEFAULT NULL,
  `training_date` date DEFAULT NULL,
  `training_hours` int DEFAULT NULL,
  `training_location` varchar(255) DEFAULT NULL,
  `training_cost` int NOT NULL,
  `training_vendor_id` varchar(255) DEFAULT NULL,
  `training_level` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '0 = Nasional\r\n1 = Internasional',
  `training_quota` int DEFAULT NULL,
  `training_status` enum('0','1','2','3','4') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0' COMMENT '0 = Pending\r\n1 = Pengajuan\r\n2 = Ditolak\r\n3 = Disetujui\r\n4 = Selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_training`
--

INSERT INTO `m_training` (`training_id`, `training_name`, `period_id`, `training_date`, `training_hours`, `training_location`, `training_cost`, `training_vendor_id`, `training_level`, `training_quota`, `training_status`, `created_at`, `updated_at`) VALUES
('TRN202412030002', 'Pelatihan Android Development', 'PRD202411300001', '2025-01-15', 48, 'Bogor', 200000, 'TVD202412010001', '0', 3, '3', '2024-12-02 23:19:20', '2024-12-04 15:52:49');

--
-- Triggers `m_training`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_training` BEFORE INSERT ON `m_training` FOR EACH ROW BEGIN
                IF NEW.training_id IS NULL OR NEW.training_id = "" THEN
                    SET NEW.training_id = generate_id_training();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_training_type`
--

CREATE TABLE `m_training_type` (
  `tarining_type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tarining_type_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tarining_type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `m_training_vendor`
--

CREATE TABLE `m_training_vendor` (
  `training_vendor_id` varchar(255) NOT NULL,
  `training_vendor_name` varchar(255) DEFAULT NULL,
  `training_vendor_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `training_vendor_city` varchar(255) DEFAULT NULL,
  `training_vendor_phone` varchar(255) DEFAULT NULL,
  `training_vendor_web` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_training_vendor`
--

INSERT INTO `m_training_vendor` (`training_vendor_id`, `training_vendor_name`, `training_vendor_address`, `training_vendor_city`, `training_vendor_phone`, `training_vendor_web`, `created_at`, `updated_at`) VALUES
('TVD202412010001', 'PT. Samsung Electronics', 'Jl. Mundur Sedikit', 'Malang', '089231312731', 'https://www.samsung.com', '2024-11-30 20:57:38', '2024-11-30 20:58:05'),
('TVD202412010002', 'PT Paros', 'Jl.Mawar', 'Bogor', '08970823123', 'https://www.paros.com', '2024-11-30 21:02:05', NULL),
('TVD202412010003', 'PT Nestle', 'Jl.Anggur', 'Depok', '08970824343', 'https://www.nestle.com', '2024-11-30 21:02:05', NULL);

--
-- Triggers `m_training_vendor`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_training_vendor` BEFORE INSERT ON `m_training_vendor` FOR EACH ROW BEGIN
                IF NEW.training_vendor_id IS NULL OR NEW.training_vendor_id = "" THEN
                    SET NEW.training_vendor_id = generate_id_training_vendor();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`user_id`, `user_fullname`, `username`, `password`, `user_type_id`, `created_at`, `updated_at`) VALUES
('USR202411110001', 'Rega Dane', 'dane', '$2y$12$FjvgITv88nBVfvTtj6Q5WOnZAJj7jVQZxU8RDTURiHhGiXfu/Ov3W', 'UTP202401300001', '2024-11-10 12:41:27', '2024-11-24 04:30:19'),
('USR202411240001', 'Najwa Lula', 'lula', '$2y$12$xvChQE5QgHIeo11YZwUpOOa0.mx3k1lmjp4S9JVCXzHM2PP9qqJxm', 'UTP202411100002', '2024-11-24 04:21:14', '2024-12-03 14:59:34'),
('USR202411290001', 'Agung Nugroho', 'agung', '$2y$12$w8MCRUAXogdHY1WjgNgzM.eDD053uOwMp.wpnFxf8KIhQvNqQEwF.', 'UTP202411100001', '2024-11-28 19:18:58', '2024-11-28 19:18:58'),
('USR202411290002', 'Admin', 'admin', '$2y$12$ZMVQqeAhsaxtTwKw8naNDeP89mZfZ7PK8614tetcUQmNA3aRvPAJC', 'UTP202401300001', '2024-11-28 19:32:20', '2024-11-28 19:32:20');

--
-- Triggers `m_user`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_user` BEFORE INSERT ON `m_user` FOR EACH ROW BEGIN
                IF NEW.user_id IS NULL OR NEW.user_id = "" THEN
                    SET NEW.user_id = generate_id_user();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_detail`
--

CREATE TABLE `m_user_detail` (
  `user_detail_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_detail_nidn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_detail_nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_detail_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_detail_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_detail_address` text,
  `user_detail_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `m_user_detail`
--

INSERT INTO `m_user_detail` (`user_detail_id`, `user_id`, `user_detail_nidn`, `user_detail_nip`, `user_detail_email`, `user_detail_phone`, `user_detail_address`, `user_detail_image`, `created_at`, `updated_at`) VALUES
('UDT202411240001', 'USR202411110001', '1122', '2241760113', 'regadanew@gmail.com', '08970852650', 'Jl.Sekolahan', 'storage/image/1732422142.jpg', '2024-11-23 14:46:20', '2024-11-23 21:22:22'),
('UDT202411240002', 'USR202411240001', '', '', '', '', '', 'storage/image/1733290985.jpg', '2024-11-24 04:21:14', '2024-12-03 22:43:05'),
('UDT202411290001', 'USR202411290001', '', '', '', '', '', 'image/default-profile.jpg', '2024-11-28 19:23:05', '2024-11-28 19:23:05'),
('UDT202411290002', 'USR202411290002', '', '', '', '', '', 'image/default-profile.jpg', '2024-11-28 19:32:26', '2024-11-28 19:32:26');

--
-- Triggers `m_user_detail`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_user_detail` BEFORE INSERT ON `m_user_detail` FOR EACH ROW BEGIN
                IF NEW.user_detail_id IS NULL OR NEW.user_detail_id = "" THEN
                    SET NEW.user_detail_id = generate_id_user_detail();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_type`
--

CREATE TABLE `m_user_type` (
  `user_type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_type_code` varchar(255) DEFAULT NULL,
  `user_type_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `m_user_type`
--

INSERT INTO `m_user_type` (`user_type_id`, `user_type_code`, `user_type_name`, `created_at`, `updated_at`) VALUES
('UTP202401300001', 'ADM', 'Administrator', NULL, '2024-11-09 18:25:05'),
('UTP202411100001', 'DSN', 'Dosen', '2024-11-09 16:44:50', '2024-11-09 18:44:19'),
('UTP202411100002', 'PMP', 'Pimpinan', '2024-11-09 16:47:27', '2024-11-09 18:44:29'),
('UTP202411150001', 'TDK', 'Tenaga Pendidikan', NULL, NULL);

--
-- Triggers `m_user_type`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_user_type` BEFORE INSERT ON `m_user_type` FOR EACH ROW BEGIN
                IF NEW.user_type_id IS NULL OR NEW.user_type_id = "" THEN
                    SET NEW.user_type_id = generate_id_user_type();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_course_certification`
--

CREATE TABLE `t_course_certification` (
  `course_certification_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certification_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `course_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `t_course_certification`
--

INSERT INTO `t_course_certification` (`course_certification_id`, `certification_id`, `course_id`, `created_at`, `updated_at`) VALUES
('CRC202411300005', 'CRT202411300004', 'CRS202411190001', '2024-11-30 02:22:36', '2024-11-30 02:22:36'),
('CRC202411300006', 'CRT202411300004', 'CRS202411190002', '2024-11-30 02:22:36', '2024-11-30 02:22:36'),
('CRC202411300007', 'CRT202411300005', 'CRS202411190001', '2024-11-30 02:22:44', '2024-11-30 02:22:44'),
('CRC202411300008', 'CRT202411300005', 'CRS202411190002', '2024-11-30 02:22:44', '2024-11-30 02:22:44');

--
-- Triggers `t_course_certification`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_course_certification` BEFORE INSERT ON `t_course_certification` FOR EACH ROW BEGIN
                IF NEW.course_certification_id IS NULL OR NEW.course_certification_id = "" THEN
                    SET NEW.course_certification_id = generate_id_course_certification();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_course_member`
--

CREATE TABLE `t_course_member` (
  `course_member_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `course_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `t_course_member`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_course_member` BEFORE INSERT ON `t_course_member` FOR EACH ROW BEGIN
                IF NEW.course_member_id IS NULL OR NEW.course_member_id = "" THEN
                    SET NEW.course_member_id = generate_id_course_member();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_course_training`
--

CREATE TABLE `t_course_training` (
  `course_training_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `training_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `course_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `t_course_training`
--

INSERT INTO `t_course_training` (`course_training_id`, `training_id`, `course_id`, `created_at`, `updated_at`) VALUES
('CTR202412050001', 'TRN202412030002', 'CRS202411190002', '2024-12-04 15:47:00', '2024-12-04 15:47:00'),
('CTR202412050002', 'TRN202412030002', 'CRS202412010002', '2024-12-04 15:47:00', '2024-12-04 15:47:00');

--
-- Triggers `t_course_training`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_course_training` BEFORE INSERT ON `t_course_training` FOR EACH ROW BEGIN
                IF NEW.course_training_id IS NULL OR NEW.course_training_id = "" THEN
                    SET NEW.course_training_id = generate_id_course_training();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_interest_certification`
--

CREATE TABLE `t_interest_certification` (
  `interest_certification_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `certification_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `interest_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `t_interest_certification`
--

INSERT INTO `t_interest_certification` (`interest_certification_id`, `certification_id`, `interest_id`, `created_at`, `updated_at`) VALUES
('INC202411300004', 'CRT202411300004', 'INT202411200001', '2024-11-30 02:22:36', '2024-11-30 02:22:36'),
('INC202411300005', 'CRT202411300004', 'INT202411200002', '2024-11-30 02:22:36', '2024-11-30 02:22:36'),
('INC202411300006', 'CRT202411300005', 'INT202411200001', '2024-11-30 02:22:44', '2024-11-30 02:22:44');

--
-- Triggers `t_interest_certification`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_interest_certification` BEFORE INSERT ON `t_interest_certification` FOR EACH ROW BEGIN
                IF NEW.interest_certification_id IS NULL OR NEW.interest_certification_id = "" THEN
                    SET NEW.interest_certification_id = generate_id_interest_certification();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_interest_member`
--

CREATE TABLE `t_interest_member` (
  `interest_member_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `interest_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Triggers `t_interest_member`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_interest_member` BEFORE INSERT ON `t_interest_member` FOR EACH ROW BEGIN
                IF NEW.interest_member_id IS NULL OR NEW.interest_member_id = "" THEN
                    SET NEW.interest_member_id = generate_id_interest_member();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_interest_training`
--

CREATE TABLE `t_interest_training` (
  `interest_training_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `training_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `interest_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `t_interest_training`
--

INSERT INTO `t_interest_training` (`interest_training_id`, `training_id`, `interest_id`, `created_at`, `updated_at`) VALUES
('INT202412050001', 'TRN202412030002', 'INT202411200002', '2024-12-04 15:47:00', '2024-12-04 15:47:00');

--
-- Triggers `t_interest_training`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_interest_training` BEFORE INSERT ON `t_interest_training` FOR EACH ROW BEGIN
                IF NEW.interest_training_id IS NULL OR NEW.interest_training_id = "" THEN
                    SET NEW.interest_training_id = generate_id_interest_training();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_training_member`
--

CREATE TABLE `t_training_member` (
  `training_member_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `training_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `t_training_member`
--

INSERT INTO `t_training_member` (`training_member_id`, `training_id`, `user_id`, `created_at`, `updated_at`) VALUES
('TMB202412050001', 'TRN202412030002', 'USR202411110001', '2024-12-04 15:47:00', '2024-12-04 15:47:00'),
('TMB202412050002', 'TRN202412030002', 'USR202411240001', '2024-12-04 15:47:00', '2024-12-04 15:47:00'),
('TMB202412050003', 'TRN202412030002', 'USR202411290001', '2024-12-04 15:47:00', '2024-12-04 15:47:00');

--
-- Triggers `t_training_member`
--
DELIMITER $$
CREATE TRIGGER `_before_ins_training_member` BEFORE INSERT ON `t_training_member` FOR EACH ROW BEGIN
                IF NEW.training_member_id IS NULL OR NEW.training_member_id = "" THEN
                    SET NEW.training_member_id = generate_id_training_member();
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_certification`
--
ALTER TABLE `m_certification`
  ADD PRIMARY KEY (`certification_id`),
  ADD KEY `m_certification_fk1` (`certification_vendor_id`),
  ADD KEY `m_certification_fk2` (`certification_level`),
  ADD KEY `m_certification_fk4` (`user_id`),
  ADD KEY `m_certification_fk3` (`period_id`);

--
-- Indexes for table `m_certification_type`
--
ALTER TABLE `m_certification_type`
  ADD PRIMARY KEY (`certification_type_id`) USING BTREE;

--
-- Indexes for table `m_certification_vendor`
--
ALTER TABLE `m_certification_vendor`
  ADD PRIMARY KEY (`certification_vendor_id`) USING BTREE;

--
-- Indexes for table `m_course`
--
ALTER TABLE `m_course`
  ADD PRIMARY KEY (`course_id`) USING BTREE;

--
-- Indexes for table `m_interest`
--
ALTER TABLE `m_interest`
  ADD PRIMARY KEY (`interest_id`) USING BTREE;

--
-- Indexes for table `m_period`
--
ALTER TABLE `m_period`
  ADD PRIMARY KEY (`period_id`) USING BTREE;

--
-- Indexes for table `m_training`
--
ALTER TABLE `m_training`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `t_training_fk1` (`training_vendor_id`),
  ADD KEY `t_training_fk2` (`training_level`),
  ADD KEY `t_training_fk3` (`training_quota`),
  ADD KEY `m_training_fk2` (`period_id`);

--
-- Indexes for table `m_training_type`
--
ALTER TABLE `m_training_type`
  ADD PRIMARY KEY (`tarining_type_id`) USING BTREE;

--
-- Indexes for table `m_training_vendor`
--
ALTER TABLE `m_training_vendor`
  ADD PRIMARY KEY (`training_vendor_id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD KEY `m_user_fk1` (`user_type_id`);

--
-- Indexes for table `m_user_detail`
--
ALTER TABLE `m_user_detail`
  ADD PRIMARY KEY (`user_detail_id`) USING BTREE,
  ADD KEY `m_user_detail_fk1` (`user_id`);

--
-- Indexes for table `m_user_type`
--
ALTER TABLE `m_user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `t_course_certification`
--
ALTER TABLE `t_course_certification`
  ADD PRIMARY KEY (`course_certification_id`) USING BTREE,
  ADD KEY `t_course_certification_fk1` (`certification_id`) USING BTREE,
  ADD KEY `t_course_certification_fk2` (`course_id`) USING BTREE;

--
-- Indexes for table `t_course_member`
--
ALTER TABLE `t_course_member`
  ADD PRIMARY KEY (`course_member_id`),
  ADD KEY `t_course_member_fk1` (`user_id`),
  ADD KEY `t_course_member_fk2` (`course_id`);

--
-- Indexes for table `t_course_training`
--
ALTER TABLE `t_course_training`
  ADD PRIMARY KEY (`course_training_id`) USING BTREE,
  ADD KEY `t_course_training_fk1` (`training_id`) USING BTREE,
  ADD KEY `t_course_training_fk2` (`course_id`) USING BTREE;

--
-- Indexes for table `t_interest_certification`
--
ALTER TABLE `t_interest_certification`
  ADD PRIMARY KEY (`interest_certification_id`) USING BTREE,
  ADD KEY `t_interest_certification_fk1` (`certification_id`) USING BTREE,
  ADD KEY `t_interest_certification_fk2` (`interest_id`) USING BTREE;

--
-- Indexes for table `t_interest_member`
--
ALTER TABLE `t_interest_member`
  ADD PRIMARY KEY (`interest_member_id`) USING BTREE,
  ADD KEY `t_interest_member_fk1` (`user_id`) USING BTREE,
  ADD KEY `t_interest_member_fk2` (`interest_id`) USING BTREE;

--
-- Indexes for table `t_interest_training`
--
ALTER TABLE `t_interest_training`
  ADD PRIMARY KEY (`interest_training_id`) USING BTREE,
  ADD KEY `t_interest_training_fk1` (`training_id`) USING BTREE,
  ADD KEY `t_interest_training_fk2` (`interest_id`) USING BTREE;

--
-- Indexes for table `t_training_member`
--
ALTER TABLE `t_training_member`
  ADD PRIMARY KEY (`training_member_id`),
  ADD KEY `t_training_member_fk1` (`training_id`),
  ADD KEY `t_training_member_fk2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_certification`
--
ALTER TABLE `m_certification`
  ADD CONSTRAINT `m_certification_fk1` FOREIGN KEY (`certification_vendor_id`) REFERENCES `m_certification_vendor` (`certification_vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_certification_fk3` FOREIGN KEY (`period_id`) REFERENCES `m_period` (`period_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_certification_fk4` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_training`
--
ALTER TABLE `m_training`
  ADD CONSTRAINT `m_training_fk2` FOREIGN KEY (`period_id`) REFERENCES `m_period` (`period_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_training_fk1` FOREIGN KEY (`training_vendor_id`) REFERENCES `m_training_vendor` (`training_vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `m_user_fk1` FOREIGN KEY (`user_type_id`) REFERENCES `m_user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_user_detail`
--
ALTER TABLE `m_user_detail`
  ADD CONSTRAINT `m_user_detail_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_course_certification`
--
ALTER TABLE `t_course_certification`
  ADD CONSTRAINT `t_course_certification_fk1` FOREIGN KEY (`certification_id`) REFERENCES `m_certification` (`certification_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_course_certification_fk2` FOREIGN KEY (`course_id`) REFERENCES `m_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_course_member`
--
ALTER TABLE `t_course_member`
  ADD CONSTRAINT `t_course_member_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_course_member_fk2` FOREIGN KEY (`course_id`) REFERENCES `m_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_course_training`
--
ALTER TABLE `t_course_training`
  ADD CONSTRAINT `t_course_training_fk1` FOREIGN KEY (`training_id`) REFERENCES `m_training` (`training_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_course_training_fk2` FOREIGN KEY (`course_id`) REFERENCES `m_course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_interest_certification`
--
ALTER TABLE `t_interest_certification`
  ADD CONSTRAINT `t_interest_certification_fk1` FOREIGN KEY (`certification_id`) REFERENCES `m_certification` (`certification_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_interest_certification_fk2` FOREIGN KEY (`interest_id`) REFERENCES `m_interest` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_interest_member`
--
ALTER TABLE `t_interest_member`
  ADD CONSTRAINT `t_interest_member_fk1` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_interest_member_fk2` FOREIGN KEY (`interest_id`) REFERENCES `m_interest` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_interest_training`
--
ALTER TABLE `t_interest_training`
  ADD CONSTRAINT `t_interest_training_fk1` FOREIGN KEY (`training_id`) REFERENCES `m_training` (`training_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_interest_training_fk2` FOREIGN KEY (`interest_id`) REFERENCES `m_interest` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_training_member`
--
ALTER TABLE `t_training_member`
  ADD CONSTRAINT `t_training_member_fk1` FOREIGN KEY (`training_id`) REFERENCES `m_training` (`training_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_training_member_fk2` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
