<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingBarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_bars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable()->comment('For your own internal reference, only you can see it.');
            $table->unsignedInteger('shipping_goal')->default(0)->comment('if no minimum order value is required, please set goal to zero');
            $table->unsignedInteger('shipping_second_goal')->default(0);
            $table->string('shipping_goal_currency')->default('USD')->comment('shipping fee is based on this currency');
            $table->string('shipping_goal_currency_symbol')->default('$');
            $table->string('init_message_1')->nullable()->comment('display when cart is empty');
            $table->string('init_message_2')->nullable();
            $table->string('progress_message_1')->nullable()->comment('display when cart value is less than the goal');
            $table->string('progress_message_2')->nullable();
            $table->string('achieved_message_1')->nullable()->comment('display when cart value is greater then the goal');
            $table->string('achieved_message_2')->nullable();
            $table->boolean('add_link')->default(false)->comment('the bar will be clickable after adding a link');
            $table->string('link')->nullable()->comment('the link: any url');
            $table->boolean('add_close_btn')->default(false)->comment('plase a "X" button on the bar, so users can hide the bar manually');
            $table->string('bg_color')->nullable();
            $table->unsignedInteger('bg_opacity')->default(0)->comment('the range is from 0 to 100, 0 = transparent and 1 = solid');
            $table->string('bg_image')->nullable()->comment('the preset image or user uploaded image');
            $table->string('text_color')->nullable();
            $table->string('shipping_goal_text_color')->nullable();
            $table->string('font')->nullabe();
            $table->string('height')->default('30px');
            $table->string('show_on')->default('both');
            $table->string('display_position')->default('TOP');
            $table->unsignedInteger('expires_days')->default(1);
            $table->string('close_btn_color')->nullable();
            $table->boolean('active')->default(1);
            $table->text('geo_targets')->nullable()->comment('currencies split by ,');
            $table->text('page_targets')->nullable()->comment('page type split by ,');
            $table->bigInteger('start_at')->nullable();
            $table->bigInteger('end_at')->nullable();
            $table->string('timezone')->nullable();
            $table->boolean('currency_conversion')->default(0);
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_bars');
    }
}
