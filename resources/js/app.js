import Vue from 'vue';
import VueRouter from 'vue-router';

import './bootstrap';

import router from './router/index';

import App from './App.vue';

Vue.use(VueRouter);

new Vue({
    router,
    el: '#app',
    template: '<App/>',
    components: {
        App,
    },
});
