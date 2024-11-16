<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertUserTypeTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS `_before_ins_user_type`;
            CREATE DEFINER = `root`@`localhost` TRIGGER `_before_ins_user_type`
            BEFORE INSERT ON `m_user_type`
            FOR EACH ROW
            BEGIN
                IF NEW.user_type_id IS NULL OR NEW.user_type_id = "" THEN
                    SET NEW.user_type_id = generate_id_user_type();
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `_before_ins_user_type`');
    }
}
