<template>
    <div>
        <div class="row">
            <!--=====================================
		        TARJETA DE ASPIRANTES POR SUBSANADAR
            ======================================-->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ needSubsanar }}</h2>
                            <p class="card-text">Aspirantes por Subsanar</p>
                        </div>
                        <div class="avatar bg-light-danger p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="user" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
		        TARJETA DE ASPIRANTES SUBSANADOS
            ======================================-->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ alreadySubsanar }}</h2>
                            <p class="card-text">Pendientes enviar a curaduría</p>
                        </div>
                        <div class="avatar bg-light-info p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
		        TARJETA DE ASPIRANTES CON CURADOR
            ======================================-->
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="font-weight-bolder mb-0">{{ curadorSubsanar }}</h2>
                            <p class="card-text">Enviados a Curadoría</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <vs-tabs color="#f54644">
            <vs-tab label="Pendientes por subsanar">
                <div class="con-tab-ejemplo">
                    <list-projects-by-subsanar-component v-on:loadDataCardProjects="loadDataCardProjects" v-on:dataProject="dataProject"></list-projects-by-subsanar-component>
                </div>
            </vs-tab>
            <vs-tab label="Todas las propuestas">
                <div class="con-tab-ejemplo">
                    <list-projects-component v-on:dataProject="dataProject"></list-projects-component>
                </div>
            </vs-tab>
        </vs-tabs>
        <show-projects-component v-on:loadDataListProject="loadDataProjects" :project="project"></show-projects-component>
    </div>
</template>

<script>
import {subscriberMQTT} from '../plugins/mqtt.js';
export default {
    name: "Projects",
    data(){
      return{
          project: null,
          needSubsanar: null,
          alreadySubsanar: null,
          curadorSubsanar: null,
      }
    },
    methods:{
        dataProject(data){
            this.project = data
        },
        loadDataProjects(){
            $('#listProjectsComponents').val('data').click();
        },
        async countNeedSubsanar(){
            await axios.get('/api/subsanador/count-need-subsanar').then(resp =>{
                this.needSubsanar = resp.data.data
            }).catch(err =>{
                this.$toast.error({
                    title: 'Error',
                    message: 'Hubo un error, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 12000,
                })
            })
        },
        async countAlreadySubsanar(){
            await axios.get('/api/subsanador/count-already-subsanar').then(resp =>{
                this.alreadySubsanar = resp.data.data
            }).catch(err =>{
                this.$toast.error({
                    title: 'Error',
                    message: 'Hubo un error, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 12000,
                })
            })
        },

        async countCuradorSubsanar(){
            await axios.get('/api/subsanador/count-curador-subsanar').then(resp =>{
                this.curadorSubsanar = resp.data.data
            }).catch(err =>{
                this.$toast.error({
                    title: 'Error',
                    message: 'Hubo un error, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 12000,
                })
            })
        },
        loadDataCardProjects(){
            this.countNeedSubsanar()
            this.countAlreadySubsanar()
            this.countCuradorSubsanar()
        }
    },

    mounted() {

    }
}
</script>

<style scoped>
/*.text-location{*/
/*    text-transform: lowercase;*/
/*}*/
/*.text-location:first-letter{*/
/*    text-transform: uppercase*/
/*}*/
</style>
