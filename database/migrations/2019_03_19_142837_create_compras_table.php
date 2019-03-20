<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Payload formato
     * [{
     *  id:Producto_id,
     *  cantidad:Cantidad_producto
     *  meta:{
     *      precio1:Precio_actual,
     *      precio2:Precio_anterior
     *  }
     * },{otro producto}]
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ejercicio_id');
            $table->integer('proveedors_id');
            $table->string('factura')->unique();
            $table->json('payload')->nullable();
            $table->float('total', 8, 2)->nullable();
            $table->enum('anulada', ['si', 'no']);
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
        Schema::dropIfExists('compras');
    }
}
