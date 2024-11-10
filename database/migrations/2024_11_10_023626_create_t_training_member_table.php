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
        Schema::create('t_training_member', function (Blueprint $table) {
            $table->string('training_member_id')->primary();
            $table->string('training_id')->nullable()->index('t_training_member_fk1');
            $table->string('user_id')->nullable()->index('t_training_member_fk2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_training_member');
    }
};
