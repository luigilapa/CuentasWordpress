<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCobros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuentaxcobrar_id')->unsigned();
            $table->foreign('cuentaxcobrar_id')->references('id')->on('cuentasxcobrar');
            $table->decimal('abono', 8, 2);
            $table->dateTime('fecha_cobro');
            $table->string('detalle');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cobros');
    }
}
