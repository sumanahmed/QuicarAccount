<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('car_type_id')->nullable();
            $table->integer('total_person')->nullable();
            $table->tinyInteger('rent_type')->comment('1=drop_only,2=round_tripy')->default(1);
            $table->tinyInteger('status')->comment('1=Pending, 2=Schedule Contact 3=Not Agree')->default(1);
            $table->string('pickup_location')->nullable();
            $table->string('pickup_datetime')->nullable();
            $table->string('drop_location')->nullable();
            $table->string('drop_datetime')->nullable();
            $table->string('return_datetime')->nullable();
            $table->double('asking_price')->nullable();
            $table->double('user_offered')->nullable();
            $table->string('next_contact_datetime')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('car_type_id')->references('id')->on('car_types');
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('reminders');
    }
}
