<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_id`(
        IN `arg_table_code` VARCHAR(5),
        IN `arg_table_name` VARCHAR(255),
        OUT `new_id` VARCHAR(255)
    )
BEGIN
    DECLARE var_year VARCHAR(4);
    DECLARE var_month VARCHAR(2);
    DECLARE var_day VARCHAR(2);
    DECLARE last_sequence INT DEFAULT 0;
    DECLARE new_sequence VARCHAR(4);
    DECLARE sql_query TEXT;

    -- Mengambil nilai tahun, bulan, dan hari saat ini
    SET var_year = YEAR(NOW());
    SET var_month = LPAD(MONTH(NOW()), 2, '0'); -- Menambahkan padding nol di depan bulan jika hanya satu digit
    SET var_day = LPAD(DAY(NOW()), 2, '0');     -- Menambahkan padding nol di depan hari jika hanya satu digit

    -- Membuat query dinamis untuk mengambil nilai ID terakhir
    SET sql_query = CONCAT(
        'SELECT COALESCE(MAX(CAST(SUBSTRING(id_column, 12, 4) AS UNSIGNED)), 0) INTO @last_sequence ',
        'FROM ', arg_table_name, ' ',
        'WHERE id_column LIKE \"', arg_table_code, var_year, var_month, var_day, '%\"'
    );

    -- Menjalankan query dinamis
    PREPARE stmt FROM @sql_query;  -- Menggunakan variabel langsung
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    -- Mengambil hasil ke dalam variabel `last_sequence`
    SET last_sequence = @last_sequence;

    -- Menambah 1 ke last_sequence dan mengonversi menjadi string dengan panjang 4 karakter
    SET new_sequence = LPAD(last_sequence + 1, 4, '0');

    -- Menggabungkan semua bagian menjadi new_id
    SET new_id = CONCAT(arg_table_code, var_year, var_month, var_day, new_sequence);
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS generate_id");
    }
};
