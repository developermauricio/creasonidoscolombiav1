<template>
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <h2 class="card-title font-weight-bold mb-1">Bienvenido</h2>
            <p class="card-text mb-2">Para iniciar el proceso de participación, primero crea una cuenta</p>
            <form class="auth-register-form mt-2">
                <div class="form-group">
                    <input-form
                        id="txtNameAspirant"
                        label="Nombres"
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
                        label="Apellidos"
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
                </div>
                <div class="form-group d-flex justify-content-between">
                    <vs-checkbox color="#B53E2A" v-model="acceptTerm"></vs-checkbox>
                    <a href="/login" style="margin-right:1.2rem">Acepto términos y politicas de privacidad</a>
                </div>
<!--                <button :disabled="acceptTerm !== true" @click="accountCreate()" class="btn btn-primary btn-block"-->
<!--                        tabindex="5">-->
<!--                    Crear Cuenta-->
<!--                </button>-->
                <a @click="accountCreate()" class="btn btn-primary btn-block"
                        tabindex="5">
                    Crear Cuenta
                </a>
            </form>
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
                if (document.querySelectorAll(".is-invalid").length > 0 ) {
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
                    confirmButtonText: 'Si, todo bien',
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
                                title: '¡Todo salio bien!',
                                message: 'Cuenta creada exitosamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            // console.log('/'+this.language+"/profile")
                            // window.location = "/login";
                            location.reload();
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
        }
    },
}
</script>

<style>
.vs-checkbox--check .material-icons {
    font-size: 17px !important;
}
</style>
