/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require('@fortawesome/fontawesome-free/js/all.js');

window.Vue = require("vue");

import moment from "moment";
window.moment = moment;
moment.locale('fr');

import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user)

import swal from "sweetalert2";
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

Vue.component("pagination", require("laravel-vue-pagination"));
import VueRouter from "vue-router";
Vue.use(VueRouter);

let routes = [

    {
        path: "/home",
        redirect: "/dashboard"
    },
    {
        path: "/dashboard",
        name: 'dashboard',
        component: require("./views/Dashboard.vue").default,
        props: true,
    },
    {
        path: "/users",
        component: require("./views/Users.vue").default
    },
    {
        path: "/livres",
        component: require("./views/Books.vue").default
    },
    {
        path: "/categories",
        component: require("./views/Categories.vue").default
    },
    {
        path: "/auteurs",
        component: require("./views/Auteurs.vue").default
    },
    {
        path: "/adherents",
        component: require("./views/Members.vue").default
    },
    {
        path: "/gestion",
        component: require("./views/Emprunte.vue").default
    },

    {
        path: "/about",
        component: require("./views/About.vue").default
    },
    {
        path: "/logo",
        name: 'logo',
        component: require("./components/Login").default,
        props: true,
    },
    {
        path: "*",
        component: require("./views/NotFound.vue").default
    }

];

const router = new VueRouter({
        mode: "history",
        routes
    }),
    app = new Vue({
        el: "#app",
        router
    });
