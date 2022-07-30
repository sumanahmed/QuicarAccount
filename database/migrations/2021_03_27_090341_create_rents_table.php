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
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('reg_number')->nullable();
            $table->integer('total_person')->nullable();
            $table->integer('total_day')->nullable();
            $table->tinyInteger('rent_type')->comment('1=drop_only,2=round_trip,3=body_rent,4=monthly')->default(1);
            $table->tinyInteger('status')->comment('1=new,2=upcoming,3=complete,4=cancel')->default(1);
            $table->string('pickup_location')->nullable();
            $table->string('pickup_datetime')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('drop_datetime')->nullable();
            $table->string('return_datetime')->nullable();
            $table->double('price')->nullable();
            $table->double('advance')->nullable();
            $table->double('commission')->nullable();
            $table->double('remaining')->nullable();
            $table->double('driver_get',10,2)->default(0);
            $table->string('driver_accomodation')->default(0);
            $table->double('toll_charge',10,2)->default(0);
            $table->double('kilometer', 10,2)->default(0);
            $table->double('total_km', 10,2)->nullable();
            $table->double('fuel',10,2)->default(0)->comment('invoice show');
            $table->double('fuel_cost',10,2)->default(0);
            $table->double('other_cost',10,2)->default(0);
            $table->double('total_vehicle',10,2)->default(0);
            $table->double('body_rent',10,2)->default(0);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('car_type_id')->references('id')->on('car_types');
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('driver_id')->references('id')->on('years');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
