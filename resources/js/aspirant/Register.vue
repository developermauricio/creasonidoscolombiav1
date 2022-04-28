<template>
    <div class="card">
        <div class="card-body">
            <!--=====================================
             COMPONENTE DATOS PERSONALES
            ======================================-->
            <aspirant-data-personal-register-component
                v-on:dataRegisterPersonal="dataRegisterPersonal"></aspirant-data-personal-register-component>

            <!--=====================================
             COMPONENTE DATOS MENOR DE EDAD
            ======================================-->

            <div class="pt-2 pb-1" v-if="select_type_artist">
                <hr>
                <aspirant-data-minor-register-component
                    v-on:dataRegisterMinor="dataRegisterMinor"></aspirant-data-minor-register-component>
            </div>

            <hr>
            <!--=====================================
             COMPONENTE DATOS DEL PROYECTO
            ======================================-->
            <h5 class="pb-1 pt-2">{{ select_type_artist ? '4.' : '3.' }} Datos de la propuesta musical</h5>
            <aspirant-project-register-component v-on:dataRegisterProject="dataRegisterProject" :name="user_auth_name"
                                                 :last_name="user_auth_last_name"></aspirant-project-register-component>

            <!--=====================================
             CAMBIAR LA CONTRASEÑA
            ======================================-->
            <hr>
            <h5 class="pb-1 pt-2">{{ select_type_artist ? '5.' : '4.' }} Cambiar contraseña</h5>
            <div class="row">
                <div class="col-12 col-lg-4 col-md-4">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="reset-password-new">Nueva contraseña</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" v-model="password" class="form-control form-control-merge"
                                   id="reset-password-new" name="reset-password-new" placeholder="nueva contraseña"
                                   aria-describedby="reset-password-new" tabindex="1"/>
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-4">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="reset-password-confirm">Confirmar contraseña</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" v-model="confirmed_password" class="form-control form-control-merge"
                                   id="reset-password-confirm" name="reset-password-confirm"
                                   placeholder="confirmar contraseña" aria-describedby="reset-password-confirm"
                                   tabindex="2"/>
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                    <p style="margin-top: -0.8rem;font-size: 0.9rem; display: none;"
                       id="text-verify-confirmed-password-aspirant" class="text-danger">
                        La contraseña no coincide
                    </p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <h5 class="pb-1 pt-2">Por favor responda:</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-1">
                        <label  id="title-vinculad-ecopetrol">¿Usted tiene vínculo con Ecopetrol? <span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="vinculado_ecopetrol" vs-name="headHousehold1" vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="vinculado_ecopetrol" vs-name="headHousehold2" vs-value="No">No</vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-1" v-if="vinculado_ecopetrol ==='Si'">
                        <label id="title-primero-empleo_ecopetrol">¿Su primer empleo ha sido con Ecopetrol?<span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="primer_empleo_ecopetrol" vs-name="victimConflict1" vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="primer_empleo_ecopetrol" vs-name="victimConflict2" vs-value="No">No</vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3" v-if="vinculado_ecopetrol ==='Si'">
                        <label id="title-bachiller-colombia-ecopetrol">¿Usted ha sido beneficiario del programa bachilleres por Colombia de Ecopetrol?<span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="bachilleres_colombia_ecopetrol" vs-name="disability1" vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="bachilleres_colombia_ecopetrol" vs-name="disability2" vs-value="No">No</vs-radio>
                    </div>
                </div>
            </div>
            <!--=====================================
             ACEPTA LOS TERMINOS Y CONDICIONES
            ======================================-->
            <div class="pt-2">
                <p>Por favor, antes de registrar su información, responda. Usted cuentan con mínimo seis (6) canciones
                    inéditas (obras musicales sin publicar); o de lo contrario “aceptar” en la casilla que están
                    dispuestos a colaborar con autores - compositores vinculados a CREASONIDOS.</p>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <vs-radio color="#11435b" v-model="acceptTerm" vs-name="radios1" vs-value="1">Si cuento con
                                mínimo seis (6) canciones ineditas
                            </vs-radio>
                            <vs-radio color="#11435b" v-model="acceptTerm" vs-name="radios1" vs-value="2">Acepto
                                compositores emanados del proceso CREASONIDOS
                            </vs-radio>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
             GUARDAR INFORMACIÓN
            ======================================-->
            <div class="row pt-1">
                <div class="col-12">
                    <button :disabled="!acceptTerm" @click.prevent="registerInformation()"
                            class="btn btn-primary btn-block">Registrar Información
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueSweetalert2 from 'vue-sweetalert2';

require("moment/min/locales.min");
import Swal from "sweetalert2";
import moment from 'moment';

export default {
    name: "Register",
    components: {
        VueSweetalert2
    },
    data() {
        return {
            password: '',
            confirmed_password: '',
            select_type_artist: false,
            vinculado_ecopetrol: null,
            primer_empleo_ecopetrol: null,
            bachilleres_colombia_ecopetrol: null,
            acceptTerm: null,
            validate: false,
            user_auth_id: window.user_ìd,
            user_auth_aspirant_id: window.aspirant_id,
            user_auth_name: window.user_name,
            user_auth_last_name: window.user_last_name,
            project: null,
            aspirant: null,
            minor: null,
            errors: {}
        }
    },

    methods: {

        dataRegisterPersonal(data) {
            this.aspirant = data
        },

        dataRegisterProject(data) {
            this.project = data
        },

        dataRegisterMinor(data) {
            setTimeout(() => {
                this.minor = data
            }, 200)

        },
        registerInformation() {
            eventBus.$emit("validarFormulario");
            setTimeout(() => {
                let resp = this;
                /***  VALIDANDO LOS ERRORES Y MOSTRANDO UNA ALERTA  ***/

                if (document.querySelectorAll(".is-invalid").length > 0) {

                    if (this.vinculado_ecopetrol === null || this.vinculado_ecopetrol === ''){
                        $('#title-vinculad-ecopetrol').addClass('is-invalid')
                    }
                    if(this.vinculado_ecopetrol === 'Si'){
                        if (this.primer_empleo_ecopetrol === null || this.primer_empleo_ecopetrol === ''){
                            $('#title-primero-empleo_ecopetrol').addClass('is-invalid')
                        }
                        if (this.bachilleres_colombia_ecopetrol === null || this.bachilleres_colombia_ecopetrol === ''){
                            $('#title-bachiller-colombia-ecopetrol').addClass('is-invalid')
                        }
                    }


                    if (this.aspirant.phone === '' || this.aspirant.phone === null) {
                        $("#text-verify-phone-principal").css("display", "block");
                        $('.input-tel__input').addClass('is-invalid')
                    }
                    setTimeout(() => {
                        if (this.aspirant.phone_confirmed === "" || this.aspirant.phone_confirmed === null) {
                            $("#text-verify-phone-confir-valide").css("display", "block");
                            $('.input-tel__input').addClass('is-invalid')
                        }
                    }, 200)

                    if (this.aspirant.typeDocument === '1') {
                        if (this.aspirant.urlDataArchive.length === 0) {
                            $("#text-verify-archive-document-aspirant").css("display", "block");
                            $('#dpz-archives-register-aspirant').addClass('is-invalid')
                        }
                    }

                    if (this.aspirant.typeDocument === '2') {
                        if (this.aspirant.urlDataDocumentPhotoFrontal.length === 0) {
                            $("#text-verify-archive-document-aspirant-photo-frontal").css("display", "block");
                            $('#dpz-archives-register-aspirant-photo-frontal').addClass('is-invalid')
                        }
                        if (this.aspirant.urlDataDocumentPhotoBack.length === 0) {
                            $("#text-verify-archive-document-aspirant-photo-back").css("display", "block");
                            $('#dpz-archives-register-aspirant-photo-back').addClass('is-invalid')
                        }
                    }
                    if (this.aspirant.typeDocument === null || this.aspirant.typeDocument === '') {
                        $("#text-verify-type-document").css("display", "block");
                        $('#text-line-type-document').addClass('is-invalid')
                    }


                    if (this.aspirant.selectAspirantType === 3) {
                        if (this.minor.typeDocumentMinor === null || this.aspirant.typeDocumentMinor === '') {
                            $("#text-verify-type-document-minor").css("display", "block");
                            $('#text-line-type-document-minor').addClass('is-invalid')
                        }
                        if (this.minor.typeDocumentMinor === '1') {
                            if (this.minor.urlDataArchive.length === 0) {
                                $("#text-verify-archive-document-minor").css("display", "block");
                                $('#dpz-archives-register-minor').addClass('is-invalid')
                            }
                        }
                        if (this.minor.typeDocumentMinor === '2') {
                            if (this.minor.urlDataDocumentPhotoFrontal.length === 0) {
                                $("#text-verify-archive-document-minor-frontal").css("display", "block");
                                $('#dpz-archives-register-minor-frontal').addClass('is-invalid')
                            }
                            if (this.minor.urlDataDocumentPhotoBack.length === 0) {
                                $("#text-verify-archive-document-minor-back").css("display", "block");
                                $('#dpz-archives-register-minor-back').addClass('is-invalid')
                            }
                        }
                    }

                    if (this.project.dataArchiveMusicPrincipal.length === 0) {
                        $("#text-verify-archive-music-principal").css("display", "block");
                        $('#dpz-archives-music-principal').addClass('is-invalid')
                    }
                    if (this.aspirant.selectAspirantType === null) {
                        $("#text-verify-line-participation").css("display", "block");
                        $('#text-line-participation').addClass('is-invalid')
                    }

                    if (this.aspirant.headHousehold === null) {
                        $('#title-headHousehold').addClass('is-invalid')
                    }
                    if (this.aspirant.victimConflict === null) {
                        $('#title-victimConflict').addClass('is-invalid')
                    }
                    if (this.aspirant.disability === null) {
                        $('#title-disability').addClass('is-invalid')
                    }

                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                }


                if (this.aspirant.phone === '' || this.aspirant.phone === null) {
                    $("#text-verify-phone-principal").css("display", "block");
                    $('.input-tel__input').addClass('is-invalid')
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                } else {
                    $("#text-verify-phone-principal").css("display", "none");
                    $('.input-tel__input').removeClass('is-invalid')

                }
                if (this.aspirant.phone_confirmed === '' || this.aspirant.phone_confirmed === null) {
                    $("#text-verify-phone-confir-valide").css("display", "block");
                    $('.input-tel__input').addClass('is-invalid')
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                } else {
                    $("#text-verify-phone-confir-valide").css("display", "none");
                    $('.input-tel__input').removeClass('is-invalid')

                }
                if (this.aspirant.selectAspirantType === 3) {
                    if (this.minor.typeDocumentMinor === '1') {
                        if (this.minor.urlDataArchive.length === 0) {
                            $("#text-verify-archive-document-minor").css("display", "block");
                            $('#dpz-archives-register-minor').addClass('is-invalid')
                            this.$toast.error({
                                title: 'Error',
                                message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                                showDuration: 1000,
                                hideDuration: 6000,
                                position: 'top right',
                            })
                            return;
                        } else {
                            $("#text-verify-archive-document-minor").css("display", "none");
                            $('#dpz-archives-register-minor').removeClass('is-invalid')

                        }
                    }

                    if (this.minor.typeDocumentMinor === '2') {
                        if (this.minor.urlDataDocumentPhotoFrontal.length === 0) {
                            $("#text-verify-archive-document-minor-frontal").css("display", "block");
                            $('#dpz-archives-register-minor-frontal').addClass('is-invalid')
                        } else {
                            $("#text-verify-archive-document-minor-frontal").css("display", "none");
                            $('#dpz-archives-register-minor-frontal').removeClass('is-invalid')
                        }
                        if (this.minor.urlDataDocumentPhotoBack.length === 0) {
                            $("#text-verify-archive-document-minor-back").css("display", "block");
                            $('#dpz-archives-register-minor-back').addClass('is-invalid')
                        } else {
                            $("#text-verify-archive-document-minor-back").css("display", "none");
                            $('#dpz-archives-register-minor-back').removeClass('is-invalid')
                        }
                    }

                }
                if (this.aspirant.typeDocument === '1') {
                    if (this.aspirant.urlDataArchive.length === 0) {
                        $("#text-verify-archive-document-aspirant").css("display", "block");
                        $('#dpz-archives-register-aspirant').addClass('is-invalid')
                        this.$toast.error({
                            title: 'Error',
                            message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                            showDuration: 1000,
                            hideDuration: 6000,
                            position: 'top right',
                        })
                        return;

                    } else {
                        $("#text-verify-archive-document-aspirant").css("display", "none");
                        $('#dpz-archives-register-aspirant').removeClass('is-invalid')

                    }
                }
                if (this.aspirant.typeDocument === '2') {
                    if (this.aspirant.urlDataDocumentPhotoFrontal.length === 0) {
                        $("#text-verify-archive-document-aspirant-photo-frontal").css("display", "block");
                        $('#dpz-archives-register-aspirant-photo-frontal').addClass('is-invalid')
                        this.$toast.error({
                            title: 'Error',
                            message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                            showDuration: 1000,
                            hideDuration: 6000,
                            position: 'top right',
                        })
                        return;

                    } else {
                        $("#text-verify-archive-document-aspirant-photo-frontal").css("display", "none");
                        $('#dpz-archives-register-aspirant-photo-frontal').removeClass('is-invalid')

                    }
                    if (this.aspirant.urlDataDocumentPhotoBack.length === 0) {

                        $("#text-verify-archive-document-aspirant-photo-back").css("display", "block");
                        $('#dpz-archives-register-aspirant-photo-back').addClass('is-invalid')
                        this.$toast.error({
                            title: 'Error',
                            message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                            showDuration: 1000,
                            hideDuration: 6000,
                            position: 'top right',
                        })
                        return;

                    } else {
                        $("#text-verify-archive-document-aspirant-photo-back").css("display", "none");
                        $('#dpz-archives-register-aspirant-photo-back').removeClass('is-invalid')

                    }
                }

                if (this.project.dataArchiveMusicPrincipal.length === 0) {
                    $("#text-verify-archive-music-principal").css("display", "block");
                    $('#dpz-archives-music-principal').addClass('is-invalid')
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que los campos que son requeridos estén llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;

                } else {
                    $("#text-verify-archive-music-principal").css("display", "none");
                    $('#dpz-archives-music-principal').removeClass('is-invalid')

                }
                if (this.aspirant.selectAspirantType === '' || this.aspirant.selectAspirantType === null) {
                    $("#text-verify-line-participation").css("display", "block");
                    $('#text-line-participation').addClass('is-invalid')
                    return;

                } else {
                    $("#text-verify-line-participation").css("display", "none");
                    $('#text-line-participation').removeClass('is-invalid')

                }

                if (this.aspirant.headHousehold === null) {
                    $('#title-headHousehold').addClass('is-invalid')
                    return
                }
                if (this.aspirant.victimConflict === null) {
                    $('#title-victimConflict').addClass('is-invalid')
                    return
                }
                if (this.aspirant.disability === null) {
                    $('#title-disability').addClass('is-invalid')
                    return
                }

                if (this.vinculado_ecopetrol === null || this.vinculado_ecopetrol === ''){
                    $('#title-vinculad-ecopetrol').addClass('is-invalid')
                    return
                }else{
                    $('#title-vinculad-ecopetrol').removeClass('is-invalid')
                }

                const data = new FormData()

                /*=============================================
                    DATOS PERSONALES
                =============================================*/
                data.append('user_id', this.user_auth_id);
                data.append('aspirant_id', this.user_auth_aspirant_id);
                data.append('aspirant_type', this.aspirant.selectAspirantType);
                data.append('name', this.aspirant.user_auth_name);
                data.append('last_name', this.aspirant.user_auth_last_name);
                data.append('email', this.aspirant.user_auth_email);
                data.append('phone', this.aspirant.phone);
                data.append('birthday', moment(this.aspirant.birthday).format("YYYY-MM-DD HH:mm:ss"))
                data.append('genero', JSON.stringify(this.aspirant.genero));
                data.append('ethnic_id', JSON.stringify(this.aspirant.ethnic));
                data.append('category_aspirant_id', JSON.stringify(this.aspirant.categoryAspirant));
                data.append('city', JSON.stringify(this.aspirant.homeCity));
                data.append('address', this.aspirant.address);
                data.append('archive', JSON.stringify(this.aspirant.urlDataArchive));
                data.append('archiveDocumentPhotoFrontal', JSON.stringify(this.aspirant.urlDataDocumentPhotoFrontal));
                data.append('archiveDocumentPhotoBack', JSON.stringify(this.aspirant.urlDataDocumentPhotoBack));
                data.append('headHousehold', this.aspirant.headHousehold);
                data.append('victimConflict', this.aspirant.victimConflict);
                data.append('disability', this.aspirant.disability);
                data.append('acceptTerm', this.acceptTerm);
                data.append('vinculado_ecopetrol', this.vinculado_ecopetrol);
                data.append('primer_empleo_ecopetrol', this.primer_empleo_ecopetrol);
                data.append('bachilleres_colombia_ecopetrol', this.bachilleres_colombia_ecopetrol);
                /*=============================================
                    DATOS DEL PROYECTO
                =============================================*/
                data.append('project_name', this.project.name);
                data.append('project_name_author', this.project.nameAuthor);
                data.append('project_description', this.project.description);
                data.append('project_category', JSON.stringify(this.project.category));
                data.append('project_category_by_aspirant', this.project.categoryByAspirant);
                data.append('project_audio', JSON.stringify(this.project.dataArchiveMusicPrincipal));


                /*=============================================
                   DATOS DEL MENOR DE EDAD
               =============================================*/
                if (this.aspirant.selectAspirantType === 3) {
                    data.append('name_minor', this.minor.name);
                    data.append('last_name_minor', this.minor.last_name);
                    data.append('archiveDocumentMinorPhotoFrontal', JSON.stringify(this.minor.urlDataDocumentPhotoFrontal));
                    data.append('archiveDocumentMinorPhotoBack', JSON.stringify(this.minor.urlDataDocumentPhotoBack));
                    data.append('birthday_minor', moment(this.minor.birthday).format("YYYY-MM-DD HH:mm:ss"))
                    data.append('archive_minor', JSON.stringify(this.minor.urlDataArchive));
                }

                /*=============================================
                    CONTRASEÑA
                =============================================*/
                data.append('password', this.password);

                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Esta seguro de realizar el registro?',
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
                        resp.$vs.loading({
                            color: '#11435b',
                            text: 'Espere un momento por favor...'
                        })
                        axios.post('/api/create-register', data).then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'Registro creado exitosamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            localStorage.setItem('message_project_confirmed', 'Su propuesta musical ha sido registrada exitosamente!. Hemos enviado un correo electrónico con la confirmación')
                            window.location = '/perfil'
                        }).catch(err => {
                            this.$toast.error({
                                title: 'Error',
                                message: 'Hubo un error al guardar los datos',
                                showDuration: 1000,
                                hideDuration: 8000,
                            })
                            resp.$vs.loading.close()
                        })
                    }
                });
                resp.$vs.loading.close()
            }, 200);
        },
    },

    watch: {
        vinculado_ecopetrol: function (val) {
          if (val){
              $('#title-vinculad-ecopetrol').removeClass('is-invalid')
              if (val === 'No'){
                  this.primer_empleo_ecopetrol = ''
                  this.bachilleres_colombia_ecopetrol = ''
              }
          }
        },
        primer_empleo_ecopetrol: function (val) {
            if (val){
                $('#title-primero-empleo_ecopetrol').removeClass('is-invalid')
            }
        },
        bachilleres_colombia_ecopetrol: function (val) {
            if (val){
                $('#title-bachiller-colombia-ecopetrol').removeClass('is-invalid')
            }
        },
        'confirmed_password': function (val) {
            if (val) {
                if (val !== this.password) {
                    $("#text-verify-confirmed-password-aspirant").css("display", "block");
                    $("#reset-password-confirm").addClass('is-invalid')
                } else {
                    $("#text-verify-confirmed-password-aspirant").css("display", "none");
                    $("#reset-password-confirm").removeClass('is-invalid')
                }
            }
        },
        'aspirant.urlDataArchive': function (val) {
            if (this.aspirant.urlDataArchive.length > 0) {
                $("#text-verify-archive-document-aspirant").css("display", "none");
            }
        },
        'aspirant.phone': function (val) {
            if (this.aspirant.phone !== '' || this.aspirant.phone !== null) {
                $("#text-verify-phone-principal").css("display", "none");
                $("#text-verify-phone-confir-valide").css("display", "none");
            }
        },
        'aspirant.phone_confirmed': function (val) {
            if (this.aspirant.phone_confirmed !== "") {
                $("#text-verify-phone-confir-valide").css("display", "none");
            }
        },
        'project.dataArchiveMusicPrincipal': function (val) {
            if (this.project.dataArchiveMusicPrincipal.length > 0) {
                $("#text-verify-archive-music-principal").css("display", "none");
            }
        },
        'aspirant.selectAspirantType': function (val) {
            setTimeout(() => {
                if (val !== '' || val !== null) {
                    $("#text-verify-line-participation").css("display", "none");
                    $('#text-line-participation').removeClass('is-invalid')
                }
                if (val === 3) {
                    this.select_type_artist = true
                } else {
                    this.select_type_artist = false
                }
            }, 200)
        },
    },

    mounted() {

        $('.form-password-toggle .input-group-text').on('click', function (e) {
            e.preventDefault();
            var $this = $(this),
                inputGroupText = $this.closest('.form-password-toggle'),
                formPasswordToggleIcon = $this,
                formPasswordToggleInput = inputGroupText.find('input');

            if (formPasswordToggleInput.attr('type') === 'text') {
                formPasswordToggleInput.attr('type', 'password');
                if (feather) {
                    formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye'].toSvg({class: 'font-small-4'}));
                }
            } else if (formPasswordToggleInput.attr('type') === 'password') {
                formPasswordToggleInput.attr('type', 'text');
                if (feather) {
                    formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye-off'].toSvg({class: 'font-small-4'}));
                }
            }
        });
    }

}
</script>

<style scoped>
.con-vs-radio {
    justify-content: normal !important;
}
</style>
