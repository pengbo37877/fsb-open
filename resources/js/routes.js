import Vue from "vue";
import VueRouter from 'vue-router';
Vue.use(VueRouter)

var routes = [
    {
        path: '/',
        component: require('./components/Dashboard'),
        name: 'Home'
    },
    {
        path: '/anti',
        component: require('./components/AntiBars'),
        name: 'Bars'
    },
    {
        path: '/anti/create',
        component: require('./components/CreateAntiBar'),
        name: 'Create'
    },
    {
        path: '/anti/:id/edit',
        component: require('./components/CreateAntiBar'),
        name: 'Edit'
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
