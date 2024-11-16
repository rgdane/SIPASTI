<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddGenerateIdCertificationFunction extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE DEFINER = `root`@`localhost` FUNCTION `generate_id_certification`()
            RETURNS VARCHAR(20) CHARACTER SET utf8mb4
            DETERMINISTIC
            CONTAINS SQL
            SQL SECURITY DEFINER
            COMMENT ""
            BEGIN
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
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS `generate_id_certification`');
    }
}

