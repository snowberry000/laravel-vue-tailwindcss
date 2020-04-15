<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DbmediaCreateVideoRelease extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('media')->create('releases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_uuid', 32)->unique();
            $table->bigInteger('uid');
            $table->string('name');
            $table->string('filename');
            $table->string('extension');
            $table->timestamps();
            $table->unique(['uid', 'filename']);
        });

        Schema::connection('media')->create('release_video', function (Blueprint $table) {
            $table->unsignedBigInteger('release_id');
            $table->unsignedBigInteger('video_id');
            $table->unique(['release_id', 'video_id']);
            $table->foreign('release_id')->references('id')->on('releases')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('media')->table('release_video', function (Blueprint $table) {
            $table->dropForeign(['release_id']);
            $table->dropForeign(['video_id']);
        });

        Schema::connection('media')->dropIfExists('release_video');
        Schema::connection('media')->dropIfExists('releases');
    }
}