/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from './components/App'
import Pizza from "./components/Sections/Pizza"
import Bonus from "./components/Sections/Bonus"
import About from "./components/Sections/About"
import Cart from "./components/Sections/Cart"
import Home from "./components/Sections/Home"
import PizzaCard from "./components/Sections/PizzaCard";
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import axios from 'axios';

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('pizza-component', require('./components/Blocks/PizzaItem').default);
Vue.component('like-component', require('./components/Elements/Like').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(Vuex);

const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/pizza',
            name: 'pizza',
            component: Pizza,
        },
        {
            path: '/bonus',
            name: 'bonus',
            component: Bonus,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart,
        },
        {
            path: '/pizza/:id',
            name: 'PizzaCard',
            component: PizzaCard,
            props: true
        }
    ],
});

const store = new Vuex.Store({
    state: {
        cart: {
            items: [],
            lastItem: {},
            count: 0,
            coupon: {
                value: 0,
                type: 0,
                code: '',
                user: 0,
            },
        },
        user_token: '',
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    created() {
        this.setToken();
    },
    methods: {
        setToken() {
            this.$nextTick(function () {
                this.$store.state.user_token = this.$refs.user_token !== undefined
                    ? document.getElementById('user_token').value
                    : false;
                if (this.$store.state.user_token) {
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.user_token;
                }
            })
        }
    },
    router,
    store
});
