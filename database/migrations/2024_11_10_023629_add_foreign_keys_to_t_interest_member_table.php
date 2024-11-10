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
        Schema::table('t_interest_member', function (Blueprint $table) {
            $table->foreign(['user_id'], 't_interest_member_fk1')->references(['user_id'])->on('m_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['interest_id'], 't_interest_member_fk2')->references(['interest_id'])->on('m_interest')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_interest_member', function (Blueprint $table) {
            $table->dropForeign('t_interest_member_fk1');
            $table->dropForeign('t_interest_member_fk2');
        });
    }
};
