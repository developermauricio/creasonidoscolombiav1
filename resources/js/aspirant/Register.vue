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
             GUARDAR INFORMACIÓN
            ======================================-->
            <div class="row pt-5">
                <div class="col-12">
                    <button @click="registerInformation()" class="btn btn-primary btn-block">Registrar Información
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
            validate: false,
            user_auth_id: window.user_ìd,
            user_auth_aspirant_id: window.aspirant_id,
            user_auth_name: window.user_name,
            user_auth_last_name: window.user_last_name,
            project: null,
            aspirant: null,
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

                    if (this.aspirant.urlDataArchive.length === 0) {
                        $("#text-verify-archive-document-aspirant").css("display", "block");
                        $('#dpz-archives-register-aspirant').addClass('is-invalid')
                    }

                    if (this.project.dataArchiveMusicPrincipal.length === 0) {
                        $("#text-verify-archive-music-principal").css("display", "block");
                        $('#dpz-archives-music-principal').addClass('is-invalid')
                    }
                    if (this.aspirant.selectAspirantType !== '' || this.aspirant.selectAspirantType == null  ) {
                        $("#text-verify-line-participation").css("display", "block");
                        $('#text-line-participation').addClass('is-invalid')
                    }


                    this.alertToastError()
                    return;
                }

                if (this.aspirant.phone === '' || this.aspirant.phone === null) {
                    $("#text-verify-phone-principal").css("display", "block");
                    $('.input-tel__input').addClass('is-invalid')
                    return;
                } else {
                    $("#text-verify-phone-principal").css("display", "none");
                    $('.input-tel__input').removeClass('is-invalid')

                }

                if (this.aspirant.urlDataArchive.length === 0) {
                    $("#text-verify-archive-document-aspirant").css("display", "block");
                    $('#dpz-archives-register-aspirant').addClass('is-invalid')
                    return;

                } else {
                    $("#text-verify-archive-document-aspirant").css("display", "none");
                    $('#dpz-archives-register-aspirant').removeClass('is-invalid')

                }

                if (this.project.dataArchiveMusicPrincipal.length === 0) {
                    $("#text-verify-archive-music-principal").css("display", "block");
                    $('#dpz-archives-music-principal').addClass('is-invalid')
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
                /*=============================================
                    DATOS DEL PROYECTO
                =============================================*/
                data.append('project_name', this.project.name);
                data.append('project_name_author', this.project.nameAuthor);
                data.append('project_description', this.project.description);
                data.append('project_category', JSON.stringify(this.project.category));
                data.append('project_audio', JSON.stringify(this.project.dataArchiveMusicPrincipal));

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
        alertToastError() {
            this.$toast.error({
                title: 'Error',
                message: 'Por favor revise que todos los campos esten llenos o bien diligenciados',
                showDuration: 1000,
                hideDuration: 6000,
                position: 'top right',
            })
        }
    },

    watch: {
        'aspirant.urlDataArchive': function (val) {
            if (this.aspirant.urlDataArchive.length > 0) {
                $("#text-verify-archive-document-aspirant").css("display", "none");
            }
        },
        'aspirant.phone': function (val) {
            if (this.aspirant.phone !== '' || this.aspirant.phone !== null) {
                $("#text-verify-phone-principal").css("display", "none");
            }
            if (val) {
                setTimeout(() => {
                    let valid = $(".input-phone-number").hasClass("is-valid")

                    if (valid) {
                        $('#phoneAspirant-7_phone_number').removeClass('is-invalid')
                        $("#text-verify-phone-valid").css("display", "none");
                    } else {
                        $('#phoneAspirant-7_phone_number').addClass('is-invalid')
                        $("#text-verify-phone-valid").css("display", "block");

                    }
                }, 200)

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
    }

}
</script>

<style scoped>

</style>
