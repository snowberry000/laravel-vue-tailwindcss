<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->integer('amount');
            $table->text('memo');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::table('downloads', function (Blueprint $table) {
            $table->unsignedBigInteger('payout_id')->after('value')->nullable()->default(null);
            $table->foreign('payout_id')->references('id')->on('payouts')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropForeign(['payout_id']);
            $table->dropColumn(['payout_id']);
        });
        Schema::dropIfExists('payouts');
    }
}