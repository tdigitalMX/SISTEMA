<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('catalogo_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CodigoDeBarras',35);
            $table->text('NombreGenerico',5000)->nullable();
            $table->text('NombreComercial',5000)->nullable();
            $table->text('FormaFarmaucetica',5000)->nullable();
            $table->text('Contenido',5000)->nullable();
            $table->text('Presentacion',5000)->nullable();
            $table->text('Comentarios',5000)->nullable();
            $table->boolean('Estado');
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
        Schema::dropIfExists('catalogo_productos');
    }
}
