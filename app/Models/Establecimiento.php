<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'nombre',
        'categoria_id',
        'direccion',
        'sector',
        'lat',
        'lng',
        'telefono',
        'descripcion',
        'apertura',
        'cierre',
        'uuid',
        'user_id'
    ];
    
    public function Categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
   
}
