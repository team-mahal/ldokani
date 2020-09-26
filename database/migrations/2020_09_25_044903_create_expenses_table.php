<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id');
            $table->integer('provider_id');
            $table->integer('employee_id');
            $table->integer('amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->text('details');
            $table->enum('mode', ['1', '2', '3']);
            $table->integer('mode_type_id')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
