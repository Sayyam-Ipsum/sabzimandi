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
        Schema::table('products', function (Blueprint $table){
            $table->dropColumn('unit');
            $table->unsignedBigInteger('unit_id_fk')->nullable(false)->after('name');
            $table->index('unit_id_fk');
            $table->foreign('unit_id_fk')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table){
            $table->string('unit', 50)->nullable(true)->after('name');
            $table->dropForeign(['unit_id_fk']);
        });
    }
};
