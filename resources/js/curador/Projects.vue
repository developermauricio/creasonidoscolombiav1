<template>
    <div>
        <div class="row">
            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i
                                    data-feather="users"
                                    class="font-medium-5"
                                ></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">
                            {{ countQualified }}
                        </h2>
                        <p class="card-text">Total Calificadas</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-danger p-50 mb-1">
                            <div class="avatar-content">
                                <i
                                    data-feather="users"
                                    class="font-medium-5"
                                ></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">{{ count }}</h2>
                        <p class="card-text">Por Calificar</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar bg-light-warning p-50 mb-1">
                            <div class="avatar-content">
                                <i
                                    data-feather="users"
                                    class="font-medium-5"
                                ></i>
                            </div>
                        </div>
                        <h2 class="font-weight-bolder">
                            {{ count + countQualified }}
                        </h2>
                        <p class="card-text">Total Asignadas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <vs-collapse accordion>
                    <vs-collapse-item
                        v-for="(project, index) in projects.data"
                        :key="project.id"
                        :not-arrow="true"
                    >
                        <!-- <div slot="header"> -->
                        <div @click="reset()" slot="header">
                            <div class="row">
                                <div class="col-1">
                                    {{ index + 1 }}
                                </div>
                                <div class="col-8">
                                    <h5 @click="selectProject(project)">
                                        Clic para escuchar la canción #
                                        {{ index + 1 }}
                                    </h5>
                                    <div
                                        v-if="project.state == 4"
                                        class="badge badge-light-success"
                                    >
                                        Calificado
                                    </div>
                                    <div
                                        v-else
                                        class="badge badge-light-warning"
                                    >
                                        Pendiente
                                    </div>
                                </div>
                                <div class="col-3">
                                    <img
                                        width="100"
                                        :src="
                                            project.id ===
                                            (selectedProject
                                                ? selectedProject.id
                                                : 0)
                                                ? '/img/gif-music-play.gif'
                                                : ''
                                        "
                                        alt=""
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div
                                    class="mt-2"
                                    v-for="qualifit in project.qualification"
                                    :key="qualifit.id"
                                >
                                    <!-- <div
                                    v-for="qualifit in qualifications"
                                    :key="qualifit.id"
                                > -->
                                    <h6>
                                        <vs-tooltip
                                            :text="qualifit.description"
                                        >
                                            {{ qualifit.name }}
                                            <vs-icon
                                                icon="help_outline"
                                                size="small"
                                                style="position: absolute"
                                                class="ml-1"
                                            ></vs-icon>
                                        </vs-tooltip>
                                    </h6>

                                    <!-- <div
                                        style="
                                            display: flex;
                                            justify-content: space-around;
                                        "
                                    >
                                        <vs-slider
                                            :min="0"
                                            :max="qualifit.value"
                                            color="#11435b"
                                            v-model="qualifit.model"
                                            :disabled="project.state == 4"
                                        />
                                        <span class="style-span">{{
                                            qualifit.model ? qualifit.model : 0
                                        }}</span>
                                    </div> -->
                                    <div
                                        style="
                                            display: flex;
                                            justify-content: space-around;
                                        "
                                    >
                                        <VueSlideBar
                                            v-model="qualifit.model"
                                            style="width: 100%"
                                            :min="0"
                                            :max="20"
                                            :tooltipStyles="{
                                                backgroundColor: '#004357',
                                                borderColor: '#004357',
                                            }"
                                            :processStyle="{
                                                backgroundColor: '#004357',
                                            }"
                                        ></VueSlideBar>

                                        <!-- <span class="style-span">{{
                                            qualifit.model ? qualifit.model : 0
                                        }}</span> -->
                                    </div>
                                </div>
                                <!-- <span>{{ qualifit.model }}</span> -->
                                <!-- :v-model="'value' + qualifit.id" -->
                            </div>
                            <div class="col-md-6 pt-3">
                                <input-form
                                    type="textarea"
                                    label="Observaciones"
                                    id="txtDescription"
                                    pattern="all"
                                    errorMsg="Ingrese información válida"
                                    requiredMsg="Este campo es requerido"
                                    :required="true"
                                    :modelo.sync="description"
                                    :msgServer.sync="errors.description"
                                    :options="{
                                        rows: 9,
                                    }"
                                    :disabled="project.state == 4"
                                >
                                </input-form>
                                <span v-if="total != 0" class="style-span"
                                    >Total calificación: {{ total }}</span
                                >
                                <a
                                    style="color: #00d5cc"
                                    @click="
                                        calcularTotal(project.qualification)
                                    "
                                    >{{
                                        total != 0
                                            ? "Actualizar"
                                            : "Ver Calificación"
                                    }}</a
                                >
                            </div>
                        </div>

                        <!-- <vs-button
                            class="d-flex ml-auto"
                            color="primary"
                            type="filled"
                            v-on:click="saveQualification(project.id)"
                            >Enviar Calificación</vs-button
                        > -->

                        <button
                            :disabled="!description"
                            v-on:click="saveQualification(project)"
                            class="btn btn-primary btn-block col-md-2 ml-auto"
                        >
                            Enviar Calificación
                        </button>
                    </vs-collapse-item>
                </vs-collapse>
                <pagination
                    color="red"
                    align="center"
                    :data="projects"
                    @pagination-change-page="getProjects"
                ></pagination>
            </div>
        </div>
        <div class="card fixed-player">
            <div class="card-body">
                <vue-plyr ref="plyr">
                    <audio controls crossorigin playsinline>
                        <source :src="currentAudio" type="audio/mp3" />
                    </audio>
                </vue-plyr>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import MediaAudio from "../components/MediaAudio";
import VueSlideBar from "vue-slide-bar";
import Swal from "sweetalert2";

export default {
    name: "Projects",
    data() {
        return {
            description: "",
            selectedProject: null,
            projects: {},
            currentAudio: null,
            qualifications: [],
            value: 0,
            errors: {},
            count: 0,
            countQualified: 0,
            total: 0,
        };
    },
    components: {
        pagination,
        MediaAudio,
        VueSlideBar,
    },

    props: ["user"],

    methods: {
        async getProjects(page = 1) {
            await axios
                .get(`/api/curador/projects/${this.user.id}?page=${page}`)
                .then(({ data }) => {
                    this.projects = data;
                    // .map((value) => {
                    //     let i = 1;
                    //     value.num += i;
                    //     console.log(value.num, "elvaluer");
                    //     return value;
                    // });
                    if (this.qualifications.length) {
                        this.projects.data.forEach((project) => {
                            let projectQuali = [];
                            this.qualifications.forEach((obj) => {
                                let newObject = Object.assign({}, obj);
                                newObject.model = 0;
                                projectQuali.push(newObject);
                            });
                            project.qualification = projectQuali;
                        });
                    }
                    console.log(
                        "calificaciones con proyecto: ",
                        this.projects.data
                    );
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        saveQualification(project) {
            const data = new FormData();
            data.append("interpretive_quality", project.qualification[0].model);
            data.append("quality_proposal", project.qualification[1].model);
            data.append("composition_quality", project.qualification[2].model);
            data.append("song_potential", project.qualification[3].model);
            data.append("territorial_value", project.qualification[4].model);
            data.append("comment", this.description);
            data.append("proyect_id", project.id);
            data.append("curadores_id", this.user.id);
            Swal.fire({
                title: "Confirmación de calificación",
                text: "¿Está seguro de guardar la calificación?",
                confirmButtonColor: "#11435b",
                cancelButtonColor: "#B53E2A",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                customClass: "swal-confirmation",
                showCancelButton: true,
                reverseButtons: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/api/curador/save-qualifications/", data)
                        .then((data) => {
                            window.location.reload();
                        })
                        .catch(({ response }) => {
                            console.error(response);
                        });
                }
            });
        },
        reset() {
            this.total = 0;
        },
        calcularTotal(qualification) {
            this.total = 0;
            qualification.forEach((item) => {
                this.total += item.model;
            });
        },
        selectProject(project) {
            this.$vs.loading({
                color: "#11435b",
                text: "Cargando...",
            });
            console.log(project);
            setTimeout(() => {
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
        },

        getQualifications() {
            axios
                .get("/api/curador/get-qualifications")
                .then((resp) => {
                    this.qualifications = resp.data.data;
                })
                .catch((err) => {});
        },
        async getProjectAsign() {
            await axios
                .get(`/api/curador/projects-asign/${this.user.id}`)
                .then(({ data }) => {
                    console.log(data, "dataCount");
                    return (this.count = data);
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        async getProjectQualified() {
            await axios
                .get(`/api/curador/projects-qualified/${this.user.id}`)
                .then(({ data }) => {
                    return (this.countQualified = data);
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
    },

    async mounted() {
        /* this.getProjects();
        this.getProjectAsign();
        this.getProjectQualified();
        this.getQualifications();
        this.$refs.plyr.player.on("pause", () => {
            this.selectedProject = null;
        }); */

        await this.getQualifications();
        await this.getProjects();
        this.getProjectAsign();
        this.getProjectQualified();
        this.$refs.plyr.player.on("pause", () => {
            this.selectedProject = null;
        });
    },
};
</script>

<style scoped>
.fixed-player {
    position: fixed;
    bottom: 8.5rem;
    width: 100%;
    left: 0;
    z-index: 200 !important;
}

.style-span {
    font-size: 1.5rem;
    color: #004357;
    padding: 0 10px;
    font-weight: 500;
}
</style>
