<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DbMediaAddNsfwFLag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('media')->table('videos', function (Blueprint $table) {
            $table->boolean('nsfw')->default(false)->after('editorial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('media')->table('videos', function (Blueprint $table) {
            $table->dropColumn(['nsfw']);
        });
    }
}