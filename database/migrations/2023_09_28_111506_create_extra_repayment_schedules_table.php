<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_repayment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->integer('month_number');
            $table->unsignedDecimal('starting_balance', 10);
            $table->unsignedDecimal('monthly_payment',10);
            $table->unsignedDecimal('principal_component', 10);
            $table->unsignedDecimal('interest_component', 10);
            $table->unsignedDecimal('extra_payment', 10);
            $table->unsignedDecimal('ending_balance', 10);
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
        Schema::dropIfExists('extra_repayment_schedules');
    }
};
