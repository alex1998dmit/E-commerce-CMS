import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import categories from './modules/categories'
import discounts from './modules/discounts'
import info from './modules/info'
import notifications from './modules/notifications'
import orders from './modules/orders'
import orderStatuses from './modules/orderStatuses'
import products from './modules/products'
import requisites from './modules/requisites'
import users from './modules/users'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: { auth, categories, discounts, info, notifications, orders, orderStatuses, products, requisites, users },
})
