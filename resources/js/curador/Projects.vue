<template>
    <div>
       <div class="card">
            <div class="card-body">
                <vs-collapse accordion>
                    <vs-collapse-item v-for="(project, index) in projects.data" :key="project.id">
                        <div slot="header" >
                            <div class="row">
                                <div class="col-1">
                                    {{ index+1 }}
                                </div>
                                <div class="col-8" >
                                    <h5 @click="selectProject(project)">Clic para escuchar la canción # {{ index+1}}</h5>
                                </div>
                                <div class="col-3">
                                    <img width="100" :src="project.id === (selectedProject ? selectedProject.id : 0) ? '/img/gif-music-play.gif':''" alt="">
                                </div>
                            </div>
                        </div>
                       <div class="row">
                           <div class="col-md-6 pt-3">
                               <h2>Calida interpretativa</h2>
                               <vs-slider :min="0" :max="20" color="#11435b" v-model="value"/>
                           </div>
                           <div class="col-md-6 pt-3">
                               <input-form
                                   type="textarea"
                                   label="Descripción"
                                   id="txtDescription"
                                   pattern="all"
                                   errorMsg="Ingrese información válida"
                                   requiredMsg="Este campo es requerido"
                                   :required="false"
                                   :modelo.sync="description"
                                   :msgServer.sync="errors.description"
                                   :options="{
                                                rows: 5
                                                }"
                               >
                               </input-form>
                           </div>
                       </div>
                    </vs-collapse-item>
                </vs-collapse>
                <pagination align="center" :data="projects" @pagination-change-page="getProjects"></pagination>
            </div>
        </div>
        <div class="card fixed-player">
            <div class="card-body">
                <vue-plyr ref="plyr" >
                    <audio controls crossorigin playsinline>
                        <source
                            :src="currentAudio"
                            type="audio/mp3"
                        />
                    </audio>
                </vue-plyr>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination'
import MediaAudio from "../components/MediaAudio";

export default {
    name: "Projects",
    data() {
        return {
            description: '',
            selectedProject: null,
            projects: {},
            currentAudio: null,
            qualifications:[],
            value: 0,
            errors: {},
        }
    },
    components: {
        pagination,
        MediaAudio
    },

    props:['user'],

    methods: {
        async getProjects(page = 1) {
            await axios.get(`/api/curador/projects/${this.user.id}?page=${page}`).then(({data}) => {
                this.projects = data
            }).catch(({response}) => {
                console.error(response)
            })
        },

        selectProject(project) {
                this.$vs.loading({
                    color: '#11435b',
                    text: 'Cargando...'
                })
            setTimeout(() =>{
                this.$refs.plyr.player.source = {
                    type: 'audio',
                    title: 'Example title',
                    sources: [
                        {
                            src: project.audio,
                            type: 'audio/mp3',
                        },
                    ],
                };
                this.$refs.plyr.player.play()
                this.$vs.loading.close()

                this.selectedProject = project
            }, 200)
        },

        getQualifications(){
            axios.get('/curador/get-qualifications').then(resp =>{
                this.qualifications = resp.data.data
            }).catch(err =>{

            })
        }
    },

    mounted() {
        this.getProjects()
        this.$refs.plyr.player.on('pause', () => {
            this.selectedProject = null
        })
    }
}
</script>

<style scoped>
.fixed-player{
    position: fixed;
    bottom: 4rem;
    width: 100%;
    left: 0;
    z-index: 200 !important;
}
</style>
