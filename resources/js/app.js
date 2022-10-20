/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.Vue = require('vue-select').default;

import { createApp } from 'vue';
import Route from './routes';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
// import VMdDateRangePicker from "v-md-date-range-picker";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.use(VueRouter)
var Layout = require('./components/layout/Master.vue').default;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({
    data() {
        return {
            msg: 'Welcome'
        }
    }
});
app.component('Layout', Layout)
app.use(Route)
// app.use(VMdDateRangePicker);
app.use(Toast,{
    canTimeout:true,
    dismissible: false
})
app.mount('#app');
