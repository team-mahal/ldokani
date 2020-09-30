<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaselistingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaselistings', function (Blueprint $table) {
            $table->id();
            $table->integer('purchasereceipt_id');
            $table->integer('product_id');
            $table->integer('quantity')->nullable();
            $table->integer('total_buy_price')->nullable();
            $table->string('expire_date')->nullable();
            $table->integer('mrp')->nullable();
            $table->integer('unit_buy_price');
            $table->integer('sale_price');
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
        Schema::dropIfExists('purchaselistings');
    }
}
