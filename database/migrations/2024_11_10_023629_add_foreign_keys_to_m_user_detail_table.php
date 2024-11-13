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
        Schema::table('m_user_detail', function (Blueprint $table) {
            $table->foreign(['user_id'], 'm_user_detail_fk1')->references(['user_id'])->on('m_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_user_detail', function (Blueprint $table) {
            $table->dropForeign('m_user_detail_fk1');
        });
    }
};
