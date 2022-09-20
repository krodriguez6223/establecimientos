<template>
    <div class="container my-5">
        <h2>Restaurant</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="restaurant in this.restaurants " v-bind:key="restaurant.id">

                <div class="card">
                    <img class="card-img-top" :src="`storage/${restaurant.imagen_principal}`" alt="card del restaurant" >
                    <div class="card-body">
                        <h4 class="card-title text-primary"> {{ restaurant.nombre }} </h4>
                        <h3 class="card-text fw-light"><span class="fw-bold">Ubicación: </span> {{restaurant.direccion}}</h3>
                        <h3 class="card-text fw-light">
                            <span class="fw-bold">Horario:</span>
                                {{restaurant.apertura}} - {{restaurant.cierre}}
                        </h3>   
                            <router-link :to=" {name:'establecimiento', params: {id:restaurant.id}}">
                                <a class="btn btn-primary d-block">Ver Lugar</a>
                            </router-link> 

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default{


    mounted(){
        axios.get('/api/categorias/restaurant')
        .then(response =>{
              this.$store.commit("AGREGAR_RESTAURANTS", response.data);
        })

    },
    computed: {
        restaurants(){
            return this.$store.state.restaurants
        }
    }
}

</script>