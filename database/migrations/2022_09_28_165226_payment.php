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
        Schema::create('payments', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('customer_id_fk')->nullable(false);
            $table->double('total', '12', '0')->nullable(false)->default(0);
            $table->double('receive', '12', '0')->nullable(false)->default(0);
            $table->double('remain', '12', '0')->nullable(false)->default(0);
            $table->timestamps();

            $table->index('customer_id_fk');
            $table->foreign('customer_id_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
