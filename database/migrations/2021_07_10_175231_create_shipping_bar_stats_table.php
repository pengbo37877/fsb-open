<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingBarStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_bar_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ip')->nullable();
            $table->string('client_id');
            $table->string('currency_display')->nullable();
            $table->string('currency_location')->nullable();
            $table->string('location_timestamp')->nullable();
            $table->string('ban_bar_ids')->nullabel();
            $table->string('ban_bar_times')->nullabel();
            $table->string('from')->nullable();
            $table->unsignedBigInteger('stats_at');
            $table->unsignedInteger('click_times')->default(0);
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
        Schema::dropIfExists('shipping_bar_stats');
    }
}
