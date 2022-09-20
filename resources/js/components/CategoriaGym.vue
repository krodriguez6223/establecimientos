<template>
    <div class="container my-5">
        <h2>Gyms</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="gym in this.gyms " v-bind:key="gym.id">

                <div class="card">
                    <img class="card-img-top" :src="`storage/${gym.imagen_principal}`" alt="card del restaurant" >
                    <div class="card-body">
                        <h4 class="card-title text-primary"> {{ gym.nombre }} </h4>
                        <h3 class="card-text fw-light"><span class="fw-bold">Ubicación: </span> {{gym.direccion}}</h3>
                        <h3 class="card-text fw-light">
                            <span class="fw-bold">Horario:</span>
                                {{gym.apertura}} - {{gym.cierre}}
                        </h3>   
                            <router-link :to=" {name:'establecimiento', params: {id:gym.id}}">
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
        axios.get('/api/categorias/gym')
        .then(response =>{
            this.$store.commit("AGREGAR_GYM", response.data);
        })

    },
    computed: {
        gyms(){
            return this.$store.state.gyms
        }
    }
}

</script>