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
        Schema::create('m_training', function (Blueprint $table) {
            $table->string('training_id')->primary();
            $table->string('training_name')->nullable();
            $table->date('training_date')->nullable();
            $table->string('training_location')->nullable();
            $table->decimal('training_cost', 11)->nullable();
            $table->string('training_vendor_id')->nullable()->index('t_training_fk1');
            $table->string('training_type_id')->nullable()->index('t_training_fk2');
            $table->integer('training_quota')->nullable()->index('t_training_fk3');
            $table->string('course_id')->nullable()->index('m_training_fk1');
            $table->string('interest_id')->nullable()->index('m_training_fk2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_training');
    }
};
