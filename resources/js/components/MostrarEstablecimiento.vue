<template>

<div class="container my-5">
        <h2 class="text-center mb-5"> {{establecimiento.nombre}} </h2>

        <div class="row align-items-start">
            <div class="col-md-6 order-2">
                    <img :src="`../storage/${establecimiento.imagen_principal}`" class="img-fluid" alt="imagen establecimiento">
                    <p class="mt-3"> {{establecimiento.descripcion}} </p>
                    <galeria-imagenes></galeria-imagenes>
                   
            </div>

            <aside class="col-md-4 order-1">
                <div>
                    <mapa-ubicacion></mapa-ubicacion>
                </div>

                <div class="p-4 bg-primary ">
                    <h2 class="text-center text-white mt-2 mb-4">Más Información</h2>

                    <p class="text-white mt-1">
                        <span class="font-weight-bold">
                            Ubicación:
                        </span>
                        {{ establecimiento.direccion }}
                    </p>

                    <p class="text-white mt-1">
                        <span class="font-weight-bold">
                            Sector:
                        </span>
                        {{ establecimiento.sector }}
                    </p>

                    <p class="text-white mt-1">
                        <span class="font-weight-bold">
                            Horario:
                        </span>
                        {{ establecimiento.apertura }} – {{ establecimiento.cierre }}
                    </p>

                    <p class="text-white mt-1">
                        <span class="font-weight-bold">
                            Teléfono:
                        </span>
                        {{ establecimiento.telefono }}
                    </p>
                </div>
            </aside>
        </div>
    </div>
    
</template>

<script>

    
    import MapaUbicacion from './MapaUbicacion';
    import GaleriaImagenes from './GaleriaImagenes';

export default{

//Componente para mostrar el mapa de la ubicacion
    components:{

        MapaUbicacion,
        GaleriaImagenes
    },

    mounted(){
        const { id } = this.$route.params

        axios.get('/api/establecimientos/' + id)
        .then(response =>{
           
            this.$store.commit("AGREGAR_ESTABLECIMIENTO", response.data);           
        })

    },

     computed: {
        establecimiento(){
            return this.$store.getters.obtenerEstablecimiento  
        },
    }
}
</script>