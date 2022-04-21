<template>
    <!--=====================================
            MODAL MOSTRAR INFORMACIÓN
        ======================================-->
    <div>
        <div class="modal fade text-left modal-primary" id="modal-show-project" data-backdrop="static" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Aspirante: {{ project.aspirant[0].user.name }}
                            {{ project.aspirant[0].user.last_name }}</h4>
                        <button type="button" class="close" @click="categorySelected = null" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <!--=====================================
                            LINEA DE PARTICIPACIÓN
                        ======================================-->
                        <h4 class="mb-2 text-primary">Línea de Participación:</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex">
                                    <h5 class="mr-1">Línea de Participación: </h5>
                                    <p> {{ project.aspirant[0].aspirant_type.name }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <h5 class="mr-1">Categoría de Trayectorias: </h5>
                                    <p> {{ project.aspirant[0].category_aspirant.name }}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!--=====================================
                            INFORMACIÓN PERSONAL
                        ======================================-->
                        <h4 class="mb-2 text-primary">Información Personal:</h4>
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Nombres:</h6>
                                <p>{{ project.aspirant[0].user.name }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Apellidos:</h6>
                                <p>{{ project.aspirant[0].user.last_name }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Correo electrónico:</h6>
                                <p>{{ project.aspirant[0].user.email }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Correo electrónico:</h6>
                                <p>{{ project.aspirant[0].user.phone }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Fecha de nacimiento:</h6>
                                <p>{{
                                        moment(project.aspirant[0].user.birthday).locale('es').format("MMMM Do YYYY")
                                    }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Edad:</h6>
                                <p>{{ formatEdad(project.aspirant[0].user.birthday) }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Género:</h6>
                                <p>{{ project.aspirant[0].user.gender.name }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Departamento de resindencia:</h6>
                                <p>{{ project.aspirant[0].user.city.departament.descripcion }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Ciudad de resindencia:</h6>
                                <p>{{ project.aspirant[0].user.city.descripcion }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Dirección:</h6>
                                <p>{{ project.aspirant[0].user.address }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Perspectiva étnica:</h6>
                                <p>{{ project.aspirant[0].ethnic.name }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>¿Es padre o madre cabeza de hogar?</h6>
                                <p>{{ project.aspirant[0].head_house_hold }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>¿Reporta ser víctima del conflicto?</h6>
                                <p>{{ project.aspirant[0].victim_conflict }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>¿Posee alguna discapacidad?</h6>
                                <p>{{ project.aspirant[0].disability }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Documento de identificación</h6>
                                <!--                            <span data-toggle="modal" data-target="#modal-show-document" class="pr-2"-->
                                <!--                                  style="color: #114455; cursor: pointer">Ver documento</span>-->
                                <span @click="showDocumentAspirant = true" class="pr-2"
                                      style="color: #114455; cursor: pointer">Ver documento</span>
                            </div>
                        </div>
                        <!--=====================================
                            INFORMACIÓN DEL MENOR DE EDAD
                        ======================================-->
                        <div v-if="project.aspirant[0].parent != null">
                            <hr>
                            <h4 class="mb-2 text-primary">Información del menor de edad:</h4>
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <h6>Nombres:</h6>
                                    <p>{{ project.aspirant[0].parent.minor.name }}</p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <h6>Apellidos:</h6>
                                    <p>{{ project.aspirant[0].parent.minor.last_name }}</p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <h6>Apellidos:</h6>
                                    <p>{{
                                            moment(project.aspirant[0].parent.minor.birthday).locale('es').format("MMMM Do YYYY")
                                        }}</p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <h6>Edad:</h6>
                                    <p>{{ formatEdad(project.aspirant[0].parent.minor.birthday) }}</p>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <h6>Documento de identificación</h6>
                                    <span data-toggle="modal" data-target="#modal-show-document-minor" class="pr-2"
                                          style="color: #114455; cursor: pointer">Ver documento</span>
                                </div>
                            </div>
                        </div>
                        <!--=====================================
                            INFORMACIÓN DE LA PROPUESTA MUSICAL
                        ======================================-->
                        <hr>
                        <h4 class="mb-2 text-primary">Información de la propuesta musical:</h4>
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Título de la canción:</h6>
                                <p>{{ project.title }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Nombre del intérprete o agrupación:</h6>
                                <p>{{ project.name_author }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Género musical de la canción:</h6>
                                <p>{{ project.category_by_aspirant }}</p>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3">
                                <h6>Estado:</h6>
                                <div class="badge badge-glow badge-secondary">
                                    {{ project.state === '2' ? 'Revisión' : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <h6>Reseña o descripción:</h6>
                                <p>{{ project.description }}</p>
                            </div>
                        </div>
                        <!--=====================================
                            INFORMACIÓN DE ECOPETROL
                        ======================================-->
                        <hr>
                        <h4 class="mb-2 text-primary">Respuestas Ecopetrol</h4>
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <h6>¿Tiene vinculo con Ecopetrol?</h6>
                                <p>{{ project.aspirant[0].vinculado_ecopetrol }}</p>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4" v-if="project.aspirant[0].vinculado_ecopetrol === 'Si'">
                                <h6>¿Su primer empleo ha sido con Ecopetrol?</h6>
                                <p>{{ project.aspirant[0].primer_empleo_ecopetrol }}</p>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4" v-if="project.aspirant[0].vinculado_ecopetrol === 'Si'">
                                <h6>¿Ha sido beneficiario del programa bachilleres por Colombia de Ecopetrol?</h6>
                                <p>{{ project.aspirant[0].bachilleres_colombia_ecopetrol }}</p>
                            </div>
                        </div>
                        <!--=====================================
                            ASIGNAR MODALIDAD
                        ======================================-->
                        <hr>
                        <h4 class="mb-2 text-primary">Asignar Modalidad</h4>
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="d-flex" v-for="category in categoriesProject" :key="category.id">
                                    <vs-radio class="mb-1" color="#11435b" v-model="categorySelected"
                                              :vs-value="category.id">{{
                                            category.category
                                        }}
                                    </vs-radio>
                                    <!--                                <vs-tooltip :text="category.description">-->
                                    <!--                                    <vs-icon size="small" class="pl-1 mb-1" icon="help_outline" style="cursor: pointer"></vs-icon>-->
                                    <!--                                </vs-tooltip>-->
                                </div>
                                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                                   id="text-verify-line-participation" class="text-danger">Debes seleccionar la linea de
                                    participación</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="categorySelected = null" type="button" class="btn btn-secondary"
                                data-dismiss="modal">Cerrar
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Asignar Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================
          MODAL MOSTRAR CEDULA EN ASPIRANTE
         ======================================-->
        <div class="modal fade text-left" id="modal-show-document" tabindex="-1" role="dialog"
             aria-labelledby="modal-example-pdf" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel173">Documento de identificiación de
                            {{ project.aspirant[0].user.name }} {{ project.aspirant[0].user.last_name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="project.aspirant[0].cc_document_pdf">
                            <iframe :src="project.aspirant[0].cc_document_pdf" style="width:100%; height:700px;"
                                    frameborder="0">

                            </iframe>
                        </div>
                        <div v-else>
                            <div class="p-2">
                                <h4 class="text-center">Lado frontal del documento</h4>
                                <img style="width: 50%" :src="project.aspirant[0].cc_document_frontal" alt="">
                            </div>
                            <div class="p-2">
                                <h4 class="text-center">Lado posterior del documento</h4>
                                <img style="width: 50%" :src="project.aspirant[0].cc_document_back" alt="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <vs-popup fullscreen title="fullscreen" :active.sync="showDocumentAspirant">
            <div class="row">
                <div class="col-12 text-center">
                    <div v-if="project.aspirant[0].cc_document_pdf">
                        <iframe :src="project.aspirant[0].cc_document_pdf" style="width:100%; height:700px;"
                                frameborder="0">

                        </iframe>
                    </div>
                    <div v-else>
                        <div class="p-2">
                            <h4 class="text-center">Lado frontal del documento</h4>
                            <img style="width: 50%" :src="project.aspirant[0].cc_document_frontal" alt="">
                        </div>
                        <div class="p-2">
                            <h4 class="text-center">Lado posterior del documento</h4>
                            <img style="width: 50%" :src="project.aspirant[0].cc_document_back" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </vs-popup>
        <!--=====================================
          MODAL MOSTRAR CEDULA DEL MENOR DE EDAD
         ======================================-->
        <div class="modal fade text-left" id="modal-show-document-minor" tabindex="-1" role="dialog"
             aria-labelledby="modal-example-pdf" aria-hidden="true" v-if="project.aspirant[0].parent != null">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel1733">Documento de identificiación de
                            {{ project.aspirant[0].parent.minor.name }} {{
                                project.aspirant[0].parent.minor.last_name
                            }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="project.aspirant[0].parent.minor.document_pdf">
                            <iframe :src="project.aspirant[0].parent.minor.document_pdf"
                                    style="width:100%; height:700px;"
                                    frameborder="0">

                            </iframe>
                        </div>
                        <div v-else>
                            <div class="p-2">
                                <h4 class="text-center">Lado frontal del documento</h4>
                                <img style="width: 50%" :src="project.aspirant[0].parent.minor.document_photo_frontal"
                                     alt="">
                            </div>
                            <div class="p-2">
                                <h4 class="text-center">Lado posterior del documento</h4>
                                <img style="width: 50%" :src="project.aspirant[0].parent.minor.document_photo_back"
                                     alt="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
require("moment/min/locales.min");
import moment from 'moment';

export default {
    name: "ShowProject",
    data() {
        return {
            moment: moment,
            aspirant: null,
            edadMinor: null,
            categoriesProject: [],
            categorySelected: null,
            showDocumentAspirant: false
        }
    },
    methods: {
        formatEdad(birthday) {
            let date = birthday;
            let diferencia = moment();
            return diferencia.diff(date, 'years');
        },
        async getCategoriesProject() {
            await axios.get('/api/get-project-categories').then(resp => {
                this.categoriesProject = resp.data.data
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Hubo un error, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 8000,
                })
            })
        }
    },
    props: ['project'],
    mounted() {
        this.getCategoriesProject()
    }

}
</script>

<style scoped>

</style>
