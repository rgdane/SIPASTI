<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddBeforeInsertUserTrigger extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE DEFINER = `root`@`localhost` TRIGGER `_before_ins_user`
            BEFORE INSERT ON `m_user`
            FOR EACH ROW
            BEGIN
                IF NEW.user_id IS NULL OR NEW.user_id = "" THEN
                    SET NEW.user_id = generate_id_user();
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `_before_ins_user`');
    }
}
