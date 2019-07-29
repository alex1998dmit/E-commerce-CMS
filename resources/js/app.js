require('./bootstrap');

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


import VueRouter from 'vue-router';
import Vue from 'vue';
import Vuex from 'vuex';
import { routes } from './routes';
import StoreData from './store';
// svg-icons
// import { library } from '@fortawesome/fontawesome-svg-core';
// import { faCoffee } from '@fortawesome/free-solid-svg-icons'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import App from './components/admin/App.vue';

// Bootstrap-vue
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Bootstrap components
import { ModalPlugin } from 'bootstrap-vue';
import { ButtonPlugin } from 'bootstrap-vue';
import { FormCheckboxPlugin } from 'bootstrap-vue'

// Helpers
import { isAdmin } from './helpers/auth';

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

router.beforeEach((to, from, next) => {
    if(to.meta.requiresAuth) {
        const isLoggedIn = store.getters.isLoggedIn;
        if(!isLoggedIn) {
            next({ name:'login' })
        } else if (to.meta.adminAuth) {
            const user = JSON.parse(window.localStorage.getItem('user'));
            const roles = user.role;
            if (roles.filter(role => role.name == 'operator' || role.name == 'admin').length === 0) {
                next({ name: 'error' })
            } else {
                next();
            }
        } else {
            next();
        }
    } else if (to.meta.requiresVisitor) {
        if (store.getters.isLoggedIn) {
            next({
              name: 'categories'
            })
          } else {
            next()
        }
    } else {
        next()
    }
})


const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
