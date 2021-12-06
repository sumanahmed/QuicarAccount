<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_charges', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('purpose');
            $table->double('amount', 10, 2);
            $table->string('paid_to', 100)->nullable();
            $table->string('paid_by', 100)->nullable();
            $table->tinyIncrements('payment_by')->default(1)->comment('1=Cash,2=Bank,3=Bkash,4=Rocket,5=Nagad');
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
        Schema::dropIfExists('maintenance_charges');
    }
}
