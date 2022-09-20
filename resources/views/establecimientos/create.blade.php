@extends('layouts.app')


{{-- estilos del mapa--}}
@section('styles')
    <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" 
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

    <link
        rel="stylesheet"
        href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"/>
    <link 
        rel="stylesheet" 
        href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" 
        type="text/css" />  

@endsection

@section('content')

<div class="container rounded mt-5">
    <h1 class="text-center mt-10">Registrar establecimiento</h1>

    <div class="mt-5 row justify-content-center">


        <form method="POST" 
              action="{{ route('establecimiento.store')}}" 
              class="col-md-8  card p-3"
              enctype="multipart/form-data"
              novalidate>
              @csrf

            <fieldset class="border p-4">
                <legend class="text-primary">Nombre, categoria e imagen principal</legend>
                
                {{-- Nombre estblecimiento --}}
                <div class="form-group pt-2">
                    <label for="nombre">Nombre Establecimiento</label>
                    <input 
                         id="nombre" 
                         name="nombre" 
                         type="text" 
                         class="form-control @error('nombre') is-invalid @enderror"
                         placeholder="Nombre Establecimiento" 
                         value="{{ old('nombre') }}">
                         
                         @error('nombre')
                           <div class="invalid-feedback">{{$message}}</div>
                         @enderror
                </div>
                 
                {{-- Categorias --}}
                <div class="form-group pt-2">
                    <label for="categoria">Categorías</label>
                    <select 
                        class="form-control @error('categoria_id') is-invalid @enderror" 
                        name="categoria_id"
                        id="categoria">
                        <option value="" selected disabled>--Seleccione--</option>
                        
                        @foreach ($categorias as $categoria )

                        <option value="{{ $categoria->id }}" 
                                       {{ old('categoria_id')==$categoria->id ? 'selected' : ''}}>
                                       {{ $categoria->nombre }}
                        </option>
                        @endforeach

                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                 
                {{-- Imagen --}}
                <div class="form-group pt-2">
                    <label 
                    for="imagen_principal">Imagen principal</label>
                    <input 
                        id="imagen_principal" 
                        name="imagen_principal" 
                        type="file" 
                        class="form-control @error('imagen_principal') is-invalid @enderror"
                        value="{{ old('imagen_principal') }}">

                        @error('imagen_principal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

            </fieldset>
    
            <fieldset class="border p-4 mt-3">
                <legend  class="text-primary">Información Establecimiento: </legend>
                    <div class="form-group pt-2">
                        <label for="nombre">Teléfono</label>
                        <input 
                            type="tel" 
                            class="form-control @error('telefono')  is-invalid  @enderror" 
                            id="telefono" 
                            placeholder="Teléfono Establecimiento"
                            name="telefono"
                            value="{{ old('telefono') }}"
                        >

                            @error('telefono')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                    </div>

                    <div class="form-group pt-2">
                        <label for="nombre">Descripción</label>
                        <textarea
                            class="form-control  @error('descripcion')  is-invalid  @enderror" 
                            name="descripcion"
                        >{{ old('descripcion') }}</textarea>

                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                    </div>
                    <div class="form-row row">
                    <div class="form-group pt-2 col-md-6">
                        <label for="nombre">Hora Apertura:</label>
                        <input 
                            type="time" 
                            class="form-control @error('apertura')  is-invalid  @enderror" 
                            id="apertura" 
                            name="apertura"
                            value="{{ old('apertura') }}"
                        >
                        @error('apertura')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group pt-2 col-md-6">
                        <label for="cierre">Hora cierre:</label>
                        <input 
                            type="time" 
                            class="form-control @error('cierre')  is-invalid  @enderror" 
                            id="cierre" 
                            name="cierre"
                            value="{{ old('cierre') }}"
                        >
                        @error('cierre')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    </div>
            </fieldset>
            <fieldset class="border p-4 mt-3">

                 <legend  class="text-primary">Subida de imagenes </legend>
                    <div class="form-group pt-2">
                        <label for="imagenes">Imagenes</label>
                        <div id="dropzone" class="dropzone form-control"></div>
                    </div>
                    
                     {{-- hiiden para obtenenr el token del meta para la subida de imagenes con dropzone--}}
                    <input type="hidden" id="uuid" name="uuid" value="{{ Str::uuid()->toString() }}">
            </fieldset>
            <fieldset class="border p-4 mt-3">
                <legend class="text-primary">Ubicación:</legend>
                
                {{-- direccion del establecimiento --}}
                <div class="form-group pt-2">
                    <label for="form_buscador">Coloca la dirección del establecimiento</label>
                    <input 
                         id="form_buscador" 
                         name="form_buscador" 
                         type="text" 
                         class="form-control"
                         placeholder="Calle del negocio o establecimiento ">
                         
                         <p class="text-secondary mt-5 mb-3 text-center">
                            El asistente colocará una dirección estimada, o mueve
                            el Pin hacia el lugar correcto
                        </p> 
                </div>
                <div class="form-group">
                    <div id="mapa" style="height: 400px;"></div>
                </div>
                <p class="informacion">Confirma que los siguientes campos sean los correctos</p>
                 <div class="form-row row">
                    {{-- Direccion --}}               
                    <div class="form-group pt-2 col-md-6">
                        <label 
                        for="direccion">Dirección</label>
                        <input 
                            id="direccion" 
                            name="direccion" 
                            type="text" 
                            class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="direccion"
                            value="{{ old('direccion') }}">

                            @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    {{-- Canton --}}               
                    <div class="form-group pt-2 col-md-6">
                        <label 
                        for="sector">Cantón</label>
                        <input 
                            id="sector" 
                            name="sector" 
                            type="text" 
                            class="form-control @error('sector') is-invalid @enderror"
                            placeholder="sector"
                            value="{{ old('sector') }}">

                            @error('sector')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                </div>

                <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">

            </fieldset>
          
               
                <input type="submit" class="btn btn-primary mt-3 d-block " value="Registrar establecimiento">
          
        </form>
        
    </div>
    
    
</div>

@endsection

{{-- Scripts del mapa--}}
@section('scripts')
    <script 
        src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" 
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" 
        crossorigin="" defer>
    </script>
    <script src="https://unpkg.com/esri-leaflet" defer></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" defer></script> 
 
@endsection