<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id')->unsigned();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->string('password');
            $table->integer('otp_code')->nullable();
            $table->string('alt_mobile_number')->nullable();
            $table->string('email_verification_token')->nullable()->index();
            $table->string('otp_verification_token')->nullable()->index();
            $table->dateTime('email_verification_date')->nullable();
            $table->integer('user_type_id', false)->unsigned();
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->string('ip', 100)->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_email_verified')->default(0)->index();
            $table->boolean('is_mobile_verified')->default(0)->index();
            $table->boolean('is_active')->default(1)->index();
            $table->boolean('is_blocked')->default(0)->index();
            $table->decimal('available_balance', 10, 2)->default('0.00');
            $table->decimal('total_earnings', 10, 2)->default('0.00');
            $table->decimal('site_commissions', 10, 2)->default('0.00');
            $table->integer('rating')->default(0)->index();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at']);
            $table->index(['deleted_at']);
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
