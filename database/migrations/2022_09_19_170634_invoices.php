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
        Schema::create('invoices', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id_fk')->nullable(false);
            $table->double('total')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id_fk');
            $table->foreign('user_id_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
