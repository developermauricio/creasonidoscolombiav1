<template>
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <h2 class="card-title font-weight-bold mb-1 mt-3">Bienvenido</h2>
            <p class="card-text mb-2">Para iniciar el proceso de participación primero crea una cuenta.</p>
            <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-warning">
                <div class="alert-body text-justify">
                    Al momento de ingresar el correo electrónico, tenga en cuenta no dejar espacios.
                </div>
            </div>
            <form class="auth-register-form mt-2">
                <div class="form-group">
                    <input-form
                        id="txtNameAspirant"
                        label="Nombres completos"
                        pattern="alf"
                        errorMsg="Ingrese un nombre válido"
                        requiredMsg="Su nombre es requerido"
                        :modelo.sync="user.name"
                        :required="true"
                        :msgServer.sync="errors.name"
                    ></input-form>
                </div>
                <div class="form-group">
                    <input-form
                        id="txtLastNameAspirant"
                        label="Apellidos completos"
                        pattern="alf"
                        errorMsg="Ingrese un nombre válido"
                        requiredMsg="Sus apellidos son requeridos"
                        :modelo.sync="user.last_name"
                        :required="true"
                        :msgServer.sync="errors.last_name"
                    ></input-form>
                </div>
                <div class="form-group">
                    <input-form
                        id="txtEmailAspirant"
                        label="Correo electrónico"
                        pattern="email"
                        errorMsg="Ingrese un correo electrónico válido"
                        requiredMsg="Su correo electrónico es requerido"
                        :modelo.sync="user.email"
                        :required="true"
                        :msgServer.sync="errors.email"
                    ></input-form>
                    <p style="margin-top: -0.7rem;font-size: 0.9rem; display: none"
                       id="text-verify-email-aspirant" class="text-danger">El correo electrónico ya ha sido registrado,
                        por favor ingrese otro</p>
                </div>
                <div class="form-group d-flex">
                    <vs-checkbox color="#B53E2A" v-model="acceptTerm"></vs-checkbox>
                    <a target="_blank" href="https://www.creasonidos.com/wp-content/uploads/2022/04/1.-TERMINOS-DE-PARTICIPACION-CREASONIDOS-2022.pdf" style="margin-right:1.2rem">Acepto términos y politicas de privacidad</a>
                </div>
                <!--                <button :disabled="acceptTerm !== true" @click="accountCreate()" class="btn btn-primary btn-block"-->
                <!--                        tabindex="5">-->
                <!--                    Crear Cuenta-->
                <!--                </button>-->
                <p style="text-align: justify">Antes de crear la cuenta, por favor verifique que su nombre, apellidos y correo electrónico se encuentren bien escritos. <span style="font-weight: bold">Enviaremos a su correo electrónico la contraseña de acceso para que pueda registrar su propuesta musical</span></p>
                <button :disabled="!acceptTerm" @click.prevent="accountCreate()" class="btn btn-primary btn-block"
                        tabindex="5">
                    Crear Cuenta
                </button>
            </form>
            <div class="pt-1">
                <a target="_blank" href="https://www.creasonidos.com/contactanos" class="mt-5" style="color: #FD6E4A">¿Necesita ayuda?</a>
            </div>
            <p class="text-center mt-2"><span>Tienes una cuenta y quieres ingresar a tu perfil?</span><a
                href="/login"><span>&nbsp;Ingresar</span></a></p>
        </div>
    </div>
</template>

<script>
export default {
    name: "AccountCreate",
    data() {
        return {
            user: {
                name: '',
                last_name: '',
                email: ''
            },
            time: null,
            acceptTerm: false,
            errors: {},
        }
    },
    methods: {
        accountCreate() {
            eventBus.$emit("validarFormulario");

            setTimeout(() => {
                let resp = this;
                /***  VALIDANDO LOS ERRORES Y MOSTRANDO UNA ALERTA  ***/
                if (document.querySelectorAll(".is-invalid").length > 0) {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Por favor revise que todos los campos esten llenos',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                }
                if (this.acceptTerm === false) {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Debe aceptar los términos y políticas de privacidad',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    return;
                }

                const data = new FormData()
                data.append('name', this.user.name);
                data.append('last_name', this.user.last_name);
                data.append('email', this.user.email);
                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Esta seguro que su nombre, apellidos y correo electrónico están bien escritos?',
                    confirmButtonColor: "#11435b",
                    cancelButtonColor: "#B53E2A",
                    confirmButtonText: 'Si, crear cuenta',
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

                        axios.post('/api/aspirant/account-create', data).then(res => {
                            resp.$vs.loading.close()
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'Cuenta creada exitosamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            localStorage.setItem('email', this.user.email)
                            localStorage.setItem('message', 'Su cuenta ha sido creada. Hemos enviado un correo electrónico con la contraseña de acceso, esta contraseña la podrá cambiar cuando este registrando su propuesta musical')
                            // console.log('/'+this.language+"/profile")
                            window.location = "/login";

                        }).catch(err => {
                            this.$toast.error({
                                title: 'Error',
                                message: 'Hubo un error al crear la cuenta',
                                showDuration: 1000,
                                hideDuration: 8000,
                            })
                            resp.$vs.loading.close()
                        });
                    }
                })
            }, 200)
        },

        validetEmail(email) {

            setTimeout(() => {
                axios.get(`/api/verify-email-user/${email}`).then(resp => {
                    if (resp.data !== 300){
                        $('#txtEmailAspirant').addClass('is-invalid')
                        $('#text-verify-email-aspirant').css("display", "block");
                    }

                }).catch(err => {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Consulte con el administrador',
                        showDuration: 1000,
                        hideDuration: 8000,
                    })
                });
                this.$vs.loading.close()
            }, 1000)
        }
    },

    watch: {
        'user.email': function (val) {

            if (val) {
                $('#text-verify-email-aspirant').css("display", "none");
                if (this.time) {
                    clearTimeout(this.time)
                }

                this.time = setTimeout(() => {
                    this.$vs.loading({
                        color: '#11435b',
                        text: 'Validando correo electrónico...'
                    })
                    this.validetEmail(val)
                }, 1000);

            }
        }
    },

    mounted() {
        // this.$cookie.delete('creasonidos_colombia_session')
        // this.$cookie.delete('XSRF-TOKEN')
    }
}
</script>

<style>
.vs-checkbox--check .material-icons {
    font-size: 17px !important;
}
</style>
