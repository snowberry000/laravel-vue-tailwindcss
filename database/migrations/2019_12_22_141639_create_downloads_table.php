<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('original_id')->description('Original download id.');
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('uid')->nullable();
            $table->string('client');
            $table->unsignedInteger('value')->default(0); // user get's half of that or maybe different stuff will happen here.
            $table->dateTime('paid_at')->nullable()->default(null);
            $table->timestamps(); // reuse created_at for showing the purchase date.
            $table->index(['image_id', 'uid', 'client']);
            $table->index(['image_id', 'client', 'original_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloads');
    }
}