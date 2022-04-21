<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header">

                    </div>
                    <div class="card-body">

                    </div>
                    <div class="table-responsive">
                        <v-table
                            stripe
                            class="table table-striped table-hover"
                            max-items="5"
                            pagination
                            :data="projects"
                            :hideSortIcons="true"
                            :currentPage.sync="currentPageChild"
                            :pageSize="10"
                            @totalPagesChanged="totalPagesChild = $event"
                        >
                            <template class="thead-default" slot="head">
                                <thead>
                                <tr>
                                    <v-th sortKey="aspirant[0].user.name">Nombres</v-th>
                                    <v-th sortKey="aspirant[0].user.last_name">Apellidos</v-th>
                                    <v-th sortKey="aspirant[0].user.city.departament.descripcion">Departamento</v-th>
                                    <v-th sortKey="aspirant[0].user.city.descripcion">Ciudad</v-th>
                                    <v-th>Actuará como</v-th>
                                    <v-th>Trayectoria</v-th>
                                    <v-th>Acciones</v-th>
                                </tr>
                                </thead>
                            </template>
                            <template slot="body" slot-scope="{displayData}" class="table-striped">
                                <tr v-if="!projects || projects.length<1">
                                    <td>No se encuentrán madres registradas</td>
                                </tr>
                                <tr :class="listProjects.id === (selectedProject ? selectedProject.id : selectedProjectShow) ? 'row-project' : ''" v-for="(listProjects) in displayData" :key="listProjects.id">

                                    <td>{{ listProjects.aspirant[0].user.name }}</td>
                                    <td>{{ listProjects.aspirant[0].user.last_name }}</td>
                                    <td>{{ listProjects.aspirant[0].user.city.departament.descripcion }}</td>
                                    <td>{{ listProjects.aspirant[0].user.city.descripcion }}</td>
                                    <td>{{ listProjects.aspirant[0].aspirant_type.name }}</td>
                                    <td>{{ listProjects.aspirant[0].category_aspirant.name }}</td>
                                    <!--                    <td>{{projects.admission_date}}</td>-->
                                    <!--                    <td>{{projects.pregnant_time}} Meses Aproximadamente</td>-->
                                    <!--                    <td>{{projects.pregnant_quantity}}</td>-->
                                    <!--                    <td>-->
                                    <!--                        <a-->
                                    <!--                            :href="'/detail-child/' + mother.users.slug"-->
                                    <!--                            class="tabledit-edit-button text-center offset-md-2 btn btn-sm btn-primary"-->
                                    <!--                        >-->
                                    <!--                            <span class="ti-eye"></span>-->
                                    <!--                        </a>-->
                                    <!--                    </td>-->
                                    <td>
                                        <div class="demo-inline-spacing">
                                            <button @click="showProject(listProjects)" data-target="modal-show-project"
                                                    data-toggle="modal"
                                                    class="btn btn-icon btn-primary waves-effect waves-float waves-light">
                                                <span class="material-icons">visibility</span>
                                            </button>
                                            <button @click="selectPlayProject(listProjects)" type="button"
                                                    class="btn btn-icon btn-primary btn-reproductor waves-effect waves-float waves-light">
                                                <span class="material-icons">
                                                    {{ listProjects.id === (selectedProject ? selectedProject.id : 0) ? 'pause' : 'play_arrow' }}
                                                </span>
                                                <!--                                                <span class="material-icons">play_arrow</span>-->
                                                <!--                                                <span class="material-icons">stop</span>-->
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </v-table>
                        <div style="display: flex; justify-content: center">
                            <smart-pagination class="m-auto p-3" :currentPage.sync="currentPageChild"
                                              :totalPages="totalPagesChild"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card fixed-player" v-if="showReproductor">
            <div class="card-body">
                <div style="display: flex; justify-content: center">
                    <h4>{{ nameMusic ? nameMusic : '' }}</h4>
                </div>
                <div style="display: flex; justify-content: center">
                    <p>{{ nameAuthor ? nameAuthor : '' }}</p>
                </div>
                <vue-plyr ref="plyr">
                    <audio controls crossorigin playsinline>
                        <source :src="currentAudio" type="audio/mp3"/>
                    </audio>
                </vue-plyr>
            </div>
        </div>
    </div>
</template>

<script>
import MediaAudio from "../../components/MediaAudio";

export default {
    name: "ListProject",
    components: {
        MediaAudio
    },
    data() {
        return {
            currentAudio: {
                id: null
            },
            showReproductor: false,
            selectedProject: null,
            selectedProjectShow: null,
            nameMusic: null,
            nameAuthor: null,
            currentPageUser: 1,
            totalPagesUser: 0,
            currentPageChild: 1,
            totalPagesChild: 0,
            filters: {
                name: {value: "", keys: ["users.name", "users.last_name"]}
            },

            projects: []
        }
    },
    methods: {
        async loadDataProjects() {
            await axios
                .get('/api/subsanador/get-projects-revision')
                .then(resp => {
                    this.projects = resp.data.data;
                })
                .catch(error => {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Hubo un error, consulte al administrador',
                        showDuration: 1000,
                        hideDuration: 8000,
                    })
                });
        },
        showProject(project) {
            this.$vs.loading({
                color: "#11435b",
                text: "Cargando...",
            });
            this.$emit('dataProject', project)
            setTimeout(() => {
                this.$vs.loading.close();
                $('#modal-show-project').modal();
            }, 500);

        },
        selectPlayProject(project) {

            if (this.currentAudio.id !== project.id) {
                this.selectedProject = null
            }

            if (this.selectedProject !== null) {
                setTimeout(() => {
                    this.$refs.plyr.player.pause();
                    this.$refs.plyr.player.on("pause", () => {
                        this.selectedProject = null
                    });
                }, 500)
            } else if (this.currentAudio.id === project.id) {
                this.$refs.plyr.player.play();
                this.selectedProject = project;
            } else {
                this.showReproductor = true
                this.currentAudio = project;
                this.$vs.loading({
                    color: "#11435b",
                    text: "Cargando...",
                });
                setTimeout(() => {
                    this.nameMusic = project.title
                    this.nameAuthor = project.aspirant[0].user.name +' '+project.aspirant[0].user.last_name
                    this.$refs.plyr.player.source = {
                        type: "audio",
                        title: "Example title",
                        sources: [
                            {
                                src: project.audio,
                                type: "audio/mp3",
                            },
                        ],
                    };
                    this.$refs.plyr.player.play();
                    this.$vs.loading.close();

                    this.selectedProject = project;
                }, 200);
            }
        },
    },
    mounted() {
        this.loadDataProjects();
        this.$refs.plyr.player.on("pause", () => {

        })
        this.$refs.plyr.player.on("pause", () => {
            this.selectedProject = null
        });
    }
}
</script>

<style scoped>
.material-icons {
    font-size: 1rem;
}

.demo-inline-spacing {
    flex-wrap: inherit !important;
}

.fixed-player {
    position: fixed;
    bottom: 8.5rem;
    width: 100%;
    left: 0;
    z-index: 200 !important;
}

.btn-reproductor {
    background-color: #00CDC7 !important;
    border-color: #00CDC7 !important;
}
.demo-inline-spacing > *{
    margin-top: 1rem !important;
}
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
tr.row-project{
    background-color: rgba(0, 205, 199, 0.37);
}
tr.row-project:hover{
    background-color: rgba(0, 205, 199, 0.37) !important;
}
tr:hover {background-color: #e7e7e7;}
</style>
