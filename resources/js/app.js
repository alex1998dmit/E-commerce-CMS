require('./bootstrap');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


import VueRouter from 'vue-router';
import Vue from 'vue';
import Vuex from 'vuex';
import { routes } from './routes';
import StoreData from './store';

import App from './components/admin/App.vue';

// Bootstrap-vue
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Bootstrap components
import { ModalPlugin } from 'bootstrap-vue';
import { ButtonPlugin } from 'bootstrap-vue';
import { FormCheckboxPlugin } from 'bootstrap-vue'

Vue.use(ModalPlugin);
Vue.use(ButtonPlugin);
Vue.use(FormCheckboxPlugin)

Vue.use(VueRouter);
Vue.use(Vuex)

const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    mode: 'history',
    routes,
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
