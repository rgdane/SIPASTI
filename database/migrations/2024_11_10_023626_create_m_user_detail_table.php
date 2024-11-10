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
        Schema::create('m_user_detail', function (Blueprint $table) {
            $table->string('user_detail_id')->primary();
            $table->string('user_id')->nullable()->index('m_user_detail_fk1');
            $table->string('user_detail_name')->nullable();
            $table->string('user_detail_nidn')->nullable();
            $table->string('user_detail_nip')->nullable();
            $table->string('user_detail_email')->nullable();
            $table->string('user_detail_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user_detail');
    }
};
