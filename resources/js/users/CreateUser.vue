<template>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel17">Nuevo Usuario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
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
                        <p style="margin-top: -0.7rem;font-size: 0.9rem; display: none"
                           id="text-verify-email-user" class="text-danger">El correo electrónico ya ha sido registrado,
                            por favor ingrese otro</p>
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
                            selectLabel="Seleccione uno o varios roles"
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
                <!--=====================================
                    DATOS SI ES CURADOR
                ======================================-->
                <div v-if="showInfoCurador">
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5>Para el curador, ingrese lo siguientes datos: </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input-form
                                label="Asignar categorias o mdalidades"
                                id="textCategoriesProjects"
                                errorMsg
                                requiredMsg="Debe asignar al menos una categoría o modalidad"
                                :required="true"
                                :modelo.sync="curador.categories"
                                :msgServer.sync="errors.categories"
                                type="multiselect"
                                selectLabel="Asigne una o varias categorías"
                                :multiselect="{ 'tag-placeholder' : '',
                                          selectLabel   : 'Seleccionar',
                                          selectedLabel : 'Seleccionado',
                                          deselectLabel : 'Desmarcar',
                                          placeholder : 'Seleccione categoría',
                                          label : 'name',
                                          'track-by' : 'id',
                                          options : optionsCategoriesProjects,
                                          multiple : true,
                                          taggable : true,
                                          'custom-label': category => category.category
                                        }"
                                @tag="addTagRolesUser"
                            ></input-form>
                        </div>
                        <div class="col-12">
                            <input-form
                                type="textarea"
                                label="Biografía o reseña"
                                id="txtCuradorDescription"
                                pattern="all"
                                errorMsg="Ingrese texto válido"
                                requiredMsg="La reseña es requerida"
                                :required="true"
                                :modelo.sync="curador.biography"
                                :msgServer.sync="errors.biography"
                                :options="{
                                                rows: 5
                                                }"
                            >
                            </input-form>
                        </div>
                    </div>
                </div>
                <!--=====================================
                    DATOS SI ES SUBSANADOR
                ======================================-->
                <div v-if="showInfoSubsanador">
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5>Para el subsanador, ingrese lo siguientes datos: </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input-form
                                type="textarea"
                                label="Biografía o reseña"
                                id="txtCuradorDescription"
                                pattern="all"
                                errorMsg="Ingrese texto válido"
                                requiredMsg="La reseña es requerida"
                                :required="true"
                                :modelo.sync="subsanador.biography"
                                :msgServer.sync="errors.biography"
                                :options="{
                                                rows: 5
                                                }"
                            >
                            </input-form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button @click="createUser" type="button" class="btn btn-primary">Crear Usuario
            </button>
        </div>
    </div>
</template>

<script>
import VueSweetalert2 from 'vue-sweetalert2';
import Swal from "sweetalert2";

export default {
    name: "CreateUser",
    components: {
        VueSweetalert2
    },
    data() {
        return {
            user: {
                name: '',
                lastName: '',
                email: '',
                phone: '',
                document: '',
                documentType: null,
                roles: null,
            },
            curador: {
                categories: [],
                biography: '',
            },
            subsanador: {
                biography: '',
            },
            showInfoCurador: false,
            showInfoSubsanador: false,
            optionsDocumentTypes: [],
            optionsCategoriesProjects: [],
            optionsRoles: [],
            errors: {},
        }
    },
    methods: {
        createUser() {
            eventBus.$emit("validarFormulario");
            setTimeout(() => {
                let resp = this;
                /***  VALIDANDO LOS ERRORES Y MOSTRANDO UNA ALERTA  ***/
                if (document.querySelectorAll("#validateCreateUser .is-invalid").length > 0) {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Revisa que todos los campos que son obligatorios tengan datos',
                        showDuration: 2000,
                        hideDuration: 9000,
                        position: 'top right',
                    })
                    return;
                }
                const data = new FormData()
                data.append('name', this.user.name);
                data.append('last_name', this.user.lastName);
                data.append('email', this.user.email);
                data.append('phone', this.user.phone);
                data.append('document', this.user.document);
                data.append('document_type', JSON.stringify(this.user.documentType));
                data.append('roles', JSON.stringify(this.user.roles));
                if (this.showInfoCurador) {
                    data.append('curador', '1');
                    data.append('categories', JSON.stringify(this.curador.categories));
                    data.append('biography_curador', this.curador.biography)
                }
                if (this.showInfoSubsanador) {
                    data.append('subsanador', '1');
                    data.append('biography_subsanador', this.subsanador.biography)
                }
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

                        axios.post('/api/create-user', data).then(resp => {
                            this.$vs.loading.close()
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'Registro creado exitosamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            location.reload();
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

                })
            }, 200)
        },
        selectedRoles(data) {
            let curador = false;
            let subsanador = false;
            this.user.roles.find((item) => {
                return item.name === 'Curador' ? curador = true : curador = false
            })
            // curador ? this.showInfoCurador = true : this.showInfoCurador = false;
            if (curador) {
                this.showInfoCurador = true
            } else {
                this.showInfoCurador = false
                this.curador.categories = []
                this.curador.biography = ''
            }
            this.user.roles.find((item) => {
                return item.name === 'Subsanador' ? subsanador = true : subsanador = false
            })
            // curador ? this.showInfoCurador = true : this.showInfoCurador = false;
            if (subsanador) {
                this.showInfoSubsanador = true
            } else {
                this.showInfoSubsanador = false
                this.subsanador.biography = ''
            }
        },
        addTagRolesUser(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
            };
            this.options.push(tag);
            this.value.push(tag);
        },
        getApiRoles() {
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
        getApiCategoriesProject() {
            axios.get('/api/get-project-categories').then(resp => {
                this.optionsCategoriesProjects = resp.data.data
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
        validetEmail(email) {
            setTimeout(() => {
                axios.get(`/api/verify-email-user/${email}`).then(resp => {
                    if (resp.data !== 300){
                        $('#txtEmailUser').addClass('is-invalid')
                        $('#text-verify-email-user').css("display", "block");
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
                $('#text-verify-email-user').css("display", "none");
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
        this.getApiCategoriesProject();
        this.getApiDocumentTypes();
        this.getApiRoles();
    }
}
</script>

<style scoped>

</style>
