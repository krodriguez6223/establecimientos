<template>
    <div class="container my-5">
        <h2>Farmacias</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="farmacia in this.farmacias " v-bind:key="farmacia.id">

                <div class="card">
                    <img class="card-img-top" :src="`storage/${farmacia.imagen_principal}`" alt="card del restaurant" >
                    <div class="card-body">
                        <h4 class="card-title text-primary"> {{ farmacia.nombre }} </h4>
                        <h3 class="card-text fw-light"><span class="fw-bold">Ubicación: </span> {{farmacia.direccion}}</h3>
                        <h3 class="card-text fw-light">
                            <span class="fw-bold">Horario:</span>
                                {{farmacia.apertura}} - {{farmacia.cierre}}
                        </h3>  
                        <router-link :to=" {name:'establecimiento', params: {id:farmacia.id}}">
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
        axios.get('/api/categorias/farmacias')
        .then(response =>{
            this.$store.commit("AGREGAR_FARMACIA", response.data);
        })

    },
    computed: {
            farmacias(){
            return this.$store.state.farmacias
        }
    }
}

</script>

