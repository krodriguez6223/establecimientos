<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Establecimiento;
use App\Models\Imagen;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class EstablecimientoController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //consultar categorias
        $categorias = Categoria::all();

        return view('establecimientos.create', compact('categorias'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Models\Categoria,id',
            'imagen_principal' => 'required|image|max:1000',
            'direccion' => 'required',
            'sector' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:20',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

         // Guardar la imagen
         $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

         // Resize a la imagen
         $img = Image::make( public_path("storage/{$ruta_imagen}") )->fit(800, 600);
         $img->save();
 
         $establecimiento = new Establecimiento($data);
         $establecimiento->imagen_principal = $ruta_imagen;
         $establecimiento->user_id = auth()->user()->id;
         $establecimiento->save();

         toast('Establecimiento registrado exitosamente','success');

         return redirect()->route('establecimiento.create');
         
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */

     //funcion para mostrar los datos a actulizar
    public function edit(Establecimiento $establecimiento)
    {
        //consultar categorias
        $categorias = Categoria::all();
        //obtener el establecimiento
        $establecimiento = auth()->user()->establecimiento;
        $establecimiento->apertura = date('h:i', strtotime($establecimiento->apertura));
        $establecimiento->cierre = date('h:i', strtotime($establecimiento->cierre));


        //obtine las imagenes del establecimiento
        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();

        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    // envia los datos a actulizar a la BD
    public function update(Request $request, Establecimiento $establecimiento)
    {
        //Ejecutar el Policy
        $this->authorize('update', $establecimiento);

        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Models\Categoria,id',
            'imagen_principal' => 'image|max:1000',
            'direccion' => 'required',
            'sector' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:20',
            'apertura' => 'date_format:H:i',
            'cierre' => 'date_format:H:i|after:apertura',
            'uuid' => 'required|uuid'
        ]);

        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->sector = $data['sector'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        if (request('imagen_principal')) {
              // Guardar la imagen
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

            // Resize a la imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}") )->fit(800, 600);
            $img->save();

            $establecimiento->imagen_principal = $ruta_imagen;
        }

        $establecimiento->save();
       
        toast('Establecimiento actualizado exitosamente','success');

         return redirect()->route('inicio');
        
    }   
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}