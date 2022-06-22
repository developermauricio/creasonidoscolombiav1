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
                    >
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
                            <div class="col-md-6 pt-3">
                                <div
                                    v-for="(qualifit, index) in qualifications"
                                    :key="qualifit.id"
                                >
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

                                    <vs-slider
                                        :min="0"
                                        :max="qualifit.value"
                                        color="#11435b"
                                        v-model="qualifit.model"
                                        :disabled="project.state == 4"
                                    />
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
                            v-on:click="saveQualification(project.id)"
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
        };
    },
    components: {
        pagination,
        MediaAudio,
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
                    console.log(this.projects, "los project");
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        saveQualification(id) {
            const data = new FormData();
            data.append("interpretive_quality", this.qualifications[0].model);
            data.append("quality_proposal", this.qualifications[1].model);
            data.append("composition_quality", this.qualifications[2].model);
            data.append("song_potential", this.qualifications[3].model);
            data.append("territorial_value", this.qualifications[4].model);
            data.append("comment", this.description);
            data.append("proyect_id", id);
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
                axios
                    .post("/api/curador/save-qualifications/", data)
                    .then((data) => {
                        window.location.reload();
                    })
                    .catch(({ response }) => {
                        console.error(response);
                    });
            });
        },
        reset() {
            this.qualifications[0].model = 0;
            this.qualifications[1].model = 0;
            this.qualifications[2].model = 0;
            this.qualifications[3].model = 0;
            this.qualifications[4].model = 0;
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

    mounted() {
        this.getProjects();
        this.getProjectAsign();
        this.getProjectQualified();
        this.getQualifications();
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
</style>
