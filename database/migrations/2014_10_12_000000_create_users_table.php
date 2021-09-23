<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_email')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('currency')->default('USD');
            $table->string('enabled_presentment_currencies')->default('["USD"]');
            $table->string('money_format')->default('${{amount}}');
            $table->string('money_with_currency_format')->default('${{amount}}');
            $table->string('money_in_emails_format')->default('${{amount}}');
            $table->string('money_with_currency_in_emails_format')->default('${{amount}}');
            $table->string('money_format_symbol')->default('$');
            $table->string('iana_timezone')->nullable();
            $table->string('shopify_plan_name')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
