<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('order_address_id')->unsigned()->nullable();
            $table->foreign('order_address_id')->references('id')->on('order_addresses');
            $table->decimal('price', 10,2)->default('0.00');
            $table->decimal('discount', 10,2)->default('0.00');
            $table->bigInteger('service_package_id')->unsigned();
            $table->foreign('service_package_id')->references('id')->on('service_packages');
            $table->date('appointment_date')->nullable();
            $table->string('reference_id')->nullable();
            $table->boolean('is_paid')->default(0)->index();
            $table->boolean('is_cancelled')->default(0)->index();
            $table->boolean('is_accepted')->default(0)->index();
            $table->boolean('is_completed')->default(0)->index();
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
        Schema::dropIfExists('orders');
    }
}
