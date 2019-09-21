import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VueFlashMessage from 'vue-flash-message'

import App from './client/App.vue'
import router from './client/routes/router'
import StoreData from './client/store/index'

Vue.config.productionTip = false

/* eslint-disable no-new */
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueFlashMessage)
require('vue-flash-message/dist/vue-flash-message.min.css')

const store = new Vuex.Store(StoreData)

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const isLoggedIn = store.getters.isLoggedIn
    if (!isLoggedIn) {
      next({ name: 'login' })
    } else {
      next()
    }
  } else if (to.meta.requiresVisitor) {
    if (!store.getters.isLoggedIn) {
      next()
    } else {
      next({
        name: 'test'
      })
    }
  } else {
    next()
  }
})

new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
