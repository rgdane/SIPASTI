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
        Schema::table('m_certification', function (Blueprint $table) {
            $table->foreign(['certification_vendor_id'], 'm_certification_fk1')->references(['certification_vendor_id'])->on('m_certification_vendor')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['certification_type_id'], 'm_certification_fk2')->references(['certification_type_id'])->on('m_certification_type')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['course_id'], 'm_certification_fk3')->references(['course_id'])->on('m_course')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['interest_id'], 'm_certification_fk4')->references(['interest_id'])->on('m_interest')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_certification', function (Blueprint $table) {
            $table->dropForeign('m_certification_fk1');
            $table->dropForeign('m_certification_fk2');
            $table->dropForeign('m_certification_fk3');
            $table->dropForeign('m_certification_fk4');
        });
    }
};
