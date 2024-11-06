<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('m_training', function (Blueprint $table) {
            $table->foreign(['course_id'], 'm_training_fk1')->references(['course_id'])->on('m_course')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['interest_id'], 'm_training_fk2')->references(['interest_id'])->on('m_interest')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['training_vendor_id'], 't_training_fk1')->references(['training_vendor_id'])->on('m_training_vendor')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['training_type_id'], 't_training_fk2')->references(['tarining_type_id'])->on('m_training_type')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_training', function (Blueprint $table) {
            $table->dropForeign('m_training_fk1');
            $table->dropForeign('m_training_fk2');
            $table->dropForeign('t_training_fk1');
            $table->dropForeign('t_training_fk2');
        });
    }
};
