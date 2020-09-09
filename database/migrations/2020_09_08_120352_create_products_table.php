<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('company_id');
            $table->integer('unit_id');
            $table->integer('product_size')->nullable();
            $table->integer('alarm_level')->nullable();
            $table->enum('warranty', ['general', 'warranty'])->nullable();
            $table->string('product_name');
            $table->string('product_model')->nullable();
            $table->integer('product_barcode');
            $table->string('product_image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
