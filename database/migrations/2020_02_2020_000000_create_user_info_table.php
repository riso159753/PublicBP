<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pouzivatel_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pouzivatel_id')->index();
            $table->foreign('pouzivatel_id')->references('id')->on('users');
            $table->string('meno')->nullable();
            $table->string('krajina');
            $table->string('telefon')->nullable();
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
        Schema::dropIfExists('pouzivatel_info');
    }
}
