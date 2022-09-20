<template>
    <div class="mt-5">
        <h1>
            <listado-categoria></listado-categoria>
            <mapa-establecimientos></mapa-establecimientos>         
            <categoria-cafe></categoria-cafe>
            <categoria-restaurant></categoria-restaurant>
            <categoria-hotel></categoria-hotel>
            <categoria-gym></categoria-gym>
            <categoria-farmacia></categoria-farmacia>
        </h1>
    </div>
</template>

<script>

import ListadoCategoria from './ListadoCategoria';
import MapaEstablecimientos from './MapaEstablecimientos';
import CategoriaCafe from './CategoriaCafe';
import CategoriaRestaurant from './CategoriaRestaurant';
import CategoriaHotel from './CategoriaHotel';
import CategoriaGym from './CategoriaGym';
import CategoriaFarmacia from './CategoriaFarmacia';


    export default {
        
        components: {
           
            ListadoCategoria,
            MapaEstablecimientos,
            CategoriaCafe,
            CategoriaRestaurant,
            CategoriaHotel,
            CategoriaGym,
            CategoriaFarmacia,
        }
    }

</script>