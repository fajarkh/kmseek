<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRitualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ritual', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budaya_id')->nullable()->unsigned();
            $table->foreign('budaya_id')->references('id')->on('budaya')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jenis_ritual')->nullable();
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
        Schema::dropIfExists('ritual');
    }
}
