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
        Schema::create('m_certification_vendor', function (Blueprint $table) {
            $table->string('certification_vendor_id')->primary();
            $table->string('certification_vendor_name')->nullable();
            $table->text('certification_vendor_address')->nullable();
            $table->string('certification_vendor_city')->nullable();
            $table->string('certification_vendor_phone')->nullable();
            $table->text('certification_vendor_web')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_certification_vendor');
    }
};
