<template>
    <div>
        <input type="hidden" @click="loadDataProjects" id="listProjectsComponents"/>

        <div class="row">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header">
                        <h3>Lista de aspirantes</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-3">
                                <label>Buscar aspirante</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon-search1"><i
                                            data-feather="search"></i></span>
                                    </div>
                                    <input type="text" v-model="filters.name.value" class="form-control"
                                           placeholder="Buscar..." aria-label="Search..."
                                           aria-describedby="basic-addon-search1"/>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3">
                                <input-form
                                    label="Filtar por categoría"
                                    id="textFilterDepartament"
                                    errorMsg
                                    requiredMsg="La modalidad es requerida"
                                    :required="false"
                                    :modelo.sync="categoryFilterSelected"
                                    :msgServer.sync="errors.categoryFilterSelected"
                                    type="multiselect"
                                    selectLabel="Filtrar por categoría"
                                    :multiselect="{ options: optionsCategories,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Seleccionar Categoría',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'category',
                                          'custom-label': category=>category.category
                                        }"
                                ></input-form>
                            </div>
                           <!--  <div class="col-12 col-lg-3 col-md-3">
                                <input-form
                                    label="Filtar por departamento"
                                    id="textFilterDepartament"
                                    errorMsg
                                    requiredMsg="La modalidad es requerida"
                                    :required="false"
                                    :modelo.sync="departamentFilterSelected"
                                    :msgServer.sync="errors.departamentFilterSelected"
                                    type="multiselect"
                                    selectLabel="Filtrar por departamento"
                                    :multiselect="{ options: optionsDepartaments,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Seleccion un departamento',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': departament=>departament.descripcion
                                        }"
                                ></input-form>
                            </div> -->
                        </div>
                        <div class="table-responsive">
                            <v-table
                                stripe
                                class="table table-striped table-hover"
                                max-items="5"
                                pagination
                                :filters="filters"
                                :data="listProjects"
                                :hideSortIcons="true"
                                :currentPage.sync="currentPageChild"
                                :pageSize="10"
                                @totalPagesChanged="totalPagesChild = $event"
                            >
                                <template class="thead-default" slot="head">
                                    <thead>
                                    <tr>
                                        <v-th sortKey="aspirant[0].user.name">#</v-th>
                                        <v-th sortKey="aspirant[0].user.name">Nombres</v-th>
                                        <v-th sortKey="aspirant[0].user.last_name" >Apellidos</v-th>
                                        <v-th sortKey="aspirant[0].user.city.departament.descripcion">Departamento
                                        </v-th>
                                        <v-th sortKey="aspirant[0].user.city.descripcion">Ciudad</v-th>
                                        <v-th>Actuará como</v-th>
                                        <v-th>Trayectoria</v-th>
                                        <v-th>Acciones</v-th>
                                    </tr>
                                    </thead>
                                    <div class="d-flex justify-content-center" v-if="noData">
                                        <h3 style="text-align: center">No hay aspirantes registrados</h3>
                                    </div>
                                </template>
                                <template slot="body" slot-scope="{displayData}" class="table-striped">
                                    <tr v-if="!projects || projects.length<1">
                                        <td>No hay aspirantes registrados</td>
                                    </tr>
                                    <tr :class="addClassSubsandor(listProjects.id) || listProjects.id === (selectedProject ? selectedProject.id : selectedProjectShow) ? 'row-project' : ''"
                                        v-for="(listProjects, index) in displayData" :key="listProjects.id">

                                        <td>{{ index + 1 }}</td>
                                        <td >{{ listProjects.aspirant[0].user.name }}</td>
                                        <td >{{ listProjects.aspirant[0].user.last_name }}</td>
                                        <td>{{ listProjects.aspirant[0].user.city.departament.descripcion }}</td>
                                        <td>{{ listProjects.aspirant[0].user.city.descripcion }}</td>
                                        <td>{{ listProjects.aspirant[0].aspirant_type.name }}</td>
                                        <td>{{ listProjects.aspirant[0].category_aspirant.name }}</td>
                                        <td>
                                            <div class="demo-inline-spacing">
                                                <button @click="showProject(listProjects)"
                                                        :disabled="disabledButtonSubsanador(listProjects.id)"
                                                        data-target="modal-show-project"
                                                        data-toggle="modal"
                                                        class="btn btn-icon btn-primary waves-effect waves-float waves-light">
                                                    <vs-tooltip :text="selectNameSubsanador(listProjects.id)">
                                                        <span class="material-icons">visibility</span>
                                                    </vs-tooltip>
                                                </button>
                                                <button @click="selectPlayProject(listProjects)" type="button"
                                                        class="btn btn-icon btn-primary btn-reproductor waves-effect waves-float waves-light">
                                                <span class="material-icons">
                                                    {{
                                                        listProjects.id === (selectedProject ? selectedProject.id : 0) ? 'pause' : 'play_arrow'
                                                    }}
                                                </span>

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
        </div>
        <div class="card fixed-player" v-show="showReproductor">
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
import {subscriberMQTT, publishMQTT} from '../../plugins/mqtt';

export default {
    name: "ListProjectBySubsanar",
    components: {
        MediaAudio
    },
    data() {
        return {
            currentAudio: {
                id: null
            },
            optionsDepartaments: [],
            optionsCategories: [],
            departamentFilterSelected: null,
            categoryFilterSelected: null,
            noData: false,
            userSubsanador: window.user,
            userSubsanadorId: window.user_ìd,
            showReproductor: false,
            selectedProject: null,
            selectedSubsanadorProject: [],
            selectedUserSubsanador: null,
            selectedProjectShow: null,
            lineFilterSelected: null,
            nameMusic: null,
            nameAuthor: null,
            currentPageUser: 1,
            totalPagesUser: 0,
            currentPageChild: 1,
            totalPagesChild: 0,
            aspirantType: [],
            filters: {
                name: {value: "", custom: this.search}
            },
            errors: {},
            projects: [],
            role:  window.role
        }
    },
    methods: {
        search(filterValue, row) {
            if (filterValue) {
                let name = row.aspirant[0].user.name.toLowerCase()
                let lastName = row.aspirant[0].user.last_name.toLowerCase()
                let city = row.aspirant[0].user.city.descripcion.toLowerCase()
                let modalidade = row.aspirant[0].category_aspirant.name.toLowerCase()
                let departament = row.aspirant[0].user.city.departament.descripcion.toLowerCase()
                let exist = name.includes(filterValue.toLowerCase()) ||
                    lastName.includes(filterValue.toLowerCase()) ||
                    city.includes(filterValue.toLowerCase()) ||
                    departament.includes(filterValue.toLowerCase()) ||
                    modalidade.includes(filterValue.toLowerCase())
                if (!exist) {
                    this.noData = false;
                }
                console.log(exist);
                return exist;
            } else {
                return true;
            }
        },
        selectNameSubsanador(idProject) {
            if (this.selectedSubsanadorProject.length > 0) {
                let disabled = 'Mas información'
                this.selectedSubsanadorProject.map(item => {
                    if (item.project.id === idProject) {
                        disabled = `Esta siendo subsanado por ${item.user.name}`
                    }
                })
                return disabled
            } else {
                return 'Mas información';
            }
        },
        addClassSubsandor(idProject) {
            if (this.selectedSubsanadorProject.length > 0) {
                let disabled = ''
                this.selectedSubsanadorProject.map(item => {
                    if (item.project.id === idProject) {
                        disabled = 'row-select-subsanador';
                        this.updateEditProjectDb(item.project.id)
                        this.selectedUserSubsanador = item.user.name
                    }
                })
                return disabled
            } else {
                return '';
            }
        },
        disabledButtonSubsanador(idProject) {
            if (this.selectedSubsanadorProject.length > 0) {
                let disabled = false
                this.selectedSubsanadorProject.map(item => {
                    if (item.project.id === idProject) {
                        disabled = true;
                    }
                })
                return disabled
            } else {
                return false;
            }
        },
        getDeparments() {
            axios.get('/api/get-departaments').then(resp => {
                this.optionsDepartaments = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al AdministradorD',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        getCategories() {
            axios.get('/api/get-project-categories').then(resp => {
                this.optionsCategories = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al AdministradorD',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        async loadDataProjects() {
            this.$vs.loading({
                color: "#11435b",
                text: "Cargando...",
            });
            await axios
                .get('/api/subsanador/get-projects')
                .then(resp => {
                    this.projects = resp.data.data;
                    this.$emit('loadDataCardProjects')
                    this.$vs.loading.close();
                })
                .catch(error => {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Hubo un error, consulte al AdministradorD',
                        showDuration: 1000,
                        hideDuration: 12000,
                    })
                    this.$vs.loading.close();
                });
            this.$refs.plyr.player.stop();
        },
        showProject(project) {
            this.$vs.loading({
                color: "#11435b",
                text: "Cargando...",
            });
            const data = {
                user: {
                    id: this.userSubsanadorId,
                    name: this.userSubsanador
                },
                project: project
            }
            this.$emit('dataProject', project)
            publishMQTT('subsanador_edit', data)
            setTimeout(() => {
                this.$vs.loading.close();
                $('#modal-show-project').modal();
            }, 500);

        },
        selectedSubsanador() {
            let key = 'notification_subsanardor_31231090'
            let topic = 'subsanador_edit'

            subscriberMQTT(key, topic, this.userSubsanadorActual)
        },
        deselectSubsanador() {
            let key = 'notification_subsanardor_31231347162'
            let topic = 'subsanador_edit_close'

            subscriberMQTT(key, topic, this.deselectUserSubsanador)
        },

        mqttLoadDataListProjects() {
            let key = 'notification_subsanardor_3123102'
            let topic = 'mqtUpdateProjects'

            subscriberMQTT(key, topic, this.reloadDataListProjects)
        },

        reloadDataListProjects() {
            this.loadDataProjects()
        },

        userSubsanadorActual(data) {
            const dataSelected = JSON.parse(data)
            if (dataSelected.user.id !== this.userSubsanadorId) {
                this.selectedSubsanadorProject.push(dataSelected)
            }
        },
        deselectUserSubsanador(data) {
            const parseData = JSON.parse(data);
            if (this.selectedSubsanadorProject.length > 0) {
                for (let i = 0; i < this.selectedSubsanadorProject.length; i++) {
                    if (this.selectedSubsanadorProject[i].project.id === parseData.id) {
                        this.updateEditProjectDb(this.selectedSubsanadorProject[i].project.id)
                        this.selectedSubsanadorProject.splice(i, 1);
                    }
                }
            }
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
                    this.nameAuthor = project.aspirant[0].user.name + ' ' + project.aspirant[0].user.last_name
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

                }, 200);
                window.currentSon = project
                this.selectedProject = project;
            }
        },

        updateEditProjectDb(idProject) {
            axios.post(`/api/subsanador/update-edit-project/${idProject}`).then(resp => {
                console.log(resp)
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Error al enviar el id del proyecto a la DB para editar.',
                    showDuration: 1000,
                    hideDuration: 8000,
                })
            })
        },

        getAspirantType() {
            axios.get('/api/get-aspirant-types').then(resp => {
                this.aspirantType = resp.data.data
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al AdministradorD',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
    },
    computed: {

    listProjects: function () {
            let selectedCategory = this.categoryFilterSelected
            let selectedLine = this.lineFilterSelected
            let listProjects = []
            let listProjectsLine = []
            if (selectedCategory === null || selectedCategory === 0) {
                listProjects = this.projects
                return listProjects;
            }
            if (this.categoryFilterSelected) {
                this.projects.filter(item => {
                    let filtered = false
                    if (item.category_id === selectedCategory.id) {
                        //filtered = true
                        listProjects.push(item)
                    }
                    
                    /*if (filtered === true) {
                        listProjects.push(item)
                    }*/
                })
                return listProjects;
            }

            if (selectedLine === null || selectedLine === 0) {
                listProjectsLine = this.projects
                return listProjectsLine;
            }
            if (this.lineFilterSelected) {
                this.projects.filter(item => {
                    let filtered = false
                    if (selectedLine) {
                        if (item.id === selectedLine.id) {
                                filtered = true
                            }
                    }
                    if (filtered === true) {
                        listProjectsLine.push(item)
                    }
                })
                return listProjectsLine
            }
        }
        /*listProjects: function () {
            let selectedDepartament = this.departamentFilterSelected
            let selectedLine = this.lineFilterSelected
            let listProjects = []
            let listProjectsLine = []
            if (selectedDepartament === null || selectedDepartament === 0) {
                listProjects = this.projects
                return listProjects;
            }
            if (this.departamentFilterSelected) {
                this.projects.filter(item => {
                    let filtered = false
                    if (selectedDepartament) {
                        item.aspirant.filter(aspirant => {
                            if (aspirant.user.city.departament.id === selectedDepartament.id) {
                                filtered = true
                            }
                        })
                    }
                    if (filtered === true) {
                        listProjects.push(item)
                    }
                })
                return listProjects;
            }

            if (selectedLine === null || selectedLine === 0) {
                listProjectsLine = this.projects
                return listProjectsLine;
            }
            if (this.lineFilterSelected) {
                this.projects.filter(item => {
                    let filtered = false
                    if (selectedLine) {
                        item.aspirant.filter(aspirant => {
                            if (aspirant.aspirantType.id === selectedLine.id) {
                                filtered = true
                            }
                        })
                    }
                    if (filtered === true) {
                        listProjectsLine.push(item)
                    }
                })
                return listProjectsLine
            }
        }*/
    },
    mounted() {
        this.loadDataProjects();
        this.getDeparments();
        this.getCategories();
        this.selectedSubsanador();
        this.deselectSubsanador();
        this.mqttLoadDataListProjects();
        this.getAspirantType();

        this.$refs.plyr.player.on("pause", () => {
            this.selectedProject = null
        })
        this.$refs.plyr.player.on("play", () => {
            this.selectedProject = window.currentSon
        })
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

.smart-pagination {
    overflow: auto !important;
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

.demo-inline-spacing > * {
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

tr.row-project {
    background-color: rgba(0, 205, 199, 0.37);
}

tr.row-project:hover {
    background-color: rgba(0, 205, 199, 0.37) !important;
}

tr.row-select-subsanador {
    background-color: rgba(170, 71, 188, 0.42);
}

tr.row-select-subsanador:hover {
    background-color: rgba(170, 71, 188, 0.42) !important;
}

tr:hover {
    background-color: #e7e7e7;
}
</style>
