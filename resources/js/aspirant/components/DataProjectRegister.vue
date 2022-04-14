<template>
<div class="pt-1">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6">
            <input-form
                id="txtProjectName"
                label="Título de la canción"
                pattern="all"
                errorMsg="Ingrese un título válido"
                requiredMsg="El título de la canción es requerido"
                :modelo.sync="project.name"
                :required="true"
                :msgServer.sync="errors.name"
            ></input-form>
        </div>
        <div class="col-12 col-lg-6 col-md-6">
            <input-form
                id="txtProjectNameAuthor"
                label="Nombre del intérprete o agrupación"
                pattern="all"
                errorMsg="Ingrese un nombre del intérprete o agrupación válido"
                requiredMsg="El nombre del intérprete o agrupación requerido"
                :modelo.sync="project.nameAuthor"
                :required="true"
                :msgServer.sync="errors.nameAuthor"
            ></input-form>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <input-form
                id="txtProjectCategoryByAspirant"
                label="Género musical de la canción"
                pattern="all"
                errorMsg="Ingrese un género válido"
                requiredMsg="Género de la canción"
                :modelo.sync="project.categoryByAspirant"
                :required="true"
                :msgServer.sync="errors.categoryByAspirant"
            ></input-form>
<!--            <input-form-->
<!--                label="Modalidad o categoría de la canción"-->
<!--                id="textProjectCategory"-->
<!--                errorMsg-->
<!--                requiredMsg="La modalidad o categoría es obligatorio"-->
<!--                :required="true"-->
<!--                :modelo.sync="project.category"-->
<!--                :msgServer.sync="errors.category"-->
<!--                type="multiselect"-->
<!--                selectLabel="Seleccione modalidad"-->
<!--                :multiselect="{ options: optionsProjectCategory,-->
<!--                                           selectLabel:'Seleccionar',-->
<!--                                           selectedLabel:'Seleccionado',-->
<!--                                           deselectLabel:'Desmarcar',-->
<!--                                           placeholder:'Seleccione modalidad',-->
<!--                                          taggable : false,-->
<!--                                          'track-by':'id',-->
<!--                                          label: 'category',-->
<!--                                          'custom-label': category=>category.category-->
<!--                                        }"-->
<!--            ></input-form>-->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input-form
                type="textarea"
                label="Escriba aquí una breve reseña"
                id="txtProjectDescription"
                pattern="all"
                errorMsg="Ingrese texto válido"
                requiredMsg="La reseña es requerida"
                :required="true"
                :modelo.sync="project.description"
                :msgServer.sync="errors.description"
                :options="{
                                                rows: 5
                                                }"
            >
            </input-form>
        </div>
    </div>
    <!--=====================================
           COMPONENTE PARA SUBIR EL AUDIO
       ======================================-->
    <dropzone-upload-music v-on:dataUrlMusicPrincipal="datUrlDropzoneMusicPrincipal" v-on:dataUrlMusicOpcional="datUrlDropzoneMusicOpcional" :nameProject="project.name" :name="name" :lastName="last_name" ></dropzone-upload-music>
</div>
</template>

<script>
export default {
    name: "DataProjectRegister",
    data(){
        return{
            errors: {},
            optionsProjectCategory: [],
            project: {
                name: '',
                nameAuthor: '',
                category: null,
                categoryByAspirant: null,
                dataArchiveMusicPrincipal: [],
                dataArchiveMusicOpcional: [],
                description: ''
            }
        }
    },
    props:['name', 'last_name'],
    methods: {
        getProjectCategories() {
            this.$vs.loading({
                color: '11435b',
                text: 'Espere un momento por favor...'
            })
            setTimeout(() => {
                axios.get('/api/get-project-categories').then(resp => {
                    this.optionsProjectCategory = resp.data.data
                    this.$vs.loading.close()
                }).catch(err => {
                    console.log(err)
                    this.$toast.error({
                        title: 'Error',
                        message: 'Algo salió mal, consulte al administrador',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    this.$vs.loading.close()
                })
            }, 200)

        },
        datUrlDropzoneMusicPrincipal(data){
            this.project.dataArchiveMusicPrincipal = data
            this.$emit('datUrlMusicPrincipal', this.project.dataArchiveMusicPrincipal);
        },
        datUrlDropzoneMusicOpcional(data){
            this.project.dataArchiveMusicOpcional = data
            this.$emit('datUrlMusicOpcional', this.project.dataArchiveMusicOpcional);
        }
    },
    // watch:{
    //   project: function (data) {
    //
    //
    //   }
    // },
    mounted() {
        this.$emit('dataRegisterProject', this.project);
        this.getProjectCategories()
    }
}
</script>

<style scoped>

</style>
