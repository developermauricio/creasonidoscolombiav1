<template>
    <vue2Dropzone class="dropzone upload-logo dropzone-area dz-clickable"
                  ref="myVueDropzone"
                  @vdropzone-file-added="uploadArchive"
                  @vdropzone-sending="sendingEvent"
                  @vdropzone-max-files-exceeded="maxFiles"
                  @vdropzone-success="addArchiveArtist"
                  @vdropzone-error="messagesError"
                  @vdropzone-removed-file="removedArchiveDropzoneAspirant"
                  id="dpz-archives-register-aspirant"
                  :options="dropzoneOptionsArchive">

    </vue2Dropzone>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
export default {
    name: "DropzoneUploadDocument",
    components: {
        vue2Dropzone,
    },
    data(){
        return{
            csrf_token: window.token,
            urlsArchiveArtist: [],

            dropzoneOptionsArchive: {
                url: '/api/upload-archive-aspirant',
                // thumbnailWidth: 200,
                maxFilesize: 10,  //Tamaño en MB
                maxFiles: 1, // Catidad maxima que se puede subir
                paramName: 'archive',
                acceptedFiles: "application/pdf",
                addRemoveLinks: true,
                dictDefaultMessage: 'Clic aquí o arrastre su documento pdf. El Peso maximo del archivo debe ser de 10Mb',
                dictMaxFilesExceeded: 'No es posible agregar más archivos. Limite maximo 1',
                dictFileTooBig: 'El archivo es demasiado grande, su peso es' + " ({{filesize}} Mb). " + 'El tamaño máximo del archivo debe ser de' + " {{maxFilesize}} Mb.",
                dictRemoveFile: 'Remover Archivo',
                dictInvalidFileType: 'No puede cargar archivos de este tipo.',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token //Este token lo pasamos por los props
                },
                // params: {id: this.entity_get_data.id}  //Para enviar parametros
            },
        }
    },

    props:['name', 'lastName', 'documentAspirantPdf', 'editAspirant' , 'documentAspirantPhotoFrontal' , 'documentAspirantPhotoBack'],

    methods:{
        messagesError(file, message, xhr){
            this.$refs.myVueDropzone.removeFile(file);
            setTimeout(()=>{
                this.$vs.loading.close()
            }, 500)
            this.$toast.error({
                title: 'Error',
                message: message,
                showDuration: 1000,
                hideDuration: 20000,
                position: 'top right',
            })
        },

        sendingEvent(file, xhr, formData) {
            formData.append('nameAspirant', this.name +'-'+ this.lastName);
            formData.append('archiveUuid', file.upload.uuid);
            // if (this.editAspirant){
            //     console.log('ESTAMOS AQUI', this.documentAspirantPhotoFrontal)
            //     if (this.documentAspirantPdf){
            //         const data = new FormData();
            //         data.append("archiveArtist", this.documentAspirantPdf);
            //         axios.post('/api/removed-archive-aspirant-pdf', data)
            //             .then(resp => {
            //                 this.$toast.success({
            //                     title: '¡Muy bien!',
            //                     message: 'El archivo se quitó correctamente',
            //                     showDuration: 1000,
            //                     hideDuration: 5000,
            //                     position: 'top right',
            //                 })
            //                 this.urlsArchiveArtist.splice(i, 1);
            //             }).catch(err => {
            //             this.$toast.error({
            //                 title: 'Error',
            //                 message: '¡Algo salió mal!',
            //                 showDuration: 1000,
            //                 hideDuration: 5000,
            //                 position: 'top right',
            //             })
            //         });
            //     }
            //
            //     /*=============================================
            //         ELIMINAMOS LAS FOTOS
            //     =============================================*/
            //     if (this.documentAspirantPhotoFrontal && this.documentAspirantPhotoBack){
            //         /*=============================================
            //             ELIMINACIÓN FOTO FRONTAL
            //          =============================================*/
            //         console.log('URL', this.documentAspirantPhotoFrontal)
            //         const data = new FormData();
            //         data.append("archiveArtistPhotoFrontal", this.documentAspirantPhotoFrontal);
            //         axios.post('/api/removed-archive-aspirant-photo-frontal', data)
            //             .then(resp => {
            //                 this.$toast.success({
            //                     title: '¡Muy bien!',
            //                     message: 'La foto se quitó correctamente',
            //                     showDuration: 1000,
            //                     hideDuration: 5000,
            //                     position: 'top right',
            //                 })
            //                 this.urlsArchiveArtistFrontal.splice(i, 1);
            //             }).catch(err => {
            //             this.$toast.error({
            //                 title: 'Error',
            //                 message: '¡Algo salió mal!',
            //                 showDuration: 1000,
            //                 hideDuration: 5000,
            //                 position: 'top right',
            //             })
            //         });
            //
            //         data.append("archiveArtistPhotoBack", this.documentAspirantPhotoBack);
            //         axios.post('/api/removed-archive-aspirant-photo-back', data)
            //             .then(resp => {
            //                 this.$toast.success({
            //                     title: '¡Muy bien!',
            //                     message: 'La foto se quitó correctamente',
            //                     showDuration: 1000,
            //                     hideDuration: 5000,
            //                     position: 'top right',
            //                 })
            //                 this.urlsArchiveArtistBack.splice(i, 1);
            //             }).catch(err => {
            //             this.$toast.error({
            //                 title: 'Error',
            //                 message: '¡Algo salió mal!',
            //                 showDuration: 1000,
            //                 hideDuration: 5000,
            //                 position: 'top right',
            //             })
            //         });
            //     }
            // }
        },

        maxFiles(file) {
            this.$refs.myVueDropzone.removeFile(file);
            setTimeout(() =>{
                this.$vs.loading.close()
            }, 500)
        },

        uploadArchive(file){
            this.$vs.loading({
                color: '#11435b',
                text: 'Subiendo documento espere un momento por favor...'
            })
            let name = this.name
            let last_name = this.lastName
            if (name === '' && last_name === ''){
                this.$refs.myVueDropzone.removeFile(file)
                this.$toast.error({
                    title: 'Atención',
                    message: 'Para agregar el archivo del documento, primero debes ingresar tu nombre, apellido',
                    showDuration: 300,
                    hideDuration: 8000,
                    position: 'top right',
                })
            }
            console.log('ARCHIVO', file)
            console.log('ARCHIVO', file.status)
            this.$vs.loading.close()
        },

        addArchiveArtist(file, response) {

            this.urlsArchiveArtist.push({
                nameArchive: file.name,
                urlArchive: response.data,
                uuid: response.uuid,
                extension: response.extension
            })
            setTimeout(() => {
                $("#dpz-archives-register-aspirant").removeClass("is-invalid");
                this.$toast.success({
                    title: '¡Muy bien!',
                    message: 'Archivo subido correctamente',
                    showDuration: 1000,
                    hideDuration: 5000,
                    position: 'top right',
                })
                this.$vs.loading.close()
            }, 1000);
            this.$emit('dataUrl', this.urlsArchiveArtist);
        },

        removedArchiveDropzoneAspirant(file, error, xhr) {
            console.log('remove file ', file.upload.uuid);
            let uuid = file.upload.uuid

            for (let i = 0; i < this.urlsArchiveArtist.length; i++)
                if (this.urlsArchiveArtist[i].uuid === uuid) {
                    const data = new FormData();
                    data.append("archiveArtist", this.urlsArchiveArtist[i].urlArchive);
                    axios.post('/api/removed-archive-aspirant-pdf', data)
                        .then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'El archivo se quitó correctamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.urlsArchiveArtist.splice(i, 1);
                        }).catch(err => {
                        this.$toast.error({
                            title: 'Error',
                            message: '¡Algo salió mal!',
                            showDuration: 1000,
                            hideDuration: 5000,
                            position: 'top right',
                        })
                    });
                    break;
                }
        },
    }
}
</script>

<style scoped>
#dpz-archives-register-aspirant{
    text-align: center !important;
}
</style>
