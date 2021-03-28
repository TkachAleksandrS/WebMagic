import Vue from 'vue';
import VueRouter from 'vue-router';

import '@/bootstrap';

import router from '@/router/index';
import store from '@/store';

import App from '@/App.vue';

import Loader from "./components/Loader";

Vue.component('Loader', Loader);

Vue.use(VueRouter);

new Vue({
    router,
    store,
    el: '#app',
    template: '<App/>',
    components: {
        App,
    },
});
