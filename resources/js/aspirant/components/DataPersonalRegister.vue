<template>
    <div>
        <!--=====================================
            SELECCIONAR LINEA DE LA CONVOCATORIA
        ======================================-->
        <div class="row pb-1">
            <div class="col-12">
                <h5 class="pb-1" id="text-line-participation">1. Selecciona tu linea de participación</h5>
                <div class="d-flex" v-for="types in aspirantType" :key="types.id">
                    <vs-radio color="#11435b" v-model="aspirant.selectAspirantType" :vs-value="types.id">{{
                            types.name
                        }}
                    </vs-radio>
                    <vs-tooltip :text="types.description">
                        <vs-icon size="small" class="pl-1 mb-1" icon="help_outline" style="cursor: pointer"></vs-icon>
                    </vs-tooltip>
                </div>
                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                   id="text-verify-line-participation" class="text-danger">Debes seleccionar la linea de
                    participación</p>
            </div>
            <div class="col-12 col-md-4 col-lg-4 mt-2">
                <input-form
                    label="Categoría de trayectorias"
                    id="textCategoryApirant"
                    errorMsg
                    requiredMsg="La categoría de trayectorias es requerido"
                    :required="true"
                    :modelo.sync="aspirant.categoryAspirant"
                    :msgServer.sync="errors.categoryAspirant"
                    type="multiselect"
                    selectLabel="Seleccione en que categoría se encuentra"
                    :multiselect="{ options: optionsCategoryAspirant,
                                           selectLabel:'Seleccione en que categoría se encuentra',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Género',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': categoryAspirant=>categoryAspirant.name
                                        }"
                ></input-form>
                <span data-toggle="modal" data-target="#modal-show-info-category-aspirant" class="pr-2"
                      style="color: #B53E2A; cursor: pointer">Clíc para más información</span>
            </div>
        </div>
        <hr>
        <!--=====================================
		    DATOS PERSONALES DEL ASPIRANTE
        ======================================-->
        <!--=====================================
               CAMPO NOMBRES
           ======================================-->
        <h5 class="pb-1 pt-1">2. Información Personal</h5>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="txtNameAspirant"
                        label="Nombres"
                        pattern="alf"
                        errorMsg="Ingrese un nombre válido"
                        requiredMsg="Su nombre es requerido"
                        :modelo.sync="aspirant.user_auth_name"
                        :required="true"
                        :msgServer.sync="errors.user_auth_name"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO APELLIDOS
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="txtLastNameAspirant"
                        label="Apellidos"
                        pattern="alf"
                        errorMsg="Ingrese apellidos válidos"
                        requiredMsg="Sus apellidos son requeridos"
                        :modelo.sync="aspirant.user_auth_last_name"
                        :required="true"
                        :msgServer.sync="errors.last_name"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO CORREO ELECTRÓNICO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        :disabled="1"
                        id="txtEmailAspirant"
                        label="Correo electrónico"
                        pattern="email"
                        errorMsg="Ingrese un correo electrónico válido"
                        requiredMsg="Su correo electrónico es requerido"
                        :modelo.sync="aspirant.user_auth_email"
                        :required="true"
                        :msgServer.sync="errors.user_auth_email"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO TELÉFONO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        label="Celular"
                        id="phoneAspirant"
                        pattern="all"
                        errorMsg="Ingrese un celular válido"
                        requiredMsg="El número de celular es requerido"
                        :required="true"
                        :modelo.sync="aspirant.phone"
                        :msgServer.sync="errors.phone"
                        v-mask="'(###) ###-####'"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO CONFIRMAR TELÉFONO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="phoneAspirantConfirmed"
                        label="Confirmar celular"
                        pattern="all"
                        errorMsg="Ingrese un celular valido"
                        requiredMsg="La confirmación del número celular es requerida"
                        :required="true"
                        :modelo.sync="aspirant.phone_confirmed"
                        :msgServer.sync="errors.phone_confirmed"
                        v-mask="'(###) ###-####'"
                    ></input-form>
                    <p style="margin-top: -0.5rem;font-size: 0.9rem; display: none; font-weight: bold"
                       id="text-verify-phone" class="text-danger">
                        El número de celular no coincide
                    </p>
                    <!--                    <p style="margin-top: -0.5rem;font-size: 0.9rem; display: none;"-->
                    <!--                       id="text-verify-phone-confir-valide" class="text-danger">-->
                    <!--                        La confirmación del celular es obligatorio-->
                    <!--                    </p>-->
                </div>
            </div>
            <!--=====================================
               CAMPO SELECCIONAR FECHA DE NACIMIENTO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Fecha de nacimiento"
                    id="txtAspirantFechaNacimiento"
                    pattern="all"
                    errorMsg="Ingrese una fecha de nacimiento válida"
                    requiredMsg="La fecha de nacimiento es requerida"
                    :required="true"
                    :modelo.sync="aspirant.birthday"
                    :msgServer.sync="errors.birthday"
                    type="date"
                    :datepicker="{
                                                   'clear-button': false,
                                                  'bootstrap-styling':true,
                                                   'disabled-dates':state.disabledDates
                                                }"
                ></input-form>
            </div>
            <!--=====================================
               CAMPO SELECCIONAR GENERO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Género"
                    id="textGenderApirant"
                    errorMsg
                    requiredMsg="El genero es requerido"
                    :required="true"
                    :modelo.sync="aspirant.genero"
                    :msgServer.sync="errors.genero"
                    type="multiselect"
                    selectLabel="Tipo de documento"
                    :multiselect="{ options: optionsGender,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Género',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': genders=>genders.name
                                        }"
                ></input-form>
            </div>
            <!--=====================================
               CAMPO SELECCIONAR DEPARTAMENTO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Departamento de residencia"
                    id="textDispatchDepartmentAspirant"
                    errorMsg
                    requiredMsg="El departamento de residencia es requerido"
                    :required="true"
                    :modelo.sync="aspirant.homeDepartment"
                    :msgServer.sync="errors.homeDepartment"
                    type="multiselect"
                    @updatedValue="changeSelectDepartament"
                    selectLabel="Departamento"
                    :multiselect="{ options: optionsDepartaments,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Selecciona el departamento',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': dispatchDepartment=>dispatchDepartment.descripcion
                                        }"
                ></input-form>
            </div>
            <!--=====================================
               CAMPO SELECCIONAR CIUDAD
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6" v-if="aspirant.homeDepartment">
                <input-form
                    label="Ciudad o municipio de residencia"
                    id="textCityAspirant"
                    errorMsg
                    requiredMsg="La ciudad o municipio de residencia es requerido"
                    :required="true"
                    :modelo.sync="aspirant.homeCity"
                    :msgServer.sync="errors.homeCity"
                    type="multiselect"
                    selectLabel="Departamento"
                    :multiselect="{ options: optionsCities,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Selecciona la ciudad o municipio',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': dispatchCity=>dispatchCity.descripcion
                                        }"
                ></input-form>
            </div>
            <!--=====================================
               CAMPO DIRECCIÓN
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="txtAddressAspirant"
                        label="Dirección"
                        pattern="all"
                        errorMsg="Ingrese una dirección de residencia válida"
                        requiredMsg="La dirección de residencia es requerida"
                        :modelo.sync="aspirant.address"
                        :required="true"
                        :msgServer.sync="errors.address"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO PERSPECTIVA ÉTNICA
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Perspectiva étnica"
                    id="textEthnicApirant"
                    errorMsg
                    requiredMsg="La perspectiva étnica es requerida"
                    :required="true"
                    :modelo.sync="aspirant.ethnic"
                    :msgServer.sync="errors.ethnic"
                    type="multiselect"
                    selectLabel="Seleccione"
                    :multiselect="{ options: optionsEthnic,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Perspectiva étnica',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': ethnic=>ethnic.name
                                        }"
                ></input-form>
            </div>
        </div>
        <!--=====================================
               PREGUNTAS PERSONALES
           ======================================-->
        <div class="row mt-1 mb-1">
            <div class="col-12">
                <h5 id="text-line-questions">Responda las siguientes preguntas</h5>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <label for="" id="title-headHousehold">¿Es padre o madre cabeza de hogar? <span
                    class="text-danger"> *</span></label>
                <vs-radio color="#11435b" v-model="aspirant.headHousehold" vs-name="headHousehold1" vs-value="Si">Si
                </vs-radio>
                <vs-radio color="#11435b" v-model="aspirant.headHousehold" vs-name="headHousehold2" vs-value="No">No
                </vs-radio>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <label for="" id="title-victimConflict">¿Reporta ser víctima del conflicto?<span
                    class="text-danger"> *</span></label>
                <vs-radio color="#11435b" v-model="aspirant.victimConflict" vs-name="victimConflict1" vs-value="Si">Si
                </vs-radio>
                <vs-radio color="#11435b" v-model="aspirant.victimConflict" vs-name="victimConflict2" vs-value="No">No
                </vs-radio>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <label for="" id="title-disability">¿Posee alguna discapacidad?<span
                    class="text-danger"> *</span></label>
                <vs-radio color="#11435b" v-model="aspirant.disability" vs-name="disability1" vs-value="Si">Si
                </vs-radio>
                <vs-radio color="#11435b" v-model="aspirant.disability" vs-name="disability2" vs-value="No">No
                </vs-radio>
            </div>
        </div>
        <!--=====================================
             SUBIR DOCUMENTO DE IDENTIFICACIÓN
         ======================================-->
        <div class="row">
            <div class="col-12 mt-1">
                <h5 id="text-line-type-document">Seleccione como va a subir su documento de identificación</h5>
                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                   id="text-verify-type-document" class="text-danger">Debe agergar la foto o documento de
                    identificación</p>
                <vs-radio color="#11435b" v-model="aspirant.typeDocument" vs-name="typeDocument1" vs-value="1">Agregar
                    documento en pdf
                </vs-radio>
                <vs-radio color="#11435b" v-model="aspirant.typeDocument" vs-name="typeDocument2" vs-value="2">Agregar
                    fotografía del documento
                </vs-radio>
            </div>
            <div class="col-12 mt-2" v-if="aspirant.typeDocument === '1'">
                <label class="form-control-label" id="add-archive-dropzone-aspirant">Subir documento de identificación
                    <span style="color: red"> *</span></label>
                <dropzone-upload-document v-on:dataUrl="datUrlDropzone" :name="aspirant.user_auth_name"
                                          :lastName="aspirant.user_auth_last_name"></dropzone-upload-document>
                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                   id="text-verify-archive-document-aspirant" class="text-danger">El archivo del documento es
                    requerido</p>
            </div>
            <div class="col-12 mt-1" v-if="aspirant.typeDocument === '2'">
                <dropzone-personal-document-photo
                    :name="aspirant.user_auth_name"
                    :lastName="aspirant.user_auth_last_name"
                    v-on:documentUrlPhotoFrontal="datUrlDropzonePhotoFrontal"
                    v-on:documentUrlPhotoBack="datUrlDropzonePhotoBack"
                >
                </dropzone-personal-document-photo>
            </div>
            <div class="d-flex pl-1 pt-1">
                <span data-toggle="modal" data-target="#modal-example-pdf" class="pr-2"
                      style="color: #B53E2A; cursor: pointer">Ver ejemplo en pdf</span>
                <span data-toggle="modal" data-target="#modal-example-jpg"
                      style="color: #B53E2A; cursor: pointer">Ver ejemplo en jpg (imagen)</span>
            </div>
            <!--=====================================
		        MODAL EJEMPLO CEDULA PDF
            ======================================-->
            <div class="modal fade text-left" id="modal-example-pdf" tabindex="-1" role="dialog"
                 aria-labelledby="modal-example-pdf" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">Ejemplo de un documento de identificación en
                                pdf</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe src="/img/cedula-ejemplo.pdf" style="width:100%; height:700px;" frameborder="0">

                            </iframe>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
		        MODAL EJEMPLO CEDULA JPG
            ======================================-->
            <div class="modal fade text-left" id="modal-example-jpg" tabindex="-1" role="dialog"
                 aria-labelledby="modal-example-pdf" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="">Ejemplo de un documento de identificación en jpg</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img style="width: 100%" src="/img/cedula-ejemplo-jpg.jpg" alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
		        MODAL INFORMACIÓN DE LAS CATEGORIAS
            ======================================-->
            <div class="modal fade text-left" id="modal-show-info-category-aspirant" tabindex="-1" role="dialog"
                 aria-labelledby="modal-show-info-category-aspirant" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">¿Que es Categoría de Trayectorias?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-for="(category, index) in optionsCategoryAspirant" :key="category.id" class="p-1">
                                <h4>{{ index + 1 }}. {{ category.name }}:</h4>
                                <p>{{ category.description }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import Multiselect from "vue-multiselect";
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Swal from "sweetalert2";

export default {
    name: "DataPersonalRegister",
    components: {
        VuePhoneNumberInput,
        vue2Dropzone,
        Multiselect,
        Datepicker,

    },
    data() {
        return {
            en: en,
            es: es,
            user: {},
            aspirant: {
                user_auth_email: window.user_email,
                user_auth_name: window.user_name,
                user_auth_last_name: window.user_last_name,

                urlDataArchive: [],
                urlDataDocumentPhotoFrontal: [],
                urlDataDocumentPhotoBack: [],
                phone: '',
                phone_confirmed: '',
                address: '',
                birthday: null,
                genero: null,
                ethnic: null,
                categoryAspirant: null,
                homeDepartment: null,
                homeCity: null,
                selectAspirantType: null,
                typeDocument: null,
                headHousehold: null,
                victimConflict: null,
                disability: null,
            },

            aspirantType: [],
            optionsDepartaments: [],
            optionsCities: [],
            optionsGender: [],
            optionsEthnic: [],
            optionsCategoryAspirant: [],

            errors: {},
            currentDate: null,
            state: {
                disabledDates: {
                    from: null, // Disable all dates up to specific date
                    // from: new Date(2016, 0, 26), // Disable all dates after specific date
                },
                date: new Date()
            }
        }
    },

    methods: {

        datUrlDropzone(data) {
            this.aspirant.urlDataArchive = data
        },
        datUrlDropzonePhotoFrontal(data) {
            this.aspirant.urlDataDocumentPhotoFrontal = data;
        },
        datUrlDropzonePhotoBack(data) {
            this.aspirant.urlDataDocumentPhotoBack = data;
        },

        getGenders() {
            axios.get('/api/get-genders').then(resp => {
                this.optionsGender = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },

        getEthnics() {
            axios.get('/api/get-ethnics').then(resp => {
                this.optionsEthnic = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },

        getCategoryAspirant() {
            axios.get('/api/get-category-aspirant').then(resp => {
                this.optionsCategoryAspirant = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },

        getAspirantType() {
            axios.get('/api/get-aspirant-types').then(resp => {
                this.aspirantType = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        changeSelectDepartament(value) {
            this.optionsCities = []
            this.homeCity = null
            this.$vs.loading({
                color: '#11435b',
                text: 'Espere un momento por favor...'
            })

            setTimeout(() => {
                if (value !== null) {
                    axios.get(`/api/get-cities/${value.id}`).then(resp => {
                        this.optionsCities = resp.data.data
                    }).catch(err => {
                        console.log(err)
                        this.$toast.error({
                            title: 'Error',
                            message: 'Algo salió mal, consulte al administrador',
                            showDuration: 1000,
                            hideDuration: 6000,
                            position: 'top right',
                        })

                    })
                    this.$vs.loading.close()
                } else {
                    this.$vs.loading.close()
                }
            }, 200)
        },

        getDeparments() {
            axios.get('/api/get-departaments').then(resp => {
                this.optionsDepartaments = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        }

    },

    watch: {
        'aspirant.phone': function (val) {
            if (val) {
                $('#phoneAspirant').removeClass('is-invalid')
            } else {
                this.aspirant.phone_confirmed = ''
            }
        },
        'aspirant.headHousehold': function (val) {
            if (val) {
                $('#title-headHousehold').removeClass('is-invalid')
            }
        },
        'aspirant.victimConflict': function (val) {
            if (val) {
                $('#title-victimConflict').removeClass('is-invalid')
            }
        },
        'aspirant.disability': function (val) {
            if (val) {
                $('#title-disability').removeClass('is-invalid')
            }
        },
        'aspirant.typeDocument': function (val) {
            if (val) {
                $("#text-verify-type-document").css("display", "none");
                $('#text-line-type-document').removeClass('is-invalid')
            } else {
                $("#text-verify-type-document").css("display", "block");
                $('#text-line-type-document').addClass('is-invalid')
            }
            if (val === '1' && this.aspirant.urlDataArchive.length > 0) {
                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Esta seguro que desea cambiar el documento?',
                    confirmButtonColor: "#11435b",
                    cancelButtonColor: "#B53E2A",
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    customClass: "swal-confirmation",
                    showCancelButton: true,
                    reverseButtons: true,
                    allowOutsideClick: false,
                }).then(result => {
                    if (result.value) {
                        this.aspirant.typeDocument = '2'
                    } else {
                        this.aspirant.typeDocument = '1'
                    }
                });
            }
        },
        'aspirant.phone_confirmed': function (val) {
            if (val !== this.aspirant.phone && this.aspirant.phone_confirmed) {
                $('#phoneAspirantConfirmed').addClass('is-invalid')
                $("#text-verify-phone").css("display", "block");
            } else {
                $("#text-verify-phone").css("display", "none");
                $('#phoneAspirantConfirmed').removeClass('is-invalid')
            }
        },
    },
    mounted() {
        this.$emit('dataRegisterPersonal', this.aspirant);
        this.getAspirantType();
        this.getDeparments();
        this.getGenders();
        this.getEthnics();
        this.getCategoryAspirant();
        this.currentDate = new Date()
        this.currentDate.setFullYear(this.currentDate.getFullYear() - 18)
        this.currentDate = this.currentDate.getFullYear() + 1
        this.state.disabledDates.from = new Date(this.currentDate, 0, 0);
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.con-vs-radio {
    justify-content: normal !important;
}

.vdp-datepicker__calendar {
    z-index: 1419 !important;
}
</style>
