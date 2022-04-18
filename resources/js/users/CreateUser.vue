<template>
    <form class="" id="validateCreateUser" method="post">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    id="txtNameUser"
                    label="Nombre(s)"
                    pattern="all"
                    errorMsg="Ingrese un nombre"
                    requiredMsg="El nombre es requerido"
                    :modelo.sync="user.name"
                    :required="true"
                    :msgServer.sync="errors.name"
                ></input-form>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    id="txtLastNameUser"
                    label="Apellidos(s)"
                    pattern="all"
                    errorMsg="Ingrese apellidos válidos"
                    requiredMsg="Los apellidos son requeridos"
                    :modelo.sync="user.lastName"
                    :required="true"
                    :msgServer.sync="errors.lastName"
                ></input-form>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    id="txtEmailUser"
                    label="Correo electrónico"
                    pattern="email"
                    errorMsg="Ingrese un correo electrónico válido"
                    requiredMsg="El correo electrónico es requerido"
                    :modelo.sync="user.email"
                    :required="true"
                    :msgServer.sync="errors.email"
                ></input-form>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Tipo de Documento"
                    id="textDocumentTypenUser"
                    errorMsg
                    requiredMsg="El tipo de documento es requerido"
                    :required="true"
                    :modelo.sync="user.documentType"
                    :msgServer.sync="errors.documentType"
                    type="multiselect"
                    selectLabel="Tipo de documento"
                    :multiselect="{ options: optionsDocumentTypes,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Tipo de documento',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': documentType=>documentType.name
                                        }"
                ></input-form>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    id="txtDocumentUser"
                    label="Documento"
                    pattern="all"
                    errorMsg="Ingrese un documento válido"
                    requiredMsg="El documento es requerido"
                    :modelo.sync="user.document"
                    :required="true"
                    :msgServer.sync="errors.document"
                ></input-form>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <input-form
                        label="Celular"
                        id="txtPhoneUser"
                        pattern="all"
                        errorMsg="Ingrese un celular válido"
                        requiredMsg="El número de celular es requerido"
                        :required="true"
                        :modelo.sync="user.phone"
                        :msgServer.sync="errors.phone"
                        v-mask="'(###) ###-####'"
                    ></input-form>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <input-form
                    label="Seleccione rol"
                    id="textRolUser"
                    errorMsg
                    requiredMsg="El rol es requerido"
                    :required="true"
                    :modelo.sync="user.roles"
                    :msgServer.sync="errors.roles"
                    @updatedValue="selectedRoles"
                    type="multiselect"
                    selectLabel="Selecciona uno o varias roles"
                    :multiselect="{ 'tag-placeholder' : '',
                                          selectLabel   : 'Seleccionar',
                                          selectedLabel : 'Seleccionado',
                                          deselectLabel : 'Desmarcar',
                                          placeholder : 'Seleccione el rol',
                                          label : 'name',
                                          'track-by' : 'id',
                                          options : optionsRoles,
                                          multiple : true,
                                          taggable : true,
                                          'custom-label': roles => roles.name
                                        }"
                    @tag="addTagRolesUser"
                ></input-form>
            </div>
        </div>
        <div v-if="showInfoCurador">
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>Info Curador</h4>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "CreateUser",
    data(){
        return {
            user:{
                name: '',
                lastName: '',
                email: '',
                phone: '',
                document: '',
                documentType: null,
                roles: null,
            },
            showInfoCurador: false,
            optionsDocumentTypes: [],
            optionsRoles: [],
            errors: {},
        }
    },
    methods:{
        selectedRoles(){
            this.user.roles.map((item) =>{
                console.log(item);
                if(item.name === 'Curador'){
                    this.showInfoCurador = true
                }else{
                    this.showInfoCurador = false;
                }
            })
        },
        addTagRolesUser(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
            };
            this.options.push(tag);
            this.value.push(tag);
        },
        getApiRoles(){
            axios.get('/api/get-roles').then(resp => {
                this.optionsRoles = resp.data.data
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        getApiDocumentTypes() {
            axios.get('/api/get-document-types').then(resp => {
                this.optionsDocumentTypes = resp.data.data
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
    },
    mounted() {
        this.getApiDocumentTypes();
        this.getApiRoles();
    }
}
</script>

<style scoped>

</style>
