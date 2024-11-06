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
        Schema::create('t_course_member', function (Blueprint $table) {
            $table->string('course_member_id')->primary();
            $table->string('user_id')->nullable()->index('t_course_member_fk1');
            $table->string('course_id')->nullable()->index('t_course_member_fk2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_course_member');
    }
};
