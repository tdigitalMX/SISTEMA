<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogoProducto extends Model
{
    protected $fillable = [
        'CodigoDeBarras',
        'NombreGenerico',
        'NombreComercial',
        'FormaFarmaucetica',
        'Contenido',
        'Presentacion',
        'Comentarios'
    ];
}
