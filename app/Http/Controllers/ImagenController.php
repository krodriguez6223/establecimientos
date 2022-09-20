<?php

namespace App\Http\Controllers;



use App\Models\Imagen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;




class ImagenController extends Controller
{
    //
    public function store(Request $request){
      
        // leer la imagen
        $ruta_imagen = $request->file('file')->store('uploads', 'public');

        // Resize a la imagen
        $imagen = Image::make( public_path("storage/{$ruta_imagen}"))->fit(800, 450);
        $imagen->save();

        // Almacenar con Modelo
        $imagenDB = new Imagen;
        $imagenDB->id_establecimiento = $request['uuid'];
        $imagenDB->ruta_imagen = $ruta_imagen;

        $imagenDB->save();

        // Retornar respuesta
        $respuesta = [
            'archivo' => $ruta_imagen
        ];
        return response()->json($respuesta);
    
    }
    //Eliminar imagen de la BD y del servidor
    public function destroy(Request $request)
    {   
        $imagen = $request->get('imagen');

        if(File::exists('storage/' . $imagen)){
            //elimina la imagen del Sevidor
            File::delete('storage/' . $imagen);
            
            // eliimina la imagen de la BD
            Imagen::where('ruta_imagen', $imagen )->delete();
           
            // Retornar respuesta
            $respuesta = [
                'mensaje' => 'Imagen Eliminado',
                'archivo' => $imagen
            ];
        }
        

        
        return  response()->json($respuesta);
    }
}
