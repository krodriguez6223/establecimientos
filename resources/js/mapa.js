
 import { OpenStreetMapProvider } from 'leaflet-geosearch';
 const provider = new OpenStreetMapProvider();

//script del mapa
    document.addEventListener('DOMContentLoaded', () => {
        
        if(document.querySelector('#mapa')){
                
                const lat = document.querySelector('#lat').value === '' ? -1.0549164 : document.querySelector('#lat').value;;
                const lng = document.querySelector('#lng').value === '' ? -80.4540074 : document.querySelector('#lng').value;

                const mapa = L.map('mapa').setView([lat, lng], 16);//zoom del mapa actual(16)

                //eliminar pines previos
                let markers = new L.FeatureGroup().addTo(mapa);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapa);
                
                let marker;
                
                // agregar el pin
                marker = new L.marker([lat, lng],{
                    draggable: true,//habilita el movimiento del pin
                    autoPan: true,//permite mover el mapa conforme mueves el pin
                }).addTo(mapa);
                
                // Agregar el pin a las capas
                 markers.addLayer(marker);

                //Geocode Service
                const geocodeService = L.esri.Geocoding.geocodeService({
                    apikey:'AAPK741de16e5e0145858a92b9a8c03161d1OiuFkoYFrN1aBl-PdjL2TtcDQnFMzTfC5gwTz-7SSXgm2ON2JM582asle4GPmVD1'
                });
                //Buscador de direcciones
                const buscador = document.querySelector('#form_buscador');
                buscador.addEventListener('blur', buscarDireccion);

                reubicarPin(marker);

                function reubicarPin(marker){
                        //detectar movimiento del markert lat  longt
                        marker.on('moveend', function(e) {
                        marker = e.target;

                        const posicion = marker.getLatLng();

                        //centrar en el mapa automaticamente
                        mapa.panTo( new L.LatLng( posicion.lat, posicion.lng))

                        //Reverse Geoconding, cuando el usuario reubica el pin
                        geocodeService.reverse().latlng(posicion, 16).run(function(error, resultado) {
                            
                        // console.log(error);
                            //console.log(resultado);

                            marker.bindPopup(resultado.address.LongLabel);
                            marker.openPopup();

                            //llenar inputs
                            llenarInputs(resultado);
                        });
                    })
                }

                function buscarDireccion(e, resultado){

                    if(e.target.value.length > 1) {

                        provider.search({query: e.target.value + ' Ecuador Manabí Portoviejo' })
                        .then( resultado => { 
                            if(resultado){
                                //limpiar pines previos
                                markers.clearLayers();

                                geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function(error, resultado) {

                                    // Llenar los inputs
                                    llenarInputs(resultado);
    
                                    // Centrar el mapa
                                    mapa.setView(resultado.latlng)

                                    // Agregar el Pin
                                    marker = new L.marker(resultado.latlng, {
                                        draggable: true,
                                        autoPan: true
                                    }).addTo(mapa);
    
                                    // asignar el contenedor de markers el nuevo pin
                                    markers.addLayer(marker);
    
    
                                    // Mover el pin
                                     reubicarPin(marker);
    
                                })
                            }
                        })
                        .catch( error => {
                            // console.log(error)
                        })
                }
            }

                function llenarInputs(resultado) {
                    // console.log(resultado)
                    document.querySelector('#direccion').value = resultado.address.Address || '';
                    document.querySelector('#sector').value = resultado.address.Neighborhood || '';
                    document.querySelector('#lat').value = resultado.latlng.lat || '';
                    document.querySelector('#lng').value = resultado.latlng.lng || '';
                }
        
            }  


    });