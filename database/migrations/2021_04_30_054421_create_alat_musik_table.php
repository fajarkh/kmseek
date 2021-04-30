<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatMusikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_musik', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budaya_id')->nullable()->unsigned();
            $table->foreign('budaya_id')->references('id')->on('budaya')->onUpdate('cascade')->onDelete('cascade');
            $table->string('alat_musik')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alat_musik');
    }
}
