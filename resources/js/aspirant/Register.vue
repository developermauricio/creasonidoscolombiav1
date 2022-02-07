<template>
    <div class="card">
        <div class="card-body">
            <!--=====================================
             COMPONENTE DATOS PERSONALES
            ======================================-->
            <aspirant-data-personal-register-component v-on:dataRegisterPersonal="dataRegisterPersonal"></aspirant-data-personal-register-component>
            <hr>
            <!--=====================================
             COMPONENTE DATOS DEL PROYECTO
            ======================================-->
            <aspirant-project-register-component v-on:dataRegisterProject="dataRegisterProject" :name="user_auth_name" :last_name="user_auth_last_name"></aspirant-project-register-component>

            <!--=====================================
             GUARDAR INFORMACIÓN
            ======================================-->
            <div class="row pt-5">
                <div class="col-12">
                    <button @click="registerInformation()" class="btn btn-primary btn-block">Registrar Información</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueSweetalert2 from 'vue-sweetalert2';
import Swal from "sweetalert2";
export default {
    name: "Register",
    components:{
        VueSweetalert2
    },
    data(){
        return{
            validate: false,
            user_auth_name: window.user_name,
            user_auth_last_name: window.user_last_name,
            project: null,
            aspirant: null,
        }
    },

    methods:{

        dataRegisterPersonal(data){
            this.aspirant = data
        },

        dataRegisterProject(data){
            this.project = data
        },
        registerInformation(){
            eventBus.$emit("validarFormulario");
            setTimeout(() => {
                let resp = this;
                /***  VALIDANDO LOS ERRORES Y MOSTRANDO UNA ALERTA  ***/
                this.validations()
                if (this.validate === true){
                    return
                }

                const data = new FormData()
                data.append('name', this.aspirant.user_auth_name);

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
                    }
                });
            }, 200);
        },

        validations(){
            this.validate = true
            if (document.querySelectorAll(".is-invalid").length > 0 ) {
                if (this.aspirant.phone === '' || this.aspirant.phone === null){
                    $("#text-verify-phone-principal").css("display", "block");
                    $('.input-tel__input').addClass('is-invalid')
                }

                if (this.aspirant.urlDataArchive.length === 0){
                    $("#text-verify-archive-document-aspirant").css("display", "block");
                    $('#dpz-archives-register-aspirant').addClass('is-invalid')
                }

                if (this.project.dataArchiveMusicPrincipal.length === 0){
                    $("#text-verify-archive-music-principal").css("display", "block");
                    $('#dpz-archives-music-principal').addClass('is-invalid')
                }

                if (this.aspirant.selectAspirantType === null || this.aspirant.selectAspirantType === ''){
                    $("#text-verify-line-participation").css("display", "block");
                    $('#text-line-participation').addClass('is-invalid')
                }

                this.alertToastError()
                return;
            }else{
                this.validate = false
            }

            if (this.aspirant.phone === '' || this.aspirant.phone === null){
                $("#text-verify-phone-principal").css("display", "block");
                $('.input-tel__input').addClass('is-invalid')
                return;
            }else{
                this.validate = false
            }

            if (this.aspirant.urlDataArchive.length === 0){
                $("#text-verify-archive-document-aspirant").css("display", "block");
                $('#dpz-archives-register-aspirant').addClass('is-invalid')
                return;

            }else{
                this.validate = false
            }

            if (this.project.dataArchiveMusicPrincipal.length === 0){
                $("#text-verify-archive-music-principal").css("display", "block");
                $('#dpz-archives-music-principal').addClass('is-invalid')
                return;

            }else{
                this.validate = false
            }

            if (this.aspirant.selectAspirantType === null || this.aspirant.selectAspirantType === ''){
                $("#text-verify-line-participation").css("display", "block");
                $('#text-line-participation').addClass('is-invalid')
                return;

            }else{
                this.validate = false
            }

        },
        alertToastError(){
            this.$toast.error({
                title: 'Error',
                message: 'Por favor revise que todos los campos esten llenos',
                showDuration: 1000,
                hideDuration: 6000,
                position: 'top right',
            })
        }
    },

    watch: {
        'aspirant.urlDataArchive':function (val) {
            if (this.aspirant.urlDataArchive.length > 0){
                $("#text-verify-archive-document-aspirant").css("display", "none");
            }
        },
        'aspirant.phone':function (val) {
            if (this.aspirant.phone !== '' || this.aspirant.phone !== null) {
                $("#text-verify-phone-principal").css("display", "none");
            }
            if (val) {
               // let textoAreaDividido = val.split(" ");
               // let numeroPalabras = textoAreaDividido.length;
               // console.log(numeroPalabras)
               //  let nums = val.trim()
               //  console.log(nums.length)
               //  if (nums.length === 11) {
               //      $('#phoneAspirant-7_phone_number').removeClass('is-invalid')
               //  } else {
               //      $('#phoneAspirant-7_phone_number').addClass('is-invalid')
               //  }
                let contiene = $(".input-phone-number").hasClass("has-hint")
                console.log(contiene)
                if (document.querySelector(".has-hint")){
                    // alert('si existe')
                    $('#phoneAspirant-7_phone_number').removeClass('is-invalid')
                }else{
                    $('#phoneAspirant-7_phone_number').addClass('is-invalid')
                }
            }
        },
        'project.dataArchiveMusicPrincipal':function (val) {
            if (this.project.dataArchiveMusicPrincipal.length > 0){
                $("#text-verify-archive-music-principal").css("display", "none");
            }
        },
        'aspirant.selectAspirantType':function (val) {
            if (this.aspirant.selectAspirantType !== '' || this.aspirant.selectAspirantType !== null){
                $("#text-verify-line-participation").css("display", "none");
            }
        },
    }

}
</script>

<style scoped>

</style>
