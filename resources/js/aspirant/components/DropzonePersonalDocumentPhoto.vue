<template>
<div class="row mt-2">
    <div class="col-12 col-md-6 col-lg-6">
        <label class="form-control-label" id="add-archive-dropzone-photo-aspirant-frontal">Foto del documento lado frontal
            <span style="color: red"> *</span></label>
        <vue2Dropzone class="dropzone upload-logo dropzone-area dz-clickable"
                      ref="myVueDropzone"
                      @vdropzone-file-added="uploadPhotoFrontal"
                      @vdropzone-sending="sendingEventPhotoFrontal"
                      @vdropzone-max-files-exceeded="maxFilesPhotoFrontal"
                      @vdropzone-success="addArchiveArtistPhotoFrontal"
                      @vdropzone-error="messagesErrorPhotoFrontal"
                      @vdropzone-removed-file="removedArchiveDropzoneAspirantPhotoFrontal"
                      id="dpz-archives-register-aspirant-photo-frontal"
                      :options="dropzoneOptionsArchiveFrontal">

        </vue2Dropzone>
        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
           id="text-verify-archive-document-aspirant-photo-frontal" class="text-danger">La foto del lado frontal es requerida</p>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <label class="form-control-label" id="add-archive-dropzone-photo-aspirant-back">Foto del documento lado posterior
            <span style="color: red"> *</span></label>
        <vue2Dropzone class="dropzone upload-logo dropzone-area dz-clickable"
                      ref="myVueDropzone"
                      @vdropzone-file-added="uploadPhotoBack"
                      @vdropzone-sending="sendingEventPhotoBack"
                      @vdropzone-max-files-exceeded="maxFilesPhotoBack"
                      @vdropzone-success="addArchiveArtistPhotoBack"
                      @vdropzone-error="messagesErrorPhotoBack"
                      @vdropzone-removed-file="removedArchiveDropzoneAspirantPhotoBack"
                      id="dpz-archives-register-aspirant-photo-back"
                      :options="dropzoneOptionsArchiveBack">
        </vue2Dropzone>
        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
           id="text-verify-archive-document-aspirant-photo-back" class="text-danger">La foto del lado posterior es requerida</p>
    </div>
</div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
export default {
    name: "DropzonePersonalDocumentPhoto",
    components: {
        vue2Dropzone,
    },
    data(){
        return{
            csrf_token: window.token,
            urlsArchiveArtist: [],
            urlsArchiveArtistFrontal: [],
            urlsArchiveArtistBack: [],

            dropzoneOptionsArchiveFrontal: {
                url: '/api/upload-archive-document-photo-frontal',
                // thumbnailWidth: 200,
                maxFilesize: 10,  //Tamaño en MB
                maxFiles: 1, // Catidad maxima que se puede subir
                paramName: 'archive',
                acceptedFiles: ".jpg, .jpeg, .png",
                addRemoveLinks: true,
                dictDefaultMessage: 'Clic aquí o arrastre su foto o imagen de lado frontal en formato png, jpg, jpeg. El peso maximo de la imagen debe ser de 10Mb',
                dictMaxFilesExceeded: 'No es posible agregar más archivos. Límite maximo 1',
                dictFileTooBig: 'El archivo es demasiado grande, su peso es' + " ({{filesize}} Mb). " + 'El tamaño máximo del archivo debe ser de' + " {{maxFilesize}} Mb.",
                dictRemoveFile: 'Remover Foto',
                dictInvalidFileType: 'No puede cargar fotos de este tipo.',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token //Este token lo pasamos por los props
                },
                // params: {id: this.entity_get_data.id}  //Para enviar parametros
            },
            dropzoneOptionsArchiveBack: {
                url: '/api/upload-archive-document-photo-back',
                // thumbnailWidth: 200,
                maxFilesize: 10,  //Tamaño en MB
                maxFiles: 1, // Catidad maxima que se puede subir
                paramName: 'archive',
                acceptedFiles: ".jpg, .jpeg, .png",
                addRemoveLinks: true,
                dictDefaultMessage: 'Clic aquí o arrastre su foto o imagen del lado posterior en formato png, jpg, jpeg. El peso maximo de la imagen debe ser de 10Mb',
                dictMaxFilesExceeded: 'No es posible agregar más archivos. Límite maximo 1',
                dictFileTooBig: 'El archivo es demasiado grande, su peso es' + " ({{filesize}} Mb). " + 'El tamaño máximo del archivo debe ser de' + " {{maxFilesize}} Mb.",
                dictRemoveFile: 'Remover Foto',
                dictInvalidFileType: 'No puede cargar fotos de este tipo.',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token //Este token lo pasamos por los props
                },
                // params: {id: this.entity_get_data.id}  //Para enviar parametros
            },
        }
    },
    props:['name', 'lastName', 'documentAspirant', 'editAspirant'],

    methods:{
        /*=============================================
            FUNCIONES PARA SUBIR LA FOTO DEL LADO FRONTAL
         =============================================*/
        uploadPhotoFrontal(file){
            this.$vs.loading({
                color: '#11435b',
                text: 'Subiendo foto espere un momento por favor...'
            })
            let name = this.name
            let last_name = this.lastName
            if (name === '' && last_name === ''){
                this.$refs.myVueDropzone.removeFile(file)
                this.$toast.error({
                    title: 'Atención',
                    message: 'Para agregar la foto del documento, primero debes ingresar tu nombre y apellido',
                    showDuration: 300,
                    hideDuration: 8000,
                    position: 'top right',
                })
            }
            console.log('ARCHIVO', file)
            console.log('ARCHIVO', file.status)
            this.$vs.loading.close()
        },

        sendingEventPhotoFrontal(file, xhr, formData) {
            console.log('upload file', file);
            formData.append('nameAspirant', this.name +'-'+ this.lastName);
            formData.append('archiveUuid', file.upload.uuid);
            if (this.editAspirant){
                formData.append('editAspirant', this.editAspirant);
                formData.append('documentAspirant', this.documentAspirant);
            }
        },

        maxFilesPhotoFrontal(file) {
            this.$refs.myVueDropzone.removeFile(file);
            setTimeout(() =>{
                this.$vs.loading.close()
            }, 500)
        },
        addArchiveArtistPhotoFrontal(file, response) {
            this.urlsArchiveArtistFrontal.push({
                nameArchive: file.name,
                urlArchive: response.data,
                uuid: response.uuid,
                extension: response.extension
            })
            setTimeout(() => {
                $("#dpz-archives-register-aspirant-photo-frontal").removeClass("is-invalid");
                $("#text-verify-archive-document-aspirant-photo-frontal").css("display", "none");
                this.$toast.success({
                    title: '¡Muy bien!',
                    message: 'Foto subida correctamente',
                    showDuration: 1000,
                    hideDuration: 5000,
                    position: 'top right',
                })
                this.$vs.loading.close()
            }, 1000);
            this.$emit('documentUrlPhotoFrontal', this.urlsArchiveArtistFrontal);
        },
        messagesErrorPhotoFrontal(file, message, xhr){
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
        removedArchiveDropzoneAspirantPhotoFrontal(file, error, xhr) {
            console.log('remove file ', file.upload.uuid);
            let uuid = file.upload.uuid

            for (let i = 0; i < this.urlsArchiveArtistFrontal.length; i++)
                if (this.urlsArchiveArtistFrontal[i].uuid === uuid) {
                    const data = new FormData();
                    data.append("archiveArtistPhotoFrontal", this.urlsArchiveArtistFrontal[i].urlArchive);
                    axios.post('/api/removed-archive-aspirant-photo-frontal', data)
                        .then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'La foto se quitó correctamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.urlsArchiveArtistFrontal.splice(i, 1);
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

        /*=============================================
           FUNCIONES PARA SUBIR LA FOTO DEL LADO POSTERIOR
        =============================================*/
        uploadPhotoBack(file){
            this.$vs.loading({
                color: '#11435b',
                text: 'Subiendo foto espere un momento por favor...'
            })
            let name = this.name
            let last_name = this.lastName
            if (name === '' && last_name === ''){
                this.$refs.myVueDropzone.removeFile(file)
                this.$toast.error({
                    title: 'Atención',
                    message: 'Para agregar la foto del documento, primero debes ingresar tu nombre y apellido',
                    showDuration: 300,
                    hideDuration: 8000,
                    position: 'top right',
                })
            }
            console.log('ARCHIVO', file)
            console.log('ARCHIVO', file.status)
            this.$vs.loading.close()
        },

        sendingEventPhotoBack(file, xhr, formData) {
            console.log('upload file', file);
            formData.append('nameAspirant', this.name +'-'+ this.lastName);
            formData.append('archiveUuid', file.upload.uuid);
            if (this.editAspirant){
                formData.append('editAspirant', this.editAspirant);
                formData.append('documentAspirant', this.documentAspirant);
            }
        },

        maxFilesPhotoBack(file) {
            this.$refs.myVueDropzone.removeFile(file);
            setTimeout(() =>{
                this.$vs.loading.close()
            }, 500)
        },
        addArchiveArtistPhotoBack(file, response) {
            this.urlsArchiveArtistBack.push({
                nameArchive: file.name,
                urlArchive: response.data,
                uuid: response.uuid,
                extension: response.extension
            })
            setTimeout(() => {
                $("#dpz-archives-register-aspirant-photo-back").removeClass("is-invalid");
                $("#text-verify-archive-document-aspirant-photo-back").css("display", "none");
                this.$toast.success({
                    title: '¡Muy bien!',
                    message: 'Foto subida correctamente',
                    showDuration: 1000,
                    hideDuration: 5000,
                    position: 'top right',
                })
                this.$vs.loading.close()
            }, 1000);
            this.$emit('documentUrlPhotoBack', this.urlsArchiveArtistBack);
        },
        messagesErrorPhotoBack(file, message, xhr){
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
        removedArchiveDropzoneAspirantPhotoBack(file, error, xhr) {
            console.log('remove file ', file.upload.uuid);
            let uuid = file.upload.uuid

            for (let i = 0; i < this.urlsArchiveArtistBack.length; i++)
                if (this.urlsArchiveArtistBack[i].uuid === uuid) {
                    const data = new FormData();
                    data.append("archiveArtistPhotoBack", this.urlsArchiveArtistBack[i].urlArchive);
                    axios.post('/api/removed-archive-aspirant-photo-back', data)
                        .then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'La foto se quitó correctamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.urlsArchiveArtistBack.splice(i, 1);
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

</style>
