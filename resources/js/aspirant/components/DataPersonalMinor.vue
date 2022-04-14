<template>
    <div>
        <h5 class="pb-1 pt-1">3. Información Menor del Edad</h5>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="txtNameMinor"
                        label="Nombre completo del menor de edad"
                        pattern="alf"
                        errorMsg="Ingrese un nombre válido"
                        requiredMsg="El nombre del menor edad es requerido"
                        :modelo.sync="minor.name"
                        :required="true"
                        :msgServer.sync="errors.name"
                    ></input-form>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        id="txtLastNameMinor"
                        label="Apellidos completos del menor de edad"
                        pattern="alf"
                        errorMsg="Ingrese apellidos válidos"
                        requiredMsg="Los apellidos del menor edad son requeridos"
                        :modelo.sync="minor.last_name"
                        :required="true"
                        :msgServer.sync="errors.last_name"
                    ></input-form>
                </div>
            </div>
            <!--=====================================
               CAMPO SELECCIONAR FECHA DE NACIMIENTO
           ======================================-->
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Fecha de nacimiento"
                    id="txtMinorFechaNacimiento"
                    pattern="all"
                    errorMsg="Ingrese una fecha de nacimiento válida"
                    requiredMsg="La fecha de nacimiento es requerida"
                    :required="true"
                    :modelo.sync="minor.birthday"
                    :msgServer.sync="errors.birthday"
                    type="date"
                    :datepicker="{
                                                   'clear-button': false,
                                                  'bootstrap-styling':true,
                                                   'disabled-dates':state.disabledDates
                                                }"
                ></input-form>
            </div>
        </div>
        <div class="row pt-1">
            <div class="col-12 mt-1">
                <h5 id="text-line-type-document-minor">Seleccione como va a subir el documento de identificación del menor de edad</h5>
                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                   id="text-verify-type-document-minor" class="text-danger">Debe agergar la foto o documento de identificación del menor de edad</p>
                <vs-radio color="#11435b" v-model="minor.typeDocumentMinor" vs-name="typeDocumentMinor1" vs-value="1">Agregar documento en pdf
                </vs-radio>
                <vs-radio color="#11435b" v-model="minor.typeDocumentMinor" vs-name="typeDocumentMinor2" vs-value="2">Agregar fotografía del documento
                </vs-radio>
            </div>
            <div class="col-12" v-if="minor.typeDocumentMinor === '1'">
                <label class="form-control-label" id="add-archive-dropzone-aspirant">Subir documento de identificación del menor de edad
                    <span style="color: red"> *</span></label>
                <dropzone-minor-upload-document v-on:dataUrl="datUrlDropzone" :name="minor.name" :lastName="minor.last_name"></dropzone-minor-upload-document>
                <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                   id="text-verify-archive-document-minor" class="text-danger">El archivo del documento del menor de edad es
                    requerido</p>
            </div>
            <div class="col-12 mt-1" v-if="minor.typeDocumentMinor === '2'">
                <dropzone-minor-document-photo
                    :name="minor.name"
                    :lastName="minor.last_name"
                    v-on:documentUrlPhotoFrontal="datUrlDropzonePhotoFrontal"
                    v-on:documentUrlPhotoBack="datUrlDropzonePhotoBack"
                >
                </dropzone-minor-document-photo>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DataPersonalMinor",
    data() {
        return {
            minor: {
                name: '',
                last_name: '',
                birthday: null,
                urlDataArchive: [],
                typeDocumentMinor: null,
                urlDataDocumentPhotoFrontal: [],
                urlDataDocumentPhotoBack: [],
            },
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

    methods:{
        datUrlDropzonePhotoFrontal(data){
            this.minor.urlDataDocumentPhotoFrontal = data
        },
        datUrlDropzonePhotoBack(data){
            this.minor.urlDataDocumentPhotoBack = data
        },
        datUrlDropzone(data) {
            this.minor.urlDataArchive = data
        },
    },

    watch: {
        'minor.typeDocumentMinor': function (val){
            if (val){
                $("#text-verify-type-document-minor").css("display", "none");
                $('#text-line-type-document-minor').removeClass('is-invalid')
            }else{
                $("#text-verify-type-document-minor").css("display", "block");
                $('#text-line-type-document-minor').addClass('is-invalid')
            }
        },
        'minor.urlDataArchive': function (val){
            if (val){
                $("#text-verify-archive-document-minor").css("display", "none");
                $('#dpz-archives-register-minor').removeClass('is-invalid')
            }else{
                $("#text-verify-archive-document-minor").css("display", "block");
                $('#dpz-archives-register-minor').addClass('is-invalid')
            }
        },
        'minor.urlDataDocumentPhotoFrontal': function (val){
            if (val){
                $("#text-verify-archive-document-minor-frontal").css("display", "none");
                $('#dpz-archives-register-minor-frontal').removeClass('is-invalid')
            }else{
                $("#text-verify-archive-document-minor-frontal").css("display", "block");
                $('#dpz-archives-register-minor-frontal').addClass('is-invalid')
            }
        },

        'minor.urlDataDocumentPhotoBack': function (val){
            if (val){
                $("#text-verify-archive-document-minor-back").css("display", "none");
                $('#dpz-archives-register-minor-back').removeClass('is-invalid')
            }else{
                $("#text-verify-archive-document-minor-back").css("display", "block");
                $('#dpz-archives-register-minor-back').addClass('is-invalid')
            }
        },

    },

    mounted() {
        this.$emit('dataRegisterMinor', this.minor);
        this.currentDate = new Date()
        this.currentDate.setFullYear(this.currentDate.getFullYear() - 18)
        let month = this.currentDate.getMonth()
        let date = this.currentDate.getDate()
        this.currentDate = this.currentDate.getFullYear() + 1

        this.state.disabledDates.to = new Date(this.currentDate, month, date);
    }
}
</script>

<style scoped>
.con-vs-radio{
    justify-content: flex-start !important;
}
</style>
