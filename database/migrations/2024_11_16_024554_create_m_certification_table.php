<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_certification', function (Blueprint $table) {
            $table->string('certification_id')->primary();
            $table->string('certification_name')->nullable();
            $table->string('certification_number')->nullable();
            $table->date('certification_date_start')->nullable();
            $table->date('certification_date_expired')->nullable();
            $table->string('certification_vendor_id')->nullable();
            $table->enum('certification_level', ['0', '1'])->nullable()->comment('0 = Nasional\r\n1 = Internasional');
            $table->enum('certification_type', ['0', '1'])->nullable()->comment('0 = Profesi\r\n1 = Keahlian');
            $table->string('user_id')->nullable();
            $table->text('certification_file')->nullable();

            // Foreign key constraints
            $table->foreign('certification_vendor_id')
                    ->references('certification_vendor_id')
                    ->on('m_certification_vendor')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->foreign('user_id')
                    ->references('user_id')
                    ->on('m_user')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_certification');
    }
}
