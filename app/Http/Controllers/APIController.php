<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use App\Models\Imagen;

class APIController extends Controller
{
    //Método para obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    //Muestra los establecimientos de la categoria en especifico
    public function categoria(Categoria $categoria)
    {
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->take(3)->get();
        return response()->json($establecimientos);
 
    }
    //Muestra los establecimientos de la categoria para la busqueda en menu de categorias
    public function establecimientoCategoria(Categoria $categoria)
    {
        $establecimientos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->get();
        return response()->json($establecimientos);
 
    }
      // Muestra un establecimiento en especifico
    public function show( Establecimiento $establecimiento ) {

        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;

        return response()->json($establecimiento);
    }
    //metodo para obtener todos los establecimientos
    public function index()
    {
        $establecimientos = Establecimiento::with('categoria')->get();
        return response()->json($establecimientos);
    }

}