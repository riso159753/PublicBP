<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index();
            $table->string('product')->nullable();
            $table->string('person')->nullable();
            $table->unsignedBigInteger('material')->index()->nullable();
            $table->smallInteger('trim')->nullable();
            $table->unsignedBigInteger('sidePanel')->index()->nullable();
            $table->smallInteger('panel')->nullable();
            $table->smallInteger('zip')->nullable();
            $table->unsignedBigInteger('collar')->index()->nullable();
            $table->string('size')->nullable();
            $table->integer('number');
            $table->smallInteger('visible');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('objednavka');
            $table->foreign('collar')->references('id')->on('materials');
            $table->foreign('sidePanel')->references('id')->on('materials');
            $table->foreign('material')->references('id')->on('materials');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
