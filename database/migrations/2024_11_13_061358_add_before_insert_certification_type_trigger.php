<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertCertificationTypeTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE DEFINER = `root`@`localhost` TRIGGER `_before_ins_certification_type`
            BEFORE INSERT ON `m_certification_type`
            FOR EACH ROW
            BEGIN
                IF NEW.certification_type_id IS NULL OR NEW.certification_type_id = "" THEN
                    SET NEW.certification_type_id = generate_id_certification_type();
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `_before_ins_certification_type`');
    }
}
