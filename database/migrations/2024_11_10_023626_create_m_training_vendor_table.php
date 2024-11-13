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
        Schema::create('m_training_vendor', function (Blueprint $table) {
            $table->string('training_vendor_id')->primary();
            $table->string('training_vendor_name')->nullable();
            $table->text('training_vendor_address')->nullable();
            $table->string('training_vendor_city')->nullable();
            $table->string('training_vendor_phone')->nullable();
            $table->text('training_vendor_web')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_training_vendor');
    }
};
