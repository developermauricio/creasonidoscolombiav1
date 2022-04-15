<template>
    <div class="card">
        <div class="card-body">
            <!--=====================================
                   INFORMACIÓN PERSONAL
                ======================================-->
            <div>
                <!--=====================================
                    SELECCIONAR LINEA DE LA CONVOCATORIA
                ======================================-->
                <div class="row pb-1">
                    <div class="col-12">
                        <h5 class="pb-1" id="text-line-participation">1. Selecciona tu linea de participación</h5>
                        <div class="d-flex" v-for="types in aspirantType" :key="types.id">
                            <vs-radio color="#11435b" v-model="aspirant_type_id" :vs-value="types.id"
                            >{{
                                    types.name
                                }}
                            </vs-radio>
                            <vs-tooltip :text="types.description">
                                <vs-icon size="small" class="pl-1 mb-1" icon="help_outline"
                                         style="cursor: pointer"></vs-icon>
                            </vs-tooltip>
                        </div>
                        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                           id="text-verify-line-participation" class="text-danger">Debes seleccionar la linea de
                            participación</p>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mt-2">
                        <input-form
                            label="Categoría de trayectorias"
                            id="textCategoryApirant"
                            errorMsg
                            requiredMsg="La categoría de trayectorias es requerido"
                            :required="true"
                            :modelo.sync="category_aspirant"
                            :msgServer.sync="errors.category_aspirant"
                            type="multiselect"
                            selectLabel="Seleccione en que categoría se encuentra"
                            :multiselect="{ options: optionsCategoryAspirant,
                                           selectLabel:'Seleccione en que categoría se encuentra',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Género',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': categoryAspirant=>categoryAspirant.name
                                        }"
                        ></input-form>
                        <span data-toggle="modal" data-target="#modal-show-info-category-aspirant" class="pr-2"
                              style="color: #114455; cursor: pointer">Clíc para más información</span>
                    </div>
                </div>
                <hr>
                <!--=====================================
                    DATOS PERSONALES DEL ASPIRANTE
                ======================================-->
                <!--=====================================
                       CAMPO NOMBRES
                   ======================================-->
                <h5 class="pb-1 pt-1">2. Información Personal</h5>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                id="txtNameAspirant"
                                label="Nombres"
                                pattern="alf"
                                errorMsg="Ingrese un nombre válido"
                                requiredMsg="Su nombre es requerido"
                                :modelo.sync="aspirant.user.name"
                                :required="true"
                                :msgServer.sync="errors.name"
                            ></input-form>
                        </div>
                    </div>
                    <!--=====================================
                       CAMPO APELLIDOS
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                id="txtLastNameAspirant"
                                label="Apellidos"
                                pattern="alf"
                                errorMsg="Ingrese apellidos válidos"
                                requiredMsg="Sus apellidos son requeridos"
                                :modelo.sync="aspirant.user.last_name"
                                :required="true"
                                :msgServer.sync="errors.last_name"
                            ></input-form>
                        </div>
                    </div>
                    <!--=====================================
                       CAMPO CORREO ELECTRÓNICO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                :disabled="1"
                                id="txtEmailAspirant"
                                label="Correo electrónico"
                                pattern="email"
                                errorMsg="Ingrese un correo electrónico válido"
                                requiredMsg="Su correo electrónico es requerido"
                                :modelo.sync="aspirant.user.email"
                                :required="true"
                                :msgServer.sync="errors.email"
                            ></input-form>
                        </div>
                    </div>
                    <!--=====================================
                       CAMPO TELÉFONO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <!--                            <label class="form-control-label">Celular <span class="text-danger">*</span></label>-->
                            <input-form
                                label="Celular"
                                id="phoneAspirant"
                                pattern="all"
                                errorMsg="Ingrese un celular valido"
                                requiredMsg="El celular es requerido"
                                :required="true"
                                :modelo.sync="aspirant.user.phone"
                                :msgServer.sync="errors.phone"
                                v-mask="'(###) ###-####'"
                            ></input-form>

                            <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none;"
                               id="text-verify-phone-principal" class="text-danger">
                                El número de celular es obligatorio
                            </p>
                            <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none;"
                               id="text-verify-phone-valid" class="text-danger">
                                Ingrese un número de celular válido
                            </p>
                        </div>
                    </div>
                    <!--=====================================
                       CAMPO CONFIRMAR TELÉFONO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                id="phoneAspirantConfirmed"
                                label="Confirmar celular"
                                pattern="all"
                                errorMsg="Ingrese un celular valido"
                                requiredMsg="La confirmación del celular es requerida"
                                :required="true"
                                :modelo.sync="phone_confirmed"
                                :msgServer.sync="errors.phone_confirmed"
                                v-mask="'(###) ###-####'"
                            ></input-form>
                            <p style="margin-top: -0.5rem;font-size: 0.9rem; display: none; font-weight: bold"
                               id="text-verify-phone" class="text-danger">
                                Verifique que el número de celular coincidan
                            </p>
                            <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none;"
                               id="text-verify-phone-confir-valide" class="text-danger">
                                La confirmación del celular es obligatorio
                            </p>
                        </div>
                    </div>
                    <!--=====================================
                       CAMPO SELECCIONAR FECHA DE NACIMIENTO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <input-form
                            label="Fecha de nacimiento"
                            id="txtAspirantFechaNacimiento"
                            pattern="all"
                            errorMsg="Ingrese una fecha de nacimiento válida"
                            requiredMsg="La fecha de nacimiento es requerida"
                            :required="true"
                            :modelo.sync="birthday"
                            :msgServer.sync="errors.birthday"
                            type="date"
                            :datepicker="{
                                                   'clear-button': false,
                                                  'bootstrap-styling':true,
                                                   'disabled-dates':state.disabledDates
                                                }"
                        ></input-form>
                    </div>
                    <!--=====================================
                       CAMPO SELECCIONAR GENERO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <input-form
                            label="Género"
                            id="textGenderApirant"
                            errorMsg
                            requiredMsg="El genero es requerido"
                            :required="true"
                            :modelo.sync="aspirant.user.gender"
                            :msgServer.sync="errors.gender"
                            type="multiselect"
                            selectLabel="Tipo de documento"
                            :multiselect="{ options: optionsGender,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Género',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': genders=>genders.name
                                        }"
                        ></input-form>
                    </div>
                    <!--=====================================
                       CAMPO SELECCIONAR DEPARTAMENTO
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <input-form
                            label="Departamento de residencia"
                            id="textDispatchDepartmentAspirant"
                            errorMsg
                            requiredMsg="El departamento de residencia es obligatorio"
                            :required="true"
                            :modelo.sync="departament"
                            :msgServer.sync="errors.departament"
                            type="multiselect"
                            @updatedValue="changeSelectDepartament"
                            selectLabel="Departamento"
                            :multiselect="{ options: optionsDepartaments,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Selecciona el departamento',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': dispatchDepartment=>dispatchDepartment.descripcion
                                        }"
                        ></input-form>
                    </div>
                    <!--=====================================
                       CAMPO SELECCIONAR CIUDAD
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6" v-if="departament">
                        <input-form
                            label="Ciudad o municipio de residencia"
                            id="textCityAspirant"
                            errorMsg
                            requiredMsg="La ciudad o municipio de residencia es obligatorio"
                            :required="true"
                            :modelo.sync="city"
                            :msgServer.sync="errors.city"
                            type="multiselect"
                            selectLabel="Departamento"
                            :multiselect="{ options: optionsCities,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Selecciona la ciudad o municipio',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': dispatchCity=>dispatchCity.descripcion
                                        }"
                        ></input-form>
                    </div>
                    <!--=====================================
                       CAMPO DIRECCIÓN
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                id="txtAddressAspirant"
                                label="Dirección"
                                pattern="all"
                                errorMsg="Ingrese una dirección de residencia válida"
                                requiredMsg="La dirección de residencia es requerida"
                                :modelo.sync="aspirant.user.address"
                                :required="true"
                                :msgServer.sync="errors.address"
                            ></input-form>
                        </div>
                    </div>
                    <!--=====================================
                       PERSPECTIVA ETNICA
                   ======================================-->
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <input-form
                                label="Perspectiva étnica"
                                id="textEthnicApirant"
                                errorMsg
                                requiredMsg="La perspectiva étnica es requerida"
                                :required="true"
                                :modelo.sync="ethnic"
                                :msgServer.sync="errors.ethnic"
                                type="multiselect"
                                selectLabel="Seleccione"
                                :multiselect="{ options: optionsEthnic,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Perspectiva étnica',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': ethnic=>ethnic.name
                                        }"
                            ></input-form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-md-3">
                        <div class="form-group">
                            <h5>Documento de identificación:</h5>
                            <div class="d-flex">
                                <span data-toggle="modal" data-target="#modal-show-pdf" class="pr-2"
                                      style="color: #114455; cursor: pointer">Ver documento</span>
                                <span v-if="!editDocument" class="pr-2" style="color: #114455; cursor: pointer"
                                      @click="(() => editDocument = true)">Clic para editar</span>
                                <span v-else class="pr-2 text-danger" style="cursor: pointer"
                                      @click="(() => editDocument = false)">Cancelar edición</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
                    SUBIR DOCUMENTO DE IDENTIFICACIÓN
                ======================================-->
                <div class="row" v-if="editDocument">
                    <div class="col-12 mt-1">
                        <h5 id="text-line-type-document">Seleccione como va a subir su documento de
                            identificación</h5>
                        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                           id="text-verify-type-document" class="text-danger">Debe agergar la foto o documento de
                            identificación</p>
                        <vs-radio color="#11435b" v-model="typeDocument" vs-name="typeDocument1" vs-value="1">
                            Agregar documento en pdf
                        </vs-radio>
                        <vs-radio color="#11435b" v-model="typeDocument" vs-name="typeDocument2" vs-value="2">
                            Agregar fotografía del documento
                        </vs-radio>
                    </div>
                    <div class="col-12 mt-2" v-if="typeDocument === '1'">
                        <label class="form-control-label" id="add-archive-dropzone-aspirant">Subir documento de
                            identificación<span style="color: red"> *</span></label>
                        <dropzone-upload-document v-on:dataUrl="datUrlDropzone"
                                                  :name="aspirant.user.name"
                                                  :lastName="aspirant.user.last_name"
                                                  :documentAspirantPdf="aspirant.cc_document_pdf"
                                                  :documentAspirantPhotoFrontal="aspirant.cc_document_frontal"
                                                  :documentAspirantPhotoBack="aspirant.cc_document_back"
                                                  :editAspirant="1"></dropzone-upload-document>
                        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                           id="text-verify-archive-document-aspirant" class="text-danger">El archivo del documento
                            es
                            obligatorio</p>
                    </div>
                    <div class="col-12 mt-1" v-if="typeDocument === '2'">
                        <dropzone-personal-document-photo
                            :name="aspirant.user.name"
                            :lastName="aspirant.user.last_name"
                            v-on:documentUrlPhotoFrontal="datUrlDropzonePhotoFrontal"
                            v-on:documentUrlPhotoBack="datUrlDropzonePhotoBack"
                        >
                        </dropzone-personal-document-photo>
                    </div>
                    <div class="d-flex pl-1 pt-1">
                        <span data-toggle="modal" data-target="#modal-example-pdf" class="pr-2"
                              style="color: #114455; cursor: pointer">Ver ejemplo en pdf</span>
                        <span data-toggle="modal" data-target="#modal-example-jpg"
                              style="color: #114455; cursor: pointer">Ver ejemplo en jpg (imagen)</span>
                    </div>
                    <!--=====================================
                        MODAL EJEMPLO CEDULA PDF
                    ======================================-->
                    <div class="modal fade text-left" id="modal-example-pdf" tabindex="-1" role="dialog"
                         aria-labelledby="modal-example-pdf" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel17">Ejemplo de un documento de
                                        identificación en
                                        pdf</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe src="/img/cedula-ejemplo.pdf" style="width:100%; height:700px;"
                                            frameborder="0">

                                    </iframe>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--=====================================
                        MODAL EJEMPLO CEDULA JPG
                    ======================================-->
                    <div class="modal fade text-left" id="modal-example-jpg" tabindex="-1" role="dialog"
                         aria-labelledby="modal-example-pdf" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="">Ejemplo de un documento de identificación en jpg</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img style="width: 100%" src="/img/cedula-ejemplo-jpg.jpg" alt="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--=====================================
               PREGUNTAS PERSONALES
           ======================================-->
                <div class="row mt-1 mb-1">
                    <div class="col-12">
                        <h5 id="text-line-questions">Responda las siguientes preguntas</h5>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="" id="title-headHousehold">¿Es padre o madre cabeza de hogar? <span
                            class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="aspirant.head_house_hold" vs-name="headHousehold"
                                  vs-value="Si">Si
                        </vs-radio>
                        <vs-radio color="#11435b" v-model="aspirant.head_house_hold" vs-name="headHousehold"
                                  vs-value="No">No
                        </vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="" id="title-victimConflict">¿Reporta ser víctima del conflicto?<span
                            class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="aspirant.victim_conflict" vs-name="victimConflict"
                                  vs-value="Si">Si
                        </vs-radio>
                        <vs-radio color="#11435b" v-model="aspirant.victim_conflict" vs-name="victimConflict"
                                  vs-value="No">No
                        </vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <label for="" id="title-disability">¿Posee alguna discapacidad?<span
                            class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="aspirant.disability" vs-name="disability" vs-value="Si">Si
                        </vs-radio>
                        <vs-radio color="#11435b" v-model="aspirant.disability" vs-name="disability" vs-value="No">No
                        </vs-radio>
                    </div>
                </div>

                <!--=====================================
                    DATOS PERSONALES DEL MENOR EDAD ACTUALIZAR
                ======================================-->
                <!--                <hr>-->
                <div v-if="aspirant_type_id === 3 && !showMinorCreate">
                    <h5 class="pb-1 pt-2">3. Información del Menor de Edad</h5>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input-form
                                    id="txtNameMinor"
                                    label="Nombres del menor de edad"
                                    pattern="alf"
                                    errorMsg="Ingrese un nombre válido"
                                    requiredMsg="El nombre del menor de edad es requerido"
                                    :modelo.sync="aspirant.parent.minor.name"
                                    :required="true"
                                    :msgServer.sync="errors.name"
                                ></input-form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input-form
                                    id="txtLastNameMinor"
                                    label="Apellidos del menor de edad"
                                    pattern="alf"
                                    errorMsg="Ingrese apellidos válidos"
                                    requiredMsg="Los apellidos del menor de edad son requeridos"
                                    :modelo.sync="aspirant.parent.minor.last_name"
                                    :required="true"
                                    :msgServer.sync="errors.last_name"
                                ></input-form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <input-form
                                label="Fecha de nacimiento"
                                id="txtMinorFechaNacimiento"
                                pattern="all"
                                errorMsg="Ingrese una fecha de nacimiento válida"
                                requiredMsg="La fecha de nacimiento del menor de edad es requerida"
                                :required="true"
                                :modelo.sync="birthday_minor"
                                :msgServer.sync="errors.birthday_minor"
                                type="date"
                                :datepicker="{
                                                   'clear-button': false,
                                                  'bootstrap-styling':true,
                                                   'disabled-dates':state_minor.disabledDates
                                                }"
                            ></input-form>
                        </div>
                        <div class="col-12 col-lg-3 col-md-3">
                            <div class="form-group">
                                <h5>Documento de identificación del menor de edad:</h5>
                                <div class="d-flex">
                                <span data-toggle="modal" data-target="#modal-show-minor-pdf" class="pr-2"
                                      style="color: #114455; cursor: pointer">Ver documento</span>
                                    <span v-if="!editDocumentMinor" class="pr-2" style="color: #114455; cursor: pointer"
                                          @click="(() => editDocumentMinor = true)">Clic para editar</span>
                                    <span v-else class="pr-2 text-danger" style="cursor: pointer"
                                          @click="(() => editDocumentMinor = false)">Cancelar edición</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>



                <!--=====================================
                    DATOS PERSONALES DEL MENOR EDAD crear
                ======================================-->
                <div v-if="aspirant_type_id === 3 && showMinorCreate">
                    <h5 class="pb-1 pt-2">3. Información del Menor de Edad</h5>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input-form
                                    id="txtNameMinorCreate"
                                    label="Nombres del menor de edad"
                                    pattern="alf"
                                    errorMsg="Ingrese un nombre válido"
                                    requiredMsg="El nombre del menor de edad es requerido"
                                    :modelo.sync="minor.name"
                                    :required="true"
                                    :msgServer.sync="errors.name"
                                ></input-form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input-form
                                    id="txtLastNameMinorCreate"
                                    label="Apellidos del menor de edad"
                                    pattern="alf"
                                    errorMsg="Ingrese apellidos válidos"
                                    requiredMsg="Los apellidos del menor de edad son requeridos"
                                    :modelo.sync="minor.last_name"
                                    :required="true"
                                    :msgServer.sync="errors.last_name"
                                ></input-form>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <input-form
                                label="Fecha de nacimiento"
                                id="txtMinorFechaNacimientoCreate"
                                pattern="all"
                                errorMsg="Ingrese una fecha de nacimiento válida"
                                requiredMsg="La fecha de nacimiento del menor de edad es requerida"
                                :required="true"
                                :modelo.sync="minor.birthday"
                                :msgServer.sync="errors.birthday"
                                type="date"
                                :datepicker="{
                                                   'clear-button': false,
                                                  'bootstrap-styling':true,
                                                   'disabled-dates':state_minor.disabledDates
                                                }"
                            ></input-form>
                        </div>
                        <div class="col-12 col-lg-3 col-md-3">
                            <div class="form-group">
                                <h5>Documento de identificación del menor de edad:</h5>
                                <div class="d-flex">
                                <span data-toggle="modal" data-target="#modal-show-minor-pdf" class="pr-2"
                                      style="color: #114455; cursor: pointer">Ver documento</span>
                                    <span v-if="!editDocumentMinor" class="pr-2" style="color: #114455; cursor: pointer"
                                          @click="(() => editDocumentMinor = true)">Clic para editar</span>
                                    <span v-else class="pr-2 text-danger" style="cursor: pointer"
                                          @click="(() => editDocumentMinor = false)">Cancelar edición</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>




                <!--=====================================
                     SUBIR DOCUMENTO DE IDENTIFICACIÓN MENOR DE EDAD
                 ======================================-->
                <div class="row" v-if="editDocumentMinor">
                    <div class="col-12 mt-1">
                        <h5 id="text-line-type-document-minor">Seleccione como va a subir el documento de
                            identificación del menor de edad</h5>
                        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                           id="text-verify-type-document-minor" class="text-danger">Debe agergar la foto o documento de
                            identificación</p>
                        <vs-radio color="#11435b" v-model="typeDocumentMinor" vs-name="typeDocument1" vs-value="1">
                            Agregar documento en pdf
                        </vs-radio>
                        <vs-radio color="#11435b" v-model="typeDocumentMinor" vs-name="typeDocument2" vs-value="2">
                            Agregar fotografía del documento
                        </vs-radio>
                    </div>
                    <div class="col-12" v-if="typeDocumentMinor === '1'">
                        <label class="form-control-label" id="add-archive-dropzone-minor">Subir documento de
                            identificación del menor de edad
                            <span style="color: red"> *</span></label>
                        <dropzone-minor-upload-document v-on:dataUrl="datUrlDropzoneMinor"
                                                        :name="aspirant.parent ? aspirant.parent.minor.name : minor.name"
                                                        :lastName="aspirant.parent ? aspirant.parent.minor.last_name : minor.last_name"></dropzone-minor-upload-document>
                        <p style="margin-top: 0.3rem;font-size: 0.9rem; display: none"
                           id="text-verify-archive-document-minor" class="text-danger">El archivo del documento del
                            menor de edad es
                            requerido</p>
                    </div>
                    <div class="col-12 mt-1" v-if="typeDocumentMinor === '2'">
                        <dropzone-minor-document-photo
                            :name="aspirant.parent ? aspirant.parent.minor.name : minor.name"
                            :lastName="aspirant.parent ? aspirant.parent.minor.last_name : minor.last_name"
                            v-on:documentUrlPhotoFrontal="datUrlDropzoneMinorPhotoFrontal"
                            v-on:documentUrlPhotoBack="datUrlDropzoneMinorPhotoBack"
                        >
                        </dropzone-minor-document-photo>
                    </div>
                </div>

            </div>

            <!--=====================================
                   DATOS DEL PROYECTO
                ======================================-->
            <div class="pt-1">
                <h5 class="pb-1">{{ aspirant_type_id === 3 ? '4.' : '3.' }} Datos de la propuesta musical</h5>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-6">
                        <input-form
                            id="txtProjectName"
                            label="Título de la canción"
                            pattern="all"
                            errorMsg="Ingrese un título válido"
                            requiredMsg="El título de la canción es requerido"
                            :modelo.sync="aspirant.projects[0].title"
                            :required="true"
                            :msgServer.sync="errors.name"
                        ></input-form>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6">
                        <input-form
                            id="txtProjectNameAuthor"
                            label="Nombre del autor o compositor"
                            pattern="all"
                            errorMsg="Ingrese un nombre del autor o compositor válido"
                            requiredMsg="El nombre del autor o compositor es requerido"
                            :modelo.sync="aspirant.projects[0].name_author"
                            :required="true"
                            :msgServer.sync="errors.nameAuthor"
                        ></input-form>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <input-form
                            id="txtProjectGenderMusic"
                            label="Género musical de la canción"
                            pattern="all"
                            errorMsg="Ingrese un nombre de género musical válido"
                            requiredMsg="El género musical es requerido"
                            :modelo.sync="aspirant.projects[0].category_by_aspirant"
                            :required="true"
                            :msgServer.sync="errors.nameAuthor"
                        ></input-form>
                        <!--                        <input-form-->
                        <!--                            label="Modalidad o categoría de la canción"-->
                        <!--                            id="textProjectCategory"-->
                        <!--                            errorMsg-->
                        <!--                            requiredMsg="La modalidad o categoría es obligatorio"-->
                        <!--                            :required="true"-->
                        <!--                            :modelo.sync="category"-->
                        <!--                            :msgServer.sync="errors.category"-->
                        <!--                            type="multiselect"-->
                        <!--                            selectLabel="Tipo de documento"-->
                        <!--                            :multiselect="{ options: optionsProjectCategory,-->
                        <!--                                           selectLabel:'Seleccionar',-->
                        <!--                                           selectedLabel:'Seleccionado',-->
                        <!--                                           deselectLabel:'Desmarcar',-->
                        <!--                                           placeholder:'Seleccione Modalidad',-->
                        <!--                                          taggable : false,-->
                        <!--                                          'track-by':'id',-->
                        <!--                                          label: 'category',-->
                        <!--                                          'custom-label': category=>category.category-->
                        <!--                                        }"-->
                        <!--                        ></input-form>-->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mt-2">
                        <span v-if="!editArchiveAudio" class="pr-2" style="color: #114455; cursor: pointer"
                              @click="(() => editArchiveAudio = true)">Clic para editar audio</span>
                        <span v-else class="pr-2 text-danger" style="cursor: pointer"
                              @click="(() => editArchiveAudio = false)">Cancelar editar audio</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input-form
                            type="textarea"
                            label="Escriba aquí una breve reseña"
                            id="txtProjectDescription"
                            pattern="all"
                            errorMsg="Ingrese texto válido"
                            requiredMsg="La reseña es obligatoria"
                            :required="true"
                            :modelo.sync="aspirant.projects[0].description"
                            :msgServer.sync="errors.description"
                            :options="{
                                                rows: 5
                                                }"
                        >
                        </input-form>
                    </div>
                </div>
                <!--=====================================
                       COMPONENTE PARA SUBIR EL AUDIO
                   ======================================-->
                <div v-if="editArchiveAudio">
                    <dropzone-upload-music v-on:dataUrlMusicPrincipal="datUrlDropzoneUrlAudio"
                                           :urlArchiveAudio="aspirant.projects[0].audio" editArchiveAudio="1"
                                           :nameProject="aspirant.projects[0].title" :name="aspirant.user.name"
                                           :lastName="aspirant.user.last_name"></dropzone-upload-music>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <h5 class="pb-1 pt-2">Por favor responda:</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-1">
                        <label for="" id="title-vinculad-ecopetrol">¿Usted tiene vínculo con Ecopetrol? <span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="vinculado_ecopetrol" vs-name="vinculado_ecopetrol"  vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="vinculado_ecopetrol"  vs-name="vinculado_ecopetrol" vs-value="No">No</vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-1" v-if="vinculado_ecopetrol ==='Si'">
                        <label for="" id="title-primero-empleo_ecopetrol">¿Su primer empleo ha sido con Ecopetrol?<span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="primer_empleo_ecopetrol" vs-name="primer_empleo_ecopetrol" vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="primer_empleo_ecopetrol" vs-name="primer_empleo_ecopetrol" vs-value="No">No</vs-radio>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3" v-if="vinculado_ecopetrol ==='Si'">
                        <label for="" id="title-bachiller-colombia-ecopetrol">¿Usted ha sido beneficiario del programa bachilleres por Colombia de Ecopetrol?<span class="text-danger"> *</span></label>
                        <vs-radio color="#11435b" v-model="bachilleres_colombia_ecopetrol" vs-name="bachilleres_colombia_ecopetrol" vs-value="Si">Si</vs-radio>
                        <vs-radio color="#11435b" v-model="bachilleres_colombia_ecopetrol" vs-name="bachilleres_colombia_ecopetrol" vs-value="No">No</vs-radio>
                    </div>
                </div>
            </div>
            <!--=====================================
             ACEPTA LOS TERMINOS Y CONDICIONES
            ======================================-->
            <div class="pt-2">
                <p>Usted cuentan con mínimo seis (6) canciones
                    inéditas (obras musicales sin publicar); o de lo contrario “aceptar” en la casilla que están
                    dispuestos a colaborar con autores - compositores vinculados CREASONIDOS.</p>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <vs-radio color="#11435b" v-model="aspirant.accept_termi" vs-name="radios1" vs-value="1">Si
                                cuento con
                                mínimo seis (6) canciones ineditas
                            </vs-radio>
                            <vs-radio color="#11435b" v-model="aspirant.accept_termi" vs-name="radios1" vs-value="2">
                                Acepto
                                compositores emanados del proceso CREASONIDOS
                            </vs-radio>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="pb-1 pt-2">{{ aspirant_type_id ? '5.' : '4.' }} Cambiar contraseña</h5>
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
            <!--=====================================
             GUARDAR INFORMACIÓN
            ======================================-->
            <div class="row pt-1">
                <div class="col-12">
                    <button :disabled="!aspirant.accept_termi" @click.prevent="saveEditProfile()"
                            class="btn btn-primary btn-block">Actualizar Perfil
                    </button>
                </div>
            </div>
        </div>
        <!--=====================================
		        MODAL INFORMACIÓN DE LAS CATEGORIAS
            ======================================-->
        <div class="modal fade text-left" id="modal-show-info-category-aspirant" tabindex="-1" role="dialog"
             aria-labelledby="modal-show-info-category-aspirant" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">¿Que es Categoría de Trayectorias?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-for="(category, index) in optionsCategoryAspirant" :key="category.id" class="p-1">
                            <h4>{{ index + 1 }}. {{ category.name }}:</h4>
                            <p>{{ category.description }}:</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import Multiselect from "vue-multiselect";
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import moment from "moment";
import Swal from "sweetalert2";

export default {
    name: "ProfileEdit",
    components: {
        VuePhoneNumberInput,
        vue2Dropzone,
        Multiselect,
        Datepicker,

    },
    data() {
        return {
            ethnic: null,
            category_aspirant: null,
            password: '',
            confirmed_password: '',
            vinculado_ecopetrol: null,
            primer_empleo_ecopetrol: null,
            bachilleres_colombia_ecopetrol: null,
            minor:{
                name: null,
                last_name: null,
                document_pdf: null,
                document_photo_frontal: null,
                document_photo_back: null
            },
            showMinorCreate: false,
            cc_document_frontal: null,
            cc_document_back: null,
            cc_document_pdf: null,
            en: en,
            es: es,
            user: {},
            acceptTerm: null,
            editDocument: false,
            editDocumentMinor: false,
            editArchiveAudio: false,
            aspirantType: [],
            optionsDepartaments: [],
            optionsCities: [],
            optionsGender: [],
            optionsProjectCategory: [],
            phone_confirmed: '',
            departament: null,
            category: null,
            city: null,
            errors: {},
            aspirant_type_id: null,
            birthday: null,
            birthday_minor: null,
            currentDate: null,
            currentDate_minor: null,
            typeDocument: null,
            typeDocumentMinor: null,
            state_minor: {
                disabledDates: {
                    from: null, // Disable all dates up to specific date
                    // from: new Date(2016, 0, 26), // Disable all dates after specific date
                },
                date: new Date()
            },
            state: {
                disabledDates: {
                    from: null, // Disable all dates up to specific date
                    // from: new Date(2016, 0, 26), // Disable all dates after specific date
                },
                date: new Date()
            },
            optionsEthnic: [],
            optionsCategoryAspirant: [],
        }
    },

    props: ['aspirant'],

    methods: {
        datUrlDropzonePhotoFrontal(data) {
            this.aspirant.cc_document_frontal = data[0].urlArchive;
            console.log(data[0].urlArchive)
        },
        datUrlDropzonePhotoBack(data) {
            this.aspirant.cc_document_back = data[0].urlArchive;

        },
        datUrlDropzoneMinor(data) {
            if (!this.showMinorCreate){
                this.aspirant.parent.minor.document_pdf = data[0].urlArchive
            }else{
                this.minor.document_pdf = data[0].urlArchive
            }

            // this.aspirant.parent.minor.extension_document = data[0].extension
        },
        datUrlDropzoneMinorPhotoFrontal(data) {
            if (!this.showMinorCreate) {
                this.aspirant.parent.minor.document_photo_frontal = data[0].urlArchive
            }else{
                this.minor.document_photo_frontal = data[0].urlArchive
            }
            // this.aspirant.parent.minor.extension_document = data[0].extension
        },
        datUrlDropzoneMinorPhotoBack(data) {
            if (!this.showMinorCreate) {
                this.aspirant.parent.minor.document_photo_back = data[0].urlArchive
            }else{
                this.minor.document_photo_back = data[0].urlArchive
            }
            // this.aspirant.parent.minor.extension_document = data[0].extension
        },

        datUrlDropzone(data) {
            this.aspirant.cc_document_pdf = data[0].urlArchive
            console.log(data[0].urlArchive)
        },
        datUrlDropzoneUrlAudio(data) {
            this.aspirant.projects[0].audio = data[0].urlArchive
        },

        saveEditProfile() {
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


                    if (this.aspirant.cc_document === '') {
                        $("#text-verify-archive-document-aspirant").css("display", "block");
                        $('#dpz-archives-register-aspirant').addClass('is-invalid')
                    }

                    if (this.aspirant.projects[0].audio === '') {
                        $("#text-verify-archive-music-principal").css("display", "block");
                        $('#dpz-archives-music-principal').addClass('is-invalid')
                    }
                    if (this.aspirant.aspirant_type_id === null) {
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

                if (this.aspirant.cc_document === '') {
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

                if (this.aspirant.projects[0].audio === '') {
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
                if (this.aspirant.aspirant_type_id === '' || this.aspirant.aspirant_type_id === null) {
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
                data.append('user_id', this.aspirant.user_id);
                data.append('aspirant_id', this.aspirant.id);
                data.append('aspirant_type', this.aspirant_type_id);
                data.append('name', this.aspirant.user.name);
                data.append('last_name', this.aspirant.user.last_name);
                data.append('email', this.aspirant.user.email);
                data.append('phone', this.aspirant.user.phone);
                data.append('birthday', moment(this.birthday).format("YYYY-MM-DD HH:mm:ss"))
                data.append('genero', JSON.stringify(this.aspirant.user.gender));
                data.append('ethnic_id', JSON.stringify(this.ethnic));
                data.append('category_aspirant_id', JSON.stringify(this.category_aspirant));
                data.append('city', JSON.stringify(this.city));
                data.append('address', this.aspirant.user.address);
                data.append('archive', this.aspirant.cc_document_pdf);
                data.append('archiveDocumentPhotoFrontal', JSON.stringify(this.aspirant.cc_document_frontal));
                data.append('archiveDocumentPhotoBack', JSON.stringify(this.aspirant.cc_document_back));
                data.append('headHousehold', this.aspirant.head_house_hold);
                data.append('victimConflict', this.aspirant.victim_conflict);
                data.append('disability', this.aspirant.disability);
                data.append('acceptTerm', this.aspirant.accept_termi);
                data.append('vinculado_ecopetrol', this.vinculado_ecopetrol);
                data.append('primer_empleo_ecopetrol', this.primer_empleo_ecopetrol);
                data.append('bachilleres_colombia_ecopetrol', this.bachilleres_colombia_ecopetrol);

                if(!this.showMinorCreate && this.aspirant.parent){
                    data.append('minor_id', this.aspirant.parent.minor.id);
                    data.append('parent_id', this.aspirant.parent.id);
                }

                /*=============================================
                   DATOS DEL MENOR DE EDAD
               =============================================*/
                if (this.aspirant_type_id === 3 && !this.showMinorCreate) {
                    data.append('minor_id', this.aspirant.parent.minor.id);
                    data.append('parent_id', this.aspirant.parent.id);
                    data.append('name_minor', this.aspirant.parent.minor.name);
                    data.append('last_name_minor', this.aspirant.parent.minor.last_name);
                    data.append('birthday_minor', moment(this.birthday_minor).format("YYYY-MM-DD HH:mm:ss"))
                    data.append('document_pdf_minor', this.aspirant.parent.minor.document_pdf);
                    data.append('archiveDocumentMinorPhotoFrontal', JSON.stringify(this.aspirant.parent.minor.document_photo_frontal));
                    data.append('archiveDocumentMinorPhotoBack', JSON.stringify(this.aspirant.parent.minor.document_photo_back));
                    // data.append('extension_document_minor', this.aspirant.parent.minor.extension_document);
                }
                if(this.showMinorCreate && this.aspirant.parent === null){
                    data.append('createMinor', '1');
                    data.append('name_minor_create', this.minor.name);
                    data.append('last_name_minor_create', this.minor.last_name);
                    data.append('birthday_minor_create', moment(this.minor.birthday).format("YYYY-MM-DD HH:mm:ss"))
                    data.append('document_pdf_minor_create', this.minor.document_pdf);
                    data.append('archiveDocumentMinorPhotoFrontalCreate', JSON.stringify(this.minor.document_photo_frontal));
                    data.append('archiveDocumentMinorPhotoBackCreate', JSON.stringify(this.minor.document_photo_back));
                }
                /*=============================================
                    DATOS DEL PROYECTO
                =============================================*/
                data.append('project_id', this.aspirant.projects[0].id);
                data.append('project_name', this.aspirant.projects[0].title);
                data.append('project_name_author', this.aspirant.projects[0].name_author);
                data.append('project_description', this.aspirant.projects[0].description);
                data.append('project_category', JSON.stringify(this.category));
                data.append('project_audio', this.aspirant.projects[0].audio);

                /*=============================================
                    CONTRASEÑA
                =============================================*/
                data.append('password', this.password);

                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Esta seguro de actualizar?',
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
                        axios.post('/api/update-profile-register', data).then(resp => {
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'Su perfil se actualizó exitosamente',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            localStorage.setItem('message_project_confirmed', 'Su perfil se ha actualizado exitosamente')
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


        getEthnics() {
            axios.get('/api/get-ethnics').then(resp => {
                this.optionsEthnic = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        getProjectCategories() {
            this.$vs.loading({
                color: '11435b',
                text: 'Espere un momento por favor...'
            })
            setTimeout(() => {
                axios.get('/api/get-project-categories').then(resp => {
                    this.optionsProjectCategory = resp.data.data
                    this.$vs.loading.close()
                }).catch(err => {
                    console.log(err)
                    this.$toast.error({
                        title: 'Error',
                        message: 'Algo salió mal, consulte al administrador',
                        showDuration: 1000,
                        hideDuration: 6000,
                        position: 'top right',
                    })
                    this.$vs.loading.close()
                })
            }, 200)

        },

        getGenders() {
            axios.get('/api/get-genders').then(resp => {
                this.optionsGender = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },

        getCategoryAspirant() {
            axios.get('/api/get-category-aspirant').then(resp => {
                this.optionsCategoryAspirant = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },

        getAspirantType() {
            axios.get('/api/get-aspirant-types').then(resp => {
                this.aspirantType = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        changeSelectDepartament(value) {
            this.optionsCities = []
            this.city = null
            this.$vs.loading({
                color: '#11435b',
                text: 'Espere un momento por favor...'
            })

            setTimeout(() => {
                if (value !== null) {
                    axios.get(`/api/get-cities/${value.id}`).then(resp => {
                        this.optionsCities = resp.data.data
                    }).catch(err => {
                        console.log(err)
                        this.$toast.error({
                            title: 'Error',
                            message: 'Algo salió mal, consulte al administrador',
                            showDuration: 1000,
                            hideDuration: 6000,
                            position: 'top right',
                        })

                    })
                    this.$vs.loading.close()
                } else {
                    this.$vs.loading.close()
                }
            }, 200)
        },

        getDeparments() {
            axios.get('/api/get-departaments').then(resp => {
                this.optionsDepartaments = resp.data.data
            }).catch(err => {
                console.log(err)
                this.$toast.error({
                    title: 'Error',
                    message: 'Algo salió mal, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 6000,
                    position: 'top right',
                })
            })
        },
        addDaysToDate(date, days) {
            let res = new Date(date);
            res.setDate(res.getDate() + days);
            console.log(res)
            this.birthday = res;
        },
        addDaysToDateMinor(date, days) {
            let res = new Date(date);
            res.setDate(res.getDate() + days);

            this.birthday_minor = res;
        }

    },

    watch: {
        'aspirant_type_id': function (val){

          if (val === 3 && this.aspirant.parent === null){
              this.showMinorCreate = true
          }
        },
        typeDocument: function (val) {
            if (val) {
                this.aspirant.cc_document_frontal = ''
                this.aspirant.cc_document_back = ''
                this.aspirant.cc_document_pdf = ''
            }
        },
        typeDocumentMinor: function (val) {
            if (val && !this.showMinorCreate) {
                this.aspirant.parent.minor.document_pdf = ''
                this.aspirant.parent.minor.document_photo_frontal = ''
                this.aspirant.parent.minor.document_photo_back = ''
            }else{
                this.minor.document_pdf = ''
                this.minor.document_photo_frontal = ''
                this.minor.document_photo_back = ''
            }
        },
        'aspirant.user.phone': function (val) {
            if (val) {
                $('.input-tel__input').removeClass('is-invalid')
            } else {
                this.phone_confirmed = ''
            }
        },
        phone_confirmed: function (val) {
            if (val !== this.aspirant.user.phone && this.phone_confirmed) {
                $('#phoneAspirantConfirmed').addClass('is-invalid')
                $("#text-verify-phone").css("display", "block");
            } else {
                $("#text-verify-phone").css("display", "none");
                $('#phoneAspirantConfirmed').removeClass('is-invalid')
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

    },
    mounted() {
        // this.$emit('dataRegisterPersonal', this.aspirant);
        $('#phoneAspirantConfirmed').addClass('is-invalid')
        $("#text-verify-phone").css("display", "block");
        this.getAspirantType();
        this.getEthnics();
        this.getCategoryAspirant();
        this.getDeparments();
        this.getGenders();
        this.getProjectCategories()
        this.addDaysToDate(this.aspirant.user.birthday, 1)
        this.aspirant_type_id = this.aspirant.aspirant_type_id

        this.ethnic = this.aspirant.ethnic
        this.category_aspirant = this.aspirant.category_aspirant

        if (this.aspirant.parent !== null) {
            this.addDaysToDateMinor(this.aspirant.parent.minor.birthday, 1)
        }
        if (this.aspirant.aspirant_type_id === 3 && this.aspirant.parent === null){
            this.showMinorCreate = true
        }

        this.cc_document_frontal = this.aspirant.cc_document_frontal
        this.cc_document_back = this.aspirant.cc_document_back
        this.cc_document_pdf = this.aspirant.cc_document_pdf

        this.vinculado_ecopetrol = this.aspirant.vinculado_ecopetrol
        if (this.aspirant.vinculado_ecopetrol === 'Si'){
            this.primer_empleo_ecopetrol = this.aspirant.primer_empleo_ecopetrol
            this.bachilleres_colombia_ecopetrol = this.aspirant.bachilleres_colombia_ecopetrol
        }

        // this.phone_confirmed = this.aspirant.user.phone

        this.departament = this.aspirant.user.city.departament
        this.city = this.aspirant.user.city
        this.category = this.aspirant.projects[0].category

        this.currentDate = new Date()
        this.currentDate.setFullYear(this.currentDate.getFullYear() - 18)
        this.currentDate = this.currentDate.getFullYear() + 1
        this.state.disabledDates.from = new Date(this.currentDate, 0, 0);

        this.currentDate_minor = new Date()
        this.currentDate_minor.setFullYear(this.currentDate_minor.getFullYear() - 18)
        let month_minor = this.currentDate_minor.getMonth()
        let date_minor = this.currentDate_minor.getDate()
        this.currentDate_minor = this.currentDate_minor.getFullYear() + 1

        this.state_minor.disabledDates.to = new Date(this.currentDate_minor, month_minor, date_minor);


    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.con-vs-radio {
    justify-content: normal !important;
}

.vdp-datepicker__calendar {
    z-index: 1419 !important;
}
</style>
