<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuentaxpagar_id')->unsigned();
            $table->foreign('cuentaxpagar_id')->references('id')->on('cuentasxpagar');
            $table->decimal('abono', 8, 2);
            $table->dateTime('fecha_pago');
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
        Schema::drop('pagos');
    }
}
