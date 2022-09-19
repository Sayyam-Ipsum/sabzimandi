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
        Schema::create('invoice_items', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('invoice_id_fk')->nullable(false);
            $table->unsignedBigInteger('product_id_fk')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->double('amount')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('invoice_id_fk');
            $table->foreign('invoice_id_fk')->references('id')->on('invoices');

            $table->index('product_id_fk');
            $table->foreign('product_id_fk')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
};
