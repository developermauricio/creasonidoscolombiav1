<template>
    <div class="row pb-1">
        <div class="col-12 col-md-12 col-lg-12">
            <label class="form-control-label" id="add-archive-music-principal-dropzone-aspirant">Subir canción <span style="color: red"> *</span></label>
            <vue2Dropzone class="dropzone upload-logo dropzone-area dz-clickable"
                          ref="myVueDropzone"
                          @vdropzone-file-added="uploadArchive"
                          @vdropzone-sending="sendingEvent"
                          @vdropzone-success="addArchiveMusicPrincipal"
                          @vdropzone-error="messagesError"
                          @vdropzone-removed-file="removedArchiveDropzoneMusicPrincipal"
                          id="dpz-archives-music-principal"
                          :options="dropzoneOptionsArchiveMusicPrincipal">

            </vue2Dropzone>
            <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
               id="text-verify-archive-music-principal" class="text-danger">Es obligatorio subir una canción</p>
        </div>
<!--        <div class="col-12 col-md-6 col-lg-6">-->
<!--            <label class="form-control-label" id="add-archive-music-opcional-dropzone-aspirant">Subir canciones opcionales </label>-->
<!--            <vue2Dropzone class="dropzone upload-logo dropzone-area dz-clickable"-->
<!--                          ref="myVueDropzoneOpcional"-->
<!--                          @vdropzone-sending="sendingEventOpcional"-->
<!--                          @vdropzone-max-files-exceeded="maxFilesOpcional"-->
<!--                          @vdropzone-success="addArchiveMusicOpcional"-->
<!--                          @vdropzone-error="messagesErrorOpcional"-->
<!--                          @vdropzone-removed-file="removedArchiveDropzoneMusicOpcional"-->
<!--                          id="dpz-archives-music-opcional"-->
<!--                          :options="dropzoneOptionsArchiveMusicOpcional">-->

<!--            </vue2Dropzone>-->
<!--        </div>-->
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
export default {
    name: "DropzoneUploadMusic",
    components: {
        vue2Dropzone,
    },
    data(){
        return{
            csrf_token: window.token,
            urlsArchiveMusicPrincipal: [],
            urlsArchiveMusicOpcional: [],

            dropzoneOptionsArchiveMusicPrincipal: {
                url: '/api/upload-archive-music-principal',
                // thumbnailWidth: 200,
                maxFilesize: 40,  //Tamaño en MB
                maxFiles: 1, // Catidad maxima que se puede subir
                paramName: 'archiveMusic',
                acceptedFiles: "audio/*,mp3, wav",
                addRemoveLinks: true,
                dictDefaultMessage: 'Clic aquí o arrastra su canción en formato mp3 o wav',
                dictMaxFilesExceeded: 'No es posible agregar más archivos. Limite maximo 1',
                dictFileTooBig: 'El archivo es demasiado grande, su peso es' + " ({{filesize}} MiB). " + 'El tamaño máximo del archivo debe ser de' + " {{maxFilesize}} MiB.",
                dictRemoveFile: 'Remover Archivo',
                dictInvalidFileType: 'No puede cargar archivos de este tipo.',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token //Este token lo pasamos por los props
                },

            },
            dropzoneOptionsArchiveMusicOpcional: {
                url: '/api/upload-archive-music-opcional',
                // thumbnailWidth: 200,
                maxFilesize: 40,  //Tamaño en MB
                maxFiles: 2, // Catidad maxima que se puede subir
                paramName: 'archiveMusicOpcional',
                acceptedFiles: "audio/*,mp3, wav",
                addRemoveLinks: true,
                dictDefaultMessage: 'Clic aquí o arrastra tu audios en formato mp3 o wav',
                dictMaxFilesExceeded: 'No es posible agregar más archivos. Limite maximo 2',
                dictFileTooBig: 'El archivo es demasiado grande, su peso es' + " ({{filesize}} MiB). " + 'El tamaño máximo del archivo debe ser de' + " {{maxFilesize}} MiB.",
                dictRemoveFile: 'Remover Archivo',
                dictInvalidFileType: 'No puede cargar archivos de este tipo.',
                headers: {
                    'X-CSRF-TOKEN': this.csrf_token //Este token lo pasamos por los props
                },
            },
        }
    },
    props:['nameProject', 'name', 'lastName', 'editArchiveAudio', 'urlArchiveAudio'],
    methods:{

        messagesError(file, message, xhr){
            this.$refs.myVueDropzone.removeFile(file);
            setTimeout(() =>{
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
            this.$vs.loading({
                color: '#11435b',
                text: 'Subiendo audio espere un momento por favor...'
            })
            console.log('upload file', file);
            formData.append('nameAspirant', this.name +'-'+ this.lastName);
            formData.append('nameProject', this.nameProject);
            formData.append('archiveUuid', file.upload.uuid);
            formData.append('archiveUuid', file.upload.uuid);
            if (this.editArchiveAudio){
                formData.append('editArchiveAudio', this.editArchiveAudio);
                formData.append('urlArchive', this.urlArchiveAudio);
            }
        },

        maxFiles(file) {
            this.$refs.myVueDropzone.removeFile(file);

            setTimeout(() =>{
                this.$vs.loading.close()
            }, 500)
            // this.$toast.error({
            //     title: 'Atención',
            //     message: 'No es posible agregar otra canción. Limite maximo 1',
            //     showDuration: 1000,
            //     hideDuration: 8000,
            //     position: 'top right',
            // })
        },

        addArchiveMusicPrincipal(file, response) {

            this.urlsArchiveMusicPrincipal.push({
                nameArchive: file.name,
                urlArchive: response.data,
                uuid: response.uuid,
                extension: response.extension
            })
            setTimeout(() => {
                $("#dpz-archives-music-principal").removeClass("is-invalid");
                this.$toast.success({
                    title: '¡Muy bien!',
                    message: 'Canción subida correctamente',
                    showDuration: 1000,
                    hideDuration: 5000,
                    position: 'top right',
                })
                this.$vs.loading.close()
            }, 1000);
            this.$emit('dataUrlMusicPrincipal', this.urlsArchiveMusicPrincipal);
        },

        removedArchiveDropzoneMusicPrincipal(file, error, xhr) {
            console.log('remove file ', file.upload.uuid);
            let uuid = file.upload.uuid

            for (let i = 0; i < this.urlsArchiveMusicPrincipal.length; i++)
                if (this.urlsArchiveMusicPrincipal[i].uuid === uuid) {
                    const data = new FormData();
                    data.append("archiveMusicPrincipal", this.urlsArchiveMusicPrincipal[i].urlArchive);
                    axios.post('/api/removed-archive-music-principal', data)
                        .then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'El archivo se quitó correctamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.urlsArchiveMusicPrincipal.splice(i, 1);
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
           EVENTOS PARA EL DROPZONE DE AUDIOS OPCIONAL
        =============================================*/
        messagesErrorOpcional(file, message, xhr){
            this.$refs.myVueDropzoneOpcional.removeFile(file);
            this.$toast.error({
                title: 'Error',
                message: message,
                showDuration: 1000,
                hideDuration: 20000,
                position: 'top right',
            })
        },

        sendingEventOpcional(file, xhr, formData) {
            console.log('upload file', file);
            formData.append('nameProject', this.nameProject);
            formData.append('nameAspirant', this.name +'-'+ this.lastName);
            formData.append('archiveUuid', file.upload.uuid);
        },

        // maxFilesOpcional(file) {
        //     this.$refs.myVueDropzoneOpcional.removeFile(file);
        //     this.$toast.error({
        //         title: 'Atención',
        //         message: 'No es posible agregar otra canción. Limite maximo 2',
        //         showDuration: 1000,
        //         hideDuration: 8000,
        //         position: 'top right',
        //     })
        // },

        uploadArchive(file){
            let nameProject = this.nameProject
            if (nameProject === ''){
                this.$refs.myVueDropzone.removeFile(file)
                this.$toast.error({
                    title: 'Atención',
                    message: 'Para agregar tu canción, primero debes ingresar el nombre de la canción',
                    showDuration: 1000,
                    hideDuration: 20000,
                    position: 'top right',
                })
                return
            }

        },

        addArchiveMusicOpcional(file, response) {
            this.urlsArchiveMusicOpcional.push({
                nameArchive: file.name,
                urlArchive: response.data,
                uuid: response.uuid,
                extension: response.extension
            })
            setTimeout(() => {
                $("#dpz-archives-music-principal").removeClass("is-invalid");
                this.$toast.success({
                    title: '¡Muy bien!',
                    message: 'Audio subido correctamente',
                    showDuration: 1000,
                    hideDuration: 5000,
                    position: 'top right',
                })
            }, 1000);
            this.$emit('dataUrlMusicOpcional', this.urlsArchiveMusicOpcional);
        },

        removedArchiveDropzoneMusicOpcional(file, error, xhr) {
            console.log('remove file ', file.upload.uuid);
            let uuid = file.upload.uuid

            for (let i = 0; i < this.urlsArchiveMusicOpcional.length; i++)
                if (this.urlsArchiveMusicOpcional[i].uuid === uuid) {
                    const data = new FormData();
                    data.append("archiveMusicOpcional", this.urlsArchiveMusicOpcional[i].urlArchive);
                    axios.post('/api/removed-archive-music-opcional', data)
                        .then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'El archivo se quitó correctamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.urlsArchiveMusicOpcional.splice(i, 1);
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
#dpz-archives-music-principal{
    text-align: center !important;
}
</style>
