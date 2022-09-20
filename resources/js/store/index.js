import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist'


Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cafes: [],
        restaurants: [],
        hoteles: [],
        gyms: [],
        farmacias: [],
        establecimiento: {},
        establecimientos: [],
        categorias:[],
        categoria: '',
        
    },

    mutations:{
        AGREGAR_CATEGORIAS(state, categorias) {
            state.categorias = categorias;
        },
        AGREGAR_CAFES(state, cafes) {
            state.cafes = cafes;
        },
        AGREGAR_RESTAURANTS(state, restaurants) {
            state.restaurants = restaurants;
        },
        AGREGAR_HOTEL(state, hoteles) {
            state.hoteles = hoteles;
        },
        AGREGAR_GYM(state, gyms) {
            state.gyms = gyms;
        },
        AGREGAR_FARMACIA(state, farmacias) {
            state.farmacias = farmacias;
        },
        AGREGAR_ESTABLECIMIENTO(state, establecimiento) {
            state.establecimiento = establecimiento
        },
        AGREGAR_ESTABLECIMIENTOS(state, establecimientos){
            state.establecimientos = establecimientos
        },
        SELECCIONAR_CATEGORIA(state, categoria){
            state.categoria = categoria
        }
      

    },
    getters: {
        obtenerEstablecimiento: state => {
            return state.establecimiento
        },
        obtenerEstablecimientos: state => {
            return state.establecimientos
        },
        obtenerImagenes: state => {
            return state.establecimiento.imagenes
        },
        obtenerCategorias: state => {
            return state.categorias
        },
        obtenerCategoria: state => {
            return state.categoria
        }
    },
    plugins:[
        new VuexPersistence({
            storage: window.localStorage
        }).plugin
    ]

});

