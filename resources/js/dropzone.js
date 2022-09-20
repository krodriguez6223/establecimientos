const { default: axios } = require("axios");


document.addEventListener('DOMContentLoaded', () =>{

    
    if(document.querySelector('#dropzone')){

        Dropzone.autoDiscover = false;
    
        const dropzone = new Dropzone('div#dropzone', {
            
            url:'/imagenes/store',
            dictDefaultMessage:"Sube hasta 10 imagenes",
            acceptedFiles: ".png,.jpg,.jpeg,.gif",
            addRemoveLinks: true,
            dictRemoveFile: "Borrar imagen",
            maxFiles: 10,
            uploadMultiple:false,
            required:true,     
            headers: {   
            'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content
            },

            success: function(file, respuesta){
                file.nombreServidor = respuesta.archivo;
            },

            init: function(){
                const galeria = document.querySelectorAll('.galeria')
               
                if(galeria.length > 0){
                   
                    galeria.forEach(imagen =>{
                        const imagenPublicada = {};
                        imagenPublicada.size = 1;
                        imagenPublicada.name = imagen.value;
                        imagenPublicada.nombreServidor = imagen.value;

                        this.options.addedfile.call(this, imagenPublicada)
                        this.options.thumbnail.call(this, imagenPublicada,`/storage/${imagenPublicada.name}`)

                        imagenPublicada.previewElement.classList.add('dz-success');
                        imagenPublicada.previewElement.classList.add('dz-complete');
                   })
                }
            },

            sending: function(file, xhr, formData){          
               formData.append('uuid', document.querySelector('#uuid').value);
            },

            removedfile: function(file, respuesta){
                const params = {
                    imagen:file.nombreServidor
                }
                axios.post('/imagenes/destroy',params)
                .then( respuesta => {
                    //eliminar del DOM
                    file.previewElement.parentNode.removeChild(file.previewElement);
                })
            }
        })
    }
})
  