<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatepurchasereceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasereceipts', function (Blueprint $table) {
            $table->id();
            $table->integer('distributor_id');
            $table->integer('amount')->nullable();
            $table->integer('transport_cost')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('final_amount')->nullable();
            $table->string('date')->nullable();
            $table->enum('mode', ['1', '2', '3']);
            $table->integer('mode_type_id')->nullable();
            $table->integer('payment_amount')->nullable();
            $table->integer('total_paid')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('purchasereceipts');
    }
}
