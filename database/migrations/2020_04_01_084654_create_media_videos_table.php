<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('media')->create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_uuid', 32)->unique();
            $table->unsignedInteger('uid');
            $table->string('extension', 4);
            $table->string('original_name');
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('keywords')->nullable();
            $table->boolean('people')->nullable();
            $table->unsignedInteger('num_people')->nullable();
            $table->boolean('editorial')->nullable();
            $table->string('codec')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->double('framerate')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->unsignedInteger('size')->nullable();
            $table->boolean('4k')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection('media')->dropIfExists('videos');
    }
}