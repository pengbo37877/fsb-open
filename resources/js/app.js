/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.Vapor = require('laravel-vapor');

import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(VueLoading);

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import store from "./store"

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Dashboard from "./components/Dashboard.vue"
import AntiBars from "./components/AntiBars.vue"
import CreateAntiBar from "./components/CreateAntiBar.vue"
import CustomCode from "./components/CustomCode.vue"
import Performance from "./components/Performance.vue"

const routes = [

    {
        path: '/',
        component: AntiBars,
        name: 'Bars'
    },
    {
        path: '/anti/create',
        component: CreateAntiBar,
        name: 'Create'
    },
    {
        path: '/anti/:id/edit',
        component: CreateAntiBar,
        name: 'Edit'
    },
    {
        path: '/custom',
        component: CustomCode,
        name: 'CustomCode'
    },
    {
        path: '/performance',
        component: Performance,
        name: 'Performance'
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    store,
});

window.Vue = app
