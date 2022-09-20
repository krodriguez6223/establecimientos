<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Leer las rutas por slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
    //relacion de 1:N para categorias y estblecimientos
    public function establecimientos()
    {   
        return $this->hasMany(Establecimientos::class);
    }
}
