<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertCertificationVendorTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE DEFINER = `root`@`localhost` TRIGGER `_before_ins_certification_vendor`
            BEFORE INSERT ON `m_certification_vendor`
            FOR EACH ROW
            BEGIN
                IF NEW.certification_vendor_id IS NULL OR NEW.certification_vendor_id = "" THEN
                    SET NEW.certification_vendor_id = generate_id_certification_vendor();
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `_before_ins_certification_vendor`');
    }
}
