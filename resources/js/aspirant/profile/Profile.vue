<template>
    <div>


        <!--=====================================
              ALERTA QUE CONFIRMA LA CREACIÓN EXITOSA DE UN PROYECTO
        ======================================-->
        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-success">
            <div class="alert-body text-justify" id="text-alert-confirmed_project" v-if="message_confirmed_project">
                {{ message_confirmed_project }}
            </div>
        </div>
        <!--=====================================
              ALERTA QUE CONFIRMA QUE TIENE 24 HORAS PARA EDITAR LA INFORMACIÓN
        ======================================-->
        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-danger" v-if="!end_time">
            <div class="alert-body text-justify text-center" id="text-alert-info-profile">
                Tenga en cuenta que tiene 24 horas para editar su información si es que ha ingresado
                algún dato incorrecto. Pasado las 24 horas su inscripción será enviada a revisión.
                <div class="text-center">
                    <!--=====================================
                         CONTADOR
                    ======================================-->
                    <Countdown
                        :end="this.aspirant.projects[0].end_time"></Countdown>
                    <p>Disponible para edición</p>
                </div>
            </div>
        </div>
        <!--=====================================
            PERFIL DEL USUARIO
       ======================================-->
        <div v-if="!edit_profile">
            <div class="card">
                <div class="card-body">
                    <!--=====================================
                      LINEA DE LA CONVOCATORIA
                    ======================================-->
                    <div class="row p-2">
                        <div class="col-12 d-flex">
                            <h4 class="pr-1">Participa como: </h4>
                            <h5 style="margin-top: 0.2rem" v-if="aspirant.aspirant_type.id === 1">Persona
                                natural en representación propia</h5>
                            <h5 style="margin-top: 0.2rem" v-if="aspirant.aspirant_type.id === 2">Persona
                                natural en representación de una agrupación</h5>
                            <h5 style="margin-top: 0.2rem" v-if="aspirant.aspirant_type.id === 3">Persona
                                natural en representación de un menor de edad</h5>
                        </div>
                        <div class="col-12 d-flex mt-1">
                            <h4 class="pr-1">Categoría de trayectoria: </h4>
                            <h5 style="margin-top: 0.2rem" >{{ aspirant.category_aspirant.name }}</h5>
                        </div>
                    </div>
                    <!--=====================================
                        ESTADO DEL PROYECTO
                    ======================================-->
                    <div class="row pr-2 pl-2 pb-1">
                        <div class="col-12 d-flex">
                            <h4 class="pr-1">Estado: </h4>
                            <div style="margin-top:-0.5rem">
                                <div class="badge badge-glow badge-danger" v-if="aspirant.projects[0].state === '1'">
                                    Borrador
                                </div>
                                <div class="badge badge-glow badge-warning" v-if="aspirant.projects[0].state === '2'">En
                                    Revisión
                                </div>
                                <div class="badge badge-glow badge-success" v-if="aspirant.projects[0].state === '3'">
                                    Acepatdo
                                </div>
                                <div class="badge badge-glow badge-success" v-if="aspirant.projects[0].state === '4'">
                                    Calificado
                                </div>
                                <div class="badge badge-glow badge-danger" v-if="aspirant.projects[0].state === '5'">
                                    Rechazado
                                </div>
                                <div class="badge badge-glow badge-success" v-if="aspirant.projects[0].state === '6'">
                                    Aprobado
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--=====================================
                         BOTON PARA EDITAR LA INFORMACIÓON
                     ======================================-->
                    <!--                    <div class="row pr-2 pl-2 pb-2" v-if="!end_time">-->
                    <!--                        <div class="col-12">-->
                    <!--                            <button @click="(() => edit_profile = true)" type="button"-->
                    <!--                                    class="btn float-right btn-primary waves-effect waves-light">Editar <i-->
                    <!--                                data-feather='edit-2'></i></button>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <vs-tabs color="#114455" class="pt-1">
                        <!--=====================================
                            INFORMACIÓN PERSONAL
                        ======================================-->
                        <vs-tab label="Datos de inscripción">
                            <div class="con-tab-ejemplo">

                                <div class="row p-2">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Nombre:</h5>
                                            <p>{{ aspirant.user.name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Apellidos:</h5>
                                            <p>{{ aspirant.user.last_name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Correo electrónico:</h5>
                                            <p>{{ aspirant.user.email }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Celular:</h5>
                                            <p>{{ aspirant.user.phone }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Fecha de nacimiento:</h5>
                                            <p>{{
                                                    moment(aspirant.user.birthday).locale('es').format("MMMM Do YYYY")
                                                }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Edad:</h5>
                                            <p>{{ edad }} años</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Género:</h5>
                                            <p>{{ aspirant.user.gender.name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Departamento de residencia:</h5>
                                            <p>{{ aspirant.user.city.departament.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Ciudad o municipio de residencia:</h5>
                                            <p>{{ aspirant.user.city.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Dirección:</h5>
                                            <p>{{ aspirant.user.address }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Perspectiva étnica:</h5>
                                            <p>{{ aspirant.ethnic.name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>¿Es padre o madre cabeza de hogar?</h5>
                                            <p>{{ aspirant.head_house_hold }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>¿Reporta ser víctima del conflicto? </h5>
                                            <p>{{ aspirant.victim_conflict }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>¿Posee alguna discapacidad? </h5>
                                            <p>{{ aspirant.disability }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>¿Usted tiene vínculo con Ecopetrol? </h5>
                                            <p>{{ aspirant.vinculado_ecopetrol }}</p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-3 col-md-3" v-if="aspirant.vinculado_ecopetrol === 'Si'">
                                        <div class="form-group">
                                            <h5>¿Su primer empleo ha sido con Ecopetrol? </h5>
                                            <p>{{ aspirant.primer_empleo_ecopetrol }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3" v-if="aspirant.vinculado_ecopetrol === 'Si'">
                                        <div class="form-group">
                                            <h5>¿Usted ha sido beneficiario del programa bachilleres por Colombia de Ecopetrol? </h5>
                                            <p>{{ aspirant.bachilleres_colombia_ecopetrol }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Documento de identificación:</h5>
                                            <span data-toggle="modal" data-target="#modal-show-pdf" class="pr-2"
                                                  style="color: #114455; cursor: pointer">Ver documento</span>
                                        </div>
                                    </div>
                                </div>

                                <!--=====================================
                                     INFORMACIÓN DEL MENOR DE EDAD
                                 ======================================-->

                                <div v-if="aspirant.aspirant_type_id === 3">
                                    <hr>
                                    <h5 class="pb-1 pt-2">2. Información del Menor de Edad</h5>
                                    <div class="row p-2">
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <h5>Nombre del menor edad:</h5>
                                                <p>{{ aspirant.parent.minor.name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <h5>Apellidos del menor de edad:</h5>
                                                <p>{{ aspirant.parent.minor.last_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <h5>Edad:</h5>
                                                <p>{{ edad_minor }} años</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <h5>Fecha de nacimiento del menor de edad:</h5>
                                                <p>{{
                                                        moment(aspirant.parent.minor.birthday).locale('es').format("MMMM Do YYYY")
                                                    }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <h5>Documento de identificación del menor edad:</h5>
                                                <span data-toggle="modal" data-target="#modal-show-minor-pdf"
                                                      class="pr-2"
                                                      style="color: #114455; cursor: pointer">Ver documento</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <!--=====================================
                                    INFORMACIÓN DEL PROYECTO
                                ======================================-->
                                <h5 class="pb-1 pt-2">{{ aspirant.aspirant_type_id === 3 ? '3.' : '2.' }} Información
                                    Propuesta Musical </h5>
                                <div class="row p-2">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Titulo de la canción:</h5>
                                            <p>{{ aspirant.projects[0].title }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Nombre del interprete o agrupación:</h5>
                                            <p>{{ aspirant.projects[0].name_author }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <h5>Género musical de la canción</h5>
                                            <p>{{ aspirant.projects[0].category_by_aspirant }}</p>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-12 col-lg-3 col-md-3">-->
                                    <!--                                        <div class="form-group">-->
                                    <!--                                            <h5>Modalidad o categoría de la canción:</h5>-->
                                    <!--                                            <p>{{ aspirant.projects[0].category.category }}</p>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                </div>
                                <div class="row pr-2 pl-2">
                                    <div class="col-12">
                                        <h5>Reseña:</h5>
                                        <p class="text-justify">{{ aspirant.projects[0].description }}</p>
                                    </div>
                                </div>
                            </div>
                        </vs-tab>
                        <!--=====================================
                              EDITAR EL PERFIL DEl ASPIRANTE
                            ======================================-->
                        <vs-tab label="Editar Información" v-if="!end_time">

                            <aspirant-profile-edit-component :aspirant="aspirant"></aspirant-profile-edit-component>

                        </vs-tab>

                    </vs-tabs>
                </div>
            </div>
            <!--=====================================
                    MODAL MOSTRAR CEDULA EN PDF
                ======================================-->
            <div class="modal fade text-left" id="modal-show-pdf" tabindex="-1" role="dialog"
                 aria-labelledby="modal-example-pdf" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">Documento de identificiación de
                                {{ aspirant.user.name }} {{ aspirant.user.last_name }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="aspirant.cc_document_pdf">
                                <iframe :src="aspirant.cc_document_pdf" style="width:100%; height:700px;"
                                        frameborder="0">

                                </iframe>
                            </div>
                            <div v-else>
                                <div class="p-2">
                                    <h4 class="text-center">Lado frontal del documento</h4>
                                    <img style="width: 100%" :src="aspirant.cc_document_frontal" alt="">
                                </div>
                                <div class="p-2">
                                    <h4 class="text-center">Lado posterior del documento</h4>
                                    <img style="width: 100%" :src="aspirant.cc_document_back" alt="">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--=====================================
                    MODAL MOSTRAR CEDULA EN PDF MENOR DE EDAD
                ======================================-->
            <div v-if="aspirant.aspirant_type_id === 3" class="modal fade text-left" id="modal-show-minor-pdf"
                 tabindex="-1" role="dialog"
                 aria-labelledby="modal-example-pdf" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1w7">Documento de identificiación del menor de edad
                                {{ aspirant.parent.minor.name }} {{ aspirant.parent.minor.last_name }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="aspirant.parent.minor.document_pdf">
                                <iframe :src="aspirant.parent.minor.document_pdf" style="width:100%; height:700px;"
                                        frameborder="0">

                                </iframe>
                            </div>
                            <div v-else>
                                <div class="p-2">
                                    <h4 class="text-center">Lado frontal del documento</h4>
                                    <img style="width: 100%" :src="aspirant.parent.minor.document_photo_frontal" alt="">
                                </div>
                                <div class="p-2">
                                    <h4 class="text-center">Lado posterior del documento</h4>
                                    <img style="width: 100%" :src="aspirant.parent.minor.document_photo_back" alt="">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
                    REPRODUCTOR DE AUDIO
                ======================================-->
            <div class="card fixed-player">
                <div class="card-body">
                    <vue-plyr ref="plyr">
                        <audio controls crossorigin playsinline>
                            <source
                                :src="aspirant.projects[0].audio"
                                type="audio/mp3"
                            />
                        </audio>
                    </vue-plyr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Countdown from '../../vuejs-countdown'
import {publishMQTT} from '../../plugins/mqtt.js'

require("moment/min/locales.min");
import moment from 'moment';

export default {
    name: "Profile",
    components: {Countdown},
    data() {
        return {
            edit_profile: false,
            moment: moment,
            edad: null,
            end_time: false,
            message_confirmed_project: '',

            edad_minor: null,
        }
    },
    props: ['aspirant'],

    methods: {

        /*=============================================
            FUNCION PARA ACTUALIZAR EL ESTADO DEL PROYECTO LUEGO DE VENCER EL TIEMPO
        =============================================*/
        updateProject() {
            let id_project = this.aspirant.projects[0].id
            setTimeout(() => {
                this.$vs.loading({
                    color: '#11435b',
                    text: 'El tiempo de edición termino. Actualizando información...'
                })
                axios.post(`/api/update-project-endtime/${id_project}`).then(resp => {
                    this.notificationEndTime()
                    window.location = '/perfil'
                    localStorage.setItem('message_project_confirmed', 'El tiempo para editar termino. En este momento su propuesta musical esta en estado REVISIÓN')
                }).catch(err => {
                    console.log('mostrando el error: ', err)
                    this.$toast.error({
                        title: 'Error',
                        message: 'Hubo un error consulte con el administrador',
                        showDuration: 1000,
                        hideDuration: 8000,
                    })
                    this.$vs.loading.close()
                })
            }, 200)
        },
        /*=============================================
            FUNCION QUE EVALUA SI ESTA DISPONIBLE PARA EDITAR
        =============================================*/
        endTimeProject() {
            let miliseconds = moment().diff(this.aspirant.projects[0].end_time) * -1
            if (miliseconds >= 0) {
                console.log(miliseconds)
                setTimeout(() => {
                    this.end_time = true
                    /* Actualizamos el estado del proyecto*/
                    this.updateProject()
                }, miliseconds)
            } else {
                this.end_time = true
            }
        },

        notificationEndTime() {
            let topic = 'subsanador_project'
            let message = 'Nuevo proyecto en la bandeja'
            publishMQTT(topic, message)
        }
    },

    mounted() {
        let nacimiento = this.aspirant.user.birthday;
        let hoy = moment();
        let anios = hoy.diff(nacimiento, "years");
        this.edad = anios
        if (this.aspirant.aspirant_type_id === 3) {
            let nacimiento_minor = this.aspirant.parent.minor.birthday;
            let hoy_minor = moment();
            let anios_minor = hoy_minor.diff(nacimiento_minor, "years");
            this.edad_minor = anios_minor
        }

        this.message_confirmed_project = localStorage.getItem('message_project_confirmed')
        localStorage.clear()
        this.endTimeProject()

    }
}
</script>

<style scoped>
.badge {
    line-height: 2 !important;
}

.fixed-player {
    position: fixed;
    bottom: 8.5rem;
    width: 100%;
    left: 0;
    z-index: 200 !important;
}
</style>
