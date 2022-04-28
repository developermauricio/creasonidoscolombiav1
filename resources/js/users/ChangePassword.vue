<template>
    <div>
        <input type="hidden" @click="openModal" id="openModalChangePassword"/>
        <vs-popup class="holamundo"  title="Cambiar Contraseña" :active.sync="openModalChangePassword">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="reset-password-new">Nueva contraseña <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" v-model="user.password" class="form-control form-control-merge"
                                   id="reset-password-new" name="reset-password-new" placeholder="nueva contraseña"
                                   aria-describedby="reset-password-new" tabindex="1"/>
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="reset-password-confirm">Confirmar contraseña <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" v-model="user.confirmed_password" class="form-control form-control-merge"
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
            <div class="row mt-1">
                <div class="col-12">
                    <button class="btn btn-block btn-primary" @click="updatePassword()">Actualizar Contraseña</button>
                </div>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "ChangePassword",
    data() {
        return {
            openModalChangePassword: false,
            currentUserId: window.user_ìd,
            user: {
                password: '',
                confirmed_password: ''

            }
        }
    },
    methods:{
        openModal(e) {
            e.preventDefault();
            this.openModalChangePassword = true
        },
        updatePassword(){
            setTimeout(() =>{
                if (this.user.password === '' || this.user.confirmed_password === ''){
                    this.$toast.error({
                        title: 'Error',
                        message: 'Para actualizar, ingrese una nueva contraseña',
                        showDuration: 1000,
                        hideDuration: 8000,
                    })
                    return
                }
                if (document.querySelectorAll(".is-invalid").length > 0) {
                    this.$toast.error({
                        title: 'Error',
                        message: 'La contraseña no coincide',
                        showDuration: 1000,
                        hideDuration: 8000,
                    })
                    return;
                }
                const data = new FormData()
                /*=============================================
                    CONTRASEÑA
                =============================================*/
                data.append('password', this.user.password);
                data.append('userId', this.currentUserId);
                    Swal.fire({
                        title: 'Confirmar',
                        text: '¿Esta seguro de actualizar la contraseña?',
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
                            this.$vs.loading({
                                color: '#11435b',
                                text: 'Espere un momento por favor...'
                            })
                            axios.post('/api/update-password', data).then(resp => {
                                this.$toast.success({
                                    title: '¡Muy bien!',
                                    message: 'Su contraseña se actualizó exitosamente',
                                    showDuration: 1000,
                                    hideDuration: 7000,
                                    position: 'top right',
                                })
                                this.$vs.loading.close()
                                this.openModalChangePassword = false
                                this.user.password = ''
                                this.user.confirmed_password = ''
                                // window.location = '/perfil'
                            }).catch(err => {
                                this.$toast.error({
                                    title: 'Error',
                                    message: 'Hubo un error al actualizar su contraseña',
                                    showDuration: 1000,
                                    hideDuration: 8000,
                                })
                                this.$vs.loading.close()
                            })
                        }
                    })
            }, 500)
        }
    },
    watch:{
        'user.confirmed_password': function (val) {
            if (val) {
                if (val !== this.user.password) {
                    $("#text-verify-confirmed-password-aspirant").css("display", "block");
                    $("#reset-password-confirm").addClass('is-invalid')
                } else {
                    $("#text-verify-confirmed-password-aspirant").css("display", "none");
                    $("#reset-password-confirm").removeClass('is-invalid')
                }
            }
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

</style>
