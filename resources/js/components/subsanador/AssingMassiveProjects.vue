<template>
    <div>
        <button @click="openModal = true" class="btn btn-primary"> Asignar Proyectos Masivamente</button>
        <vs-popup fullscreen class="holamundo" title="Asignar masivamente" :active.sync="openModal">
            <p>En la tabla se muestra la lista de curadores y las modalidades al que pertenece o esta asociado cada cada
                curador. Al momento de asignar masivamente, el sistema busca los curadores que pertenecen a la modalidad
                seleccionada y los asigna.
                Por ejemplo: Si hay dos curadores con la modalidad urbana, y 10 proyectos con la modalidad urbana: el
                sistema reparte 5 a cada curador.</p>
            <div class="row mt-2">
                <div class="col-12">
                    <h4 class="text-primary font-weight-bold">Curadores registrados</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 col-md-4">
                    <label>Buscar por nombre, apellido y correo electrónico</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon-search1"><i data-feather="search"></i></span>
                        </div>
                        <input type="text" v-model="filters.name.value" class="form-control"
                               placeholder="Buscar curador..." aria-label="Search..."
                               aria-describedby="basic-addon-search1"/>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="basicSelect">Filtrar por modalidad o categoría</label>
                        <select class="form-control" v-model="selectedModalide.id" id="basicSelect">
                            <option v-bind:value="0">Todos</option>
                            <option  v-bind:value="category.id" v-for="category in optionsCategories" :key="category.id">{{
                                    category.category
                                }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-12">
                    <div class="table-responsive">
                        <v-table
                            stripe
                            class="table table-striped table-hover"
                            max-items="5"
                            pagination
                            :filters="filters"
                            :data="listCuradors"
                            :hideSortIcons="true"
                            :currentPage.sync="currentPageChild"
                            :pageSize="10"
                            @totalPagesChanged="totalPagesChild = $event"
                        >
                            <template class="thead-default" slot="head">
                                <thead>
                                <tr>
                                    <v-th sortKey="aspirant[0].user.name">Nombres</v-th>
                                    <v-th sortKey="aspirant[0].user.last_name">Apellidos</v-th>
                                    <v-th sortKey="aspirant[0].user.last_name">Correo electrónico</v-th>
                                    <v-th sortKey="aspirant[0].user.last_name">Teléfono</v-th>
                                    <v-th sortKey="aspirant[0].user.city.departament.descripcion">Modalidad(es)
                                        Asignada(s)
                                    </v-th>
                                    <v-th># Proyectos asignados</v-th>
                                </tr>
                                </thead>
                            </template>
                            <template slot="body" slot-scope="{displayData}" class="table-striped">
                                <tr v-if="!listCuradors || listCuradors.length<1">
                                    <td><h3>No hay curadores registrados</h3></td>
                                </tr>
                                <tr v-for="(curador, index) in displayData" :key="curador.id">

                                    <td>{{ curador.user.name }}</td>
                                    <td>{{ curador.user.last_name }}</td>
                                    <td>{{ curador.user.email }}</td>
                                    <td>{{ curador.user.phone }}</td>
                                    <td v-html="renderBadgeCategory(curador.categories)"></td>
                                    <td class="text-center">{{ curador.projects_count }}</td>
                                </tr>
                            </template>
                        </v-table>
                        <div style="display: flex; justify-content: center">
                            <smart-pagination class="m-auto p-3" :currentPage.sync="currentPageChild"
                                              :totalPages="totalPagesChild"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-1">
                <div class="col-12">
                    <p>Para asignar masivamente, primero seleccione la categoría o modalidad y luego clic en "Asignar
                        Masivamente"</p>
                </div>
                <div class="col-12 col-lg-4 col-md-4">
                    <input-form
                        label="Seleccione la modalidad o categoría"
                        id="textCategoryProject"
                        errorMsg
                        requiredMsg="La modalidad es requerida"
                        :required="true"
                        :modelo.sync="categorySelected"
                        :msgServer.sync="errors.categorySelected"
                        type="multiselect"
                        selectLabel="Filtrar por modalidad"
                        :multiselect="{ options: optionsCategories,
                                           selectLabel:'Seleccionar',
                                           selectedLabel:'Seleccionado',
                                           deselectLabel:'Desmarcar',
                                           placeholder:'Modalidad o Categoría',
                                          taggable : false,
                                          'track-by':'id',
                                          label: 'name',
                                          'custom-label': category=>category.category
                                        }"
                    ></input-form>
                </div>
            </div>
            <div class="row mt-1" v-if="categorySelected">
                <div class="col-12">
                    <button @click="assignProjectsMassive()" class="btn btn-primary btn-block"> Asignar proyectos de la
                        modalidad {{ categorySelected.category }}
                    </button>
                </div>
            </div>
        </vs-popup>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import {publishMQTT} from "../../plugins/mqtt";

export default {
    name: "AssingMassiveProjects",
    data() {
        return {
            openModal: false,
            categorySelected: null,
            curadors: [],
            currentPageUser: 1,
            totalPagesUser: 0,
            currentPageChild: 1,
            totalPagesChild: 0,
            optionsCategories: [],
            selectedModalide: {
                id: null
            },
            errors: {},
            filters: {
                name: {
                    value: '', keys: [
                        'user.name',
                        'user.last_name',
                        'user.email',
                    ]
                }
            }
        }
    },
    methods: {
        renderBadgeCategory(listCategories){
           return listCategories.map(item => {
                return `<div class="badge badge-primary">${item.category}</div>`
            }).join(' ')
        },
        assignProjectsMassive() {
            eventBus.$emit("validarFormulario");
            setTimeout(() => {


                if (document.querySelectorAll("#validateCreateUser .is-invalid").length > 0) {
                    this.$toast.error({
                        title: 'Error',
                        message: 'Debe seleccionar una modalidad',
                        showDuration: 2000,
                        hideDuration: 9000,
                        position: 'top right',
                    })
                    return;
                }
                const data = new FormData()
                data.append('category', JSON.stringify(this.categorySelected));

                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Esta seguro de asignar con la categoría ' + this.categorySelected.category + '?',
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
                        axios.post('/api/subsanador/assign-project-massive', data).then(resp => {
                            this.$vs.loading.close()
                            this.$toast.success({
                                title: '¡Muy bien!',
                                message: 'La acción se realizó con éxito',
                                showDuration: 1000,
                                hideDuration: 5000,
                                position: 'top right',
                            })
                            this.$emit('loadDataProjects')
                            publishMQTT('mqtUpdateProjects', this.project)
                            this.categorySelected = null
                            this.$vs.loading.close()
                            // location.reload();
                        }).catch(err => {
                            if (err.response.status === 401) {
                                this.$vs.loading.close()
                                return this.$toast.error({
                                    title: 'Atención',
                                    message: err.response.data,
                                    showDuration: 1000,
                                    hideDuration: 10000,
                                    position: 'top right',
                                })
                            }
                            this.$toast.error({
                                title: 'Error',
                                message: 'Hubo un error, consulte con el administrador',
                                showDuration: 1000,
                                hideDuration: 8000,
                            })
                            this.$vs.loading.close()
                        })
                    }

                })
            }, 200)
        },
        async getCuradores() {
            await axios.get('/api/get-all-curadors').then(resp => {
                this.curadors = resp.data.data
            }).catch(err => {
                this.$toast.error({
                    title: 'Error',
                    message: 'Hubo un error, consulte al administrador',
                    showDuration: 1000,
                    hideDuration: 8000,
                })
            })
        },

        getApiCategoriesProject() {
            axios.get('/api/get-project-categories').then(resp => {
                this.optionsCategories = resp.data.data
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
    computed: {
        listCuradors: function () {
            let selectedCategory = this.selectedModalide.id
            let listCuradors = []
            if (selectedCategory === null || selectedCategory === 0){
                listCuradors = this.curadors
                return listCuradors;
            }
            if (this.selectedModalide) {
                 this.curadors.filter(item => {
                    let filtered = false
                    if (selectedCategory) {
                        item.categories.filter(category => {
                            if(category.id === selectedCategory){
                               filtered = true
                            }
                        })
                    }
                    if (filtered === true){
                        listCuradors.push(item)
                    }
                })
            }
            return listCuradors;
        }
    },
    mounted() {
        this.getCuradores();
        this.getApiCategoriesProject();
    }
}
</script>

<style scoped>

</style>
