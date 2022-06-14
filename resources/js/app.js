/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
import 'material-icons/iconfont/material-icons.css';
Vue.use(Vuesax);

import CxltToastr from 'cxlt-vue2-toastr'
Vue.use(CxltToastr)
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';

import SmartTable from 'vuejs-smart-table'
Vue.use(SmartTable)

import VuePlyr from 'vue-plyr'
import 'vue-plyr/dist/vue-plyr.css'
Vue.use(VuePlyr, {
    plyr: {}
})

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
/*COMPONENTES EXTERNOS*/
Vue.component('input-form', require('./components/InputFormComponent.vue').default);
Vue.component('dropzone-upload-document', require('./aspirant/components/DropzoneUploadDocument.vue').default);
Vue.component('dropzone-minor-upload-document', require('./aspirant/components/DropzoneMinorUploadDocument.vue').default);
Vue.component('dropzone-upload-music', require('./aspirant/components/DropzoneUploadMusic.vue').default);

Vue.component('dropzone-personal-document-photo', require('./aspirant/components/DropzonePersonalDocumentPhoto.vue').default);
Vue.component('dropzone-minor-document-photo', require('./aspirant/components/DropzoneMinorDocumentPhoto.vue').default);

Vue.component('aspirant-account-create-component', require('./aspirant/AccountCreate.vue').default);
Vue.component('aspirant-register-component', require('./aspirant/Register.vue').default);
Vue.component('aspirant-data-personal-register-component', require('./aspirant/components/DataPersonalRegister.vue').default);
Vue.component('aspirant-data-minor-register-component', require('./aspirant/components/DataPersonalMinor.vue').default);
Vue.component('aspirant-project-register-component', require('./aspirant/components/DataProjectRegister.vue').default);

Vue.component('aspirant-profile-component', require('./aspirant/profile/Profile.vue').default);
Vue.component('aspirant-profile-edit-component', require('./aspirant/profile/components/ProfileEdit.vue').default);
// Vue.component('aspirant-profile-data-personal', require('./aspirant/profile/components/DataPersonal.vue').default);

/*=============================================
 COMPONENTES CURADORES
=============================================*/
Vue.component('curador-project-component', require('./curador/Projects.vue').default);
/*=============================================
COMPONENTES SUBSANADOR
=============================================*/
// Vue.component('list-project-to-subsanar-component', require('./components/subsanador/ListProjectsToSubsanar').default);
Vue.component('subsanador-project-component', require('./subsanador/Projects.vue').default);
Vue.component('assign-massive-projects-component', require('./components/subsanador/AssingMassiveProjects.vue').default);
/*=============================================
COMPONENTES USUARIOS
=============================================*/
Vue.component('create-user-component', require('./users/CreateUser').default);
Vue.component('change-password-component', require('./users/ChangePassword.vue').default);
Vue.component('show-user-component', require('./users/ShowUser.vue').default);
/*=============================================
COMPONENTES PROYECTOS
=============================================*/
Vue.component('list-projects-by-subsanar-component', require('./components/projects/ListProjectBySubsanar').default);
Vue.component('list-projects-component', require('./components/projects/ListProject').default);
Vue.component('show-projects-component', require('./components/projects/ShowProject').default);

Vue.component('footer-component', require('./components/Footer.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.eventBus = new Vue();
const app = new Vue({
    el: '#app',
});
