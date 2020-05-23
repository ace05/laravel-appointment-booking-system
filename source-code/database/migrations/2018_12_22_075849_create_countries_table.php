<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id')->unsigned();
            $table->string('iso', 2)->index();
            $table->string('iso3', 3);
            $table->string('country')->index();
            $table->string('currency_code', 5);
            $table->string('currency_name');
            $table->string('phone_prefix');
            $table->string('symbol')->nullable();
            $table->string('full_currency')->nullable();
            $table->boolean('is_active')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['deleted_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries', function (Blueprint $table) {
            //
        });
    }
}
