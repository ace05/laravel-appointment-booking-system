<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('setting_category_id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->string('trans_key')->index();
            $table->string('inputs')->nullable();
            $table->string('help')->nullable();
            $table->mediumText('value')->nullable();
            $table->enum('type', ['text', 'select', 'radio', 'textarea', 'upload', 'database']);
            $table->foreign('setting_category_id')->references('id')->on('setting_categories');
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
        Schema::dropIfExists('settings');
    }
}
