<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjednavkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objednavka', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pouzivatel_id')->index();
            $table->string('nazov_objednavky');
            $table->string('polozky')->nullable();
            $table->string('popis')->nullable();
            $table->bigInteger('pocet');
            $table->string('poznamka')->nullable();
            $table->unsignedBigInteger('status_id')->index();
            $table->date('dtm_vytvorenia');
            $table->date('dtm_ukoncenia');
            $table->string('tracking_num')->nullable();
            $table->string('faktura')->nullable();
            $table->smallInteger('visible');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('pouzivatel_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objednavka');
    }
}
