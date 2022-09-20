<template>
    <div class="container my-5">
        <h2>Cafés</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="cafe in this.cafes " v-bind:key="cafe.id">

                <div class="card">
                    <img class="card-img-top" :src="`storage/${cafe.imagen_principal}`" alt="card del restaurant" >
                    <div class="card-body">
                        <h4 class="card-title text-primary"> {{ cafe.nombre }} </h4>
                        <h3 class="card-text fw-light"><span class="fw-bold">Ubicación: </span>{{cafe.direccion}}</h3>
                        <h3 class="card-text fw-light">
                            <span class="fw-bold">Horario:</span>
                                {{cafe.apertura}} - {{cafe.cierre}}
                        </h3>  
                        <router-link :to=" {name:'establecimiento', params: {id:cafe.id}}">
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
        axios.get('/api/categorias/cafe')
        .then(response =>{
            this.$store.commit("AGREGAR_CAFES", response.data);
        })

    },
    computed: {
        cafes(){
            return this.$store.state.cafes
        }
    }
}

</script>

