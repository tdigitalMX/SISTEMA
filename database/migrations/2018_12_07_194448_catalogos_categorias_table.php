<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogosCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CatalogosCategorias', function (Blueprint $table) {
            $table->increments('idCategoria');
            $table->string('Clave',35);
            $table->string('SubClave',35);
            $table->string('NombreGenerico',50);
            $table->string('FormaFarmaucetica',50);
            $table->string('Concentracion',50);
            $table->string('Presentacion',50);
            $table->string('Comentarios',200);
            $table->integer('CPromedioXMes')->unsigned();
            $table->string('Registro',200);
            $table->timestamps();
            $table->string('IpRemota',12);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CatalogosCategorias');
    }
}
