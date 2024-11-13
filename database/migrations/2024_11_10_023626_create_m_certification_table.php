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
        Schema::create('m_certification', function (Blueprint $table) {
            $table->string('certification_id')->primary();
            $table->string('certification_name')->nullable();
            $table->string('certification_number')->nullable();
            $table->date('certification_date')->nullable();
            $table->date('certification_expired')->nullable();
            $table->string('certification_vendor_id')->nullable()->index('m_certification_fk1');
            $table->string('certification_type_id')->nullable()->index('m_certification_fk2');
            $table->string('course_id')->nullable()->index('m_certification_fk3');
            $table->string('interest_id')->nullable()->index('m_certification_fk4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_certification');
    }
};
