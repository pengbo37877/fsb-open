<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFsbVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsb_versions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('fsb-pb.liquid');
            $table->text('body')->comment('版本内容');
            $table->boolean('force_update')->default(0)->comment('是否强制更新 0:否 1:是');
            $table->string('env')->default('dev')->comment('使用场景 dev, prod');
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
        Schema::dropIfExists('fsb_versions');
    }
}
