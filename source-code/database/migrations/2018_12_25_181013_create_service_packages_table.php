<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_packages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->mediumText('details');
            $table->mediumText('inclusion')->nullable();
            $table->mediumText('exclusion')->nullable();
            $table->mediumText('conditions')->nullable();
            $table->boolean('is_active')->default(1)->index();
            $table->boolean('is_approved')->default(0)->index();
            $table->boolean('is_allow_appointment')->default(0)->index();
            $table->boolean('is_address_required')->default(0)->index();
            $table->decimal('price', 10,2)->default('0.00');
            $table->decimal('discount', 10,2)->default('0.00');
            $table->bigInteger('city_id')->unsigned();
            $table->integer('rating', false)->default(0);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->bigInteger('service_sub_category_id')->unsigned();
            $table->foreign('service_sub_category_id')->references('id')->on('service_sub_categories');
            $table->string('slug')->index();
            $table->timestamps();
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
        Schema::dropIfExists('service_packages');
    }
}
