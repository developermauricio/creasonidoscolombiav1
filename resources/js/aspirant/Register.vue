<template>
    <div class="card">
        <div class="card-body">
            <!--=====================================
             COMPONENTE DATOS PERSONALES
            ======================================-->
            <aspirant-data-personal-register-component
                v-on:dataRegisterPersonal="dataRegisterPersonal"></aspirant-data-personal-register-component>
            <hr>
            <!--=====================================
             COMPONENTE DATOS DEL PROYECTO
            ======================================-->
            <aspirant-project-register-component v-on:dataRegisterProject="dataRegisterProject" :name="user_auth_name"
                                                 :last_name="user_auth_last_name"></aspirant-project-register-component>

            <!--=====================================
             CAMBIAR LA CONTRASEÑA
            ======================================-->
            <hr>
            <h5 class="pb-1 pt-2">4. Cambiar contraseña</h5>
            <div class="row">
                <div class="col-12 col-lg-4 col-md-4">
                    <!--                    <div class="input-group input-group-merge form-password-toggle">-->
                    <!--                        <input-form-->
                    <!--                            type="password"-->
                    <!--                            id="login-password"-->
                    <!--                            label="Nueva contraseña"-->
                    <!--                            pattern="all"-->
                    <!--                            errorMsg="Ingrese una contraseña válida"-->
                    <!--                            requiredMsg=""-->
                    <!--                            :modelo.sync="password"-->
                    <!--                            :required="false"-->
                    <!--                            :msgServer.sync="errors.password"-->
                    <!--                        ></input-form>-->
                    <!--                        <div class="input-group-append"><span class="input-group-text cursor-pointer"><i-->
                    <!--                            data-feather="eye"></i></span></div>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="reset-password-new">Nueva contraseña</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" v-model="password" class="form-control form-control-merge" id="reset-password-new" name="reset-password-new" placeholder="nueva contraseña" aria-describedby="reset-password-new" tabindex="1" />
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
                            <input type="password" v-model="confirmed_password" class="form-control form-control-merge" id="reset-password-confirm" name="reset-password-confirm" placeholder="confirmar contraseña" aria-describedby="reset-password-confirm" tabindex="2" />
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
            <!--=====================================
             ACEPTA LOS TERMINOS Y CONDICIONES
            ======================================-->
            <div class="pt-2">
                <p>Por favor, antes de registrar su información, responda. Usted cuentan con mínimo seis (6) canciones
                    inéditas (obras musicales sin publicar); o de lo contrario “aceptar” en la casilla que están
                    dispuestos a colaborar con autores - compositores emanados del proceso CREASONIDOS.</p>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <vs-radio color="#11435b" v-model="acceptTerm" vs-name="radios1" vs-value="1">Si cuento con
                                mínimo seis (6) canciones ineditas
                            </vs-radio>
                            <vs-radio color="#11435b" v-model="acceptTerm" vs-name="radios1" vs-value="2">Acepto
                                compositores emanados del proceso CREA SONIDOS
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

            acceptTerm: null,
            validate: false,
            user_auth_id: window.user_ìd,
            user_auth_aspirant_id: window.aspirant_id,
            user_auth_name: window.user_name,
            user_auth_last_name: window.user_last_name,
            project: null,
            aspirant: null,
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
        registerInformation() {
            eventBus.$emit("validarFormulario");
            setTimeout(() => {
                let resp = this;
                /***  VALIDANDO LOS ERRORES Y MOSTRANDO UNA ALERTA  ***/

                if (document.querySelectorAll(".is-invalid").length > 0) {

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


                    if (this.aspirant.urlDataArchive.length === 0) {
                        $("#text-verify-archive-document-aspirant").css("display", "block");
                        $('#dpz-archives-register-aspirant').addClass('is-invalid')
                    }

                    if (this.project.dataArchiveMusicPrincipal.length === 0) {
                        $("#text-verify-archive-music-principal").css("display", "block");
                        $('#dpz-archives-music-principal').addClass('is-invalid')
                    }
                    if (this.aspirant.selectAspirantType === null) {
                        $("#text-verify-line-participation").css("display", "block");
                        $('#text-line-participation').addClass('is-invalid')
                    }

                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
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
                        message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
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
                        message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                } else {
                    $("#text-verify-phone-confir-valide").css("display", "none");
                    $('.input-tel__input').removeClass('is-invalid')

                }

                if (this.aspirant.urlDataArchive.length === 0) {
                    $("#text-verify-archive-document-aspirant").css("display", "block");
                    $('#dpz-archives-register-aspirant').addClass('is-invalid')
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;

                } else {
                    $("#text-verify-archive-document-aspirant").css("display", "none");
                    $('#dpz-archives-register-aspirant').removeClass('is-invalid')

                }

                if (this.project.dataArchiveMusicPrincipal.length === 0) {
                    $("#text-verify-archive-music-principal").css("display", "block");
                    $('#dpz-archives-music-principal').addClass('is-invalid')
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
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
                data.append('city', JSON.stringify(this.aspirant.homeCity));
                data.append('address', this.aspirant.address);
                data.append('archive', JSON.stringify(this.aspirant.urlDataArchive));
                data.append('acceptTerm', this.acceptTerm);
                /*=============================================
                    DATOS DEL PROYECTO
                =============================================*/
                data.append('project_name', this.project.name);
                data.append('project_name_author', this.project.nameAuthor);
                data.append('project_description', this.project.description);
                data.append('project_category', JSON.stringify(this.project.category));
                data.append('project_audio', JSON.stringify(this.project.dataArchiveMusicPrincipal));
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
            if (val) {
                setTimeout(() => {
                    let valid = $(".input-phone-number").hasClass("is-valid")

                    if (valid) {
                        $('#phoneAspirant-7_phone_number').removeClass('is-invalid')
                        $("#text-verify-phone-valid").css("display", "none");

                        $("#text-verify-phone-confir-valide").css("display", "none");
                        $("#text-verify-phone-principal").css("display", "none");
                    } else {
                        $('#phoneAspirant-7_phone_number').addClass('is-invalid')
                        $("#text-verify-phone-valid").css("display", "block");

                    }
                }, 200)

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
                    formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye'].toSvg({ class: 'font-small-4' }));
                }
            } else if (formPasswordToggleInput.attr('type') === 'password') {
                formPasswordToggleInput.attr('type', 'text');
                if (feather) {
                    formPasswordToggleIcon.find('svg').replaceWith(feather.icons['eye-off'].toSvg({ class: 'font-small-4' }));
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
