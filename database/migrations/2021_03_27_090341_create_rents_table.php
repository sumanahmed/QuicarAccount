<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('reg_number')->nullable();
            $table->integer('total_person')->nullable();
            $table->tinyInteger('rent_type')->comment('1=test')->default(1);
            $table->tinyInteger('status')->comment('1=test')->default(1);
            $table->string('pickup_location')->nullable();
            $table->string('pickup_datetime')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('drop_datetime')->nullable();
            $table->double('price')->nullable();
            $table->double('advance')->nullable();
            $table->double('commission')->nullable();
            $table->double('remaining')->nullable();
            $table->double('driver_get')->nullable();
            $table->string('driver_accomodation')->nullable();
            $table->date('start_date')->nullable();
            $table->date('billing_date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('car_type_id')->references('id')->on('car_types');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('driver_id')->references('id')->on('years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rents');
    }
}
