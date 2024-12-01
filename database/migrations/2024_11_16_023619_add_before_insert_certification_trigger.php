<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertCertificationTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
        DROP TRIGGER IF EXISTS `_before_ins_certification`;
            CREATE DEFINER = `root`@`localhost` TRIGGER `_before_ins_certification`
            BEFORE INSERT ON `m_certification`
            FOR EACH ROW
            BEGIN
                IF NEW.certification_id IS NULL OR NEW.certification_id = "" THEN
                    SET NEW.certification_id = generate_id_certification();
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `_before_ins_certification`');
    }
}
