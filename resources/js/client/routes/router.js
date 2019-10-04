import Vue from 'vue'
import Router from 'vue-router'
import Test from '../../components/client/Test'

import ProductsIndex from '../../components/client/Products/ProductsIndex'

import CategoriesIndex from '../../components/client/Categories/CategoriesIndex'
import Category from '../../components/client/Categories/Category'
import FinalCategory from '../../components/client/Categories/FinalCategory'
import Product from '../../components/client/Products/Product'
import Results from '../../components/client/Search/Products/Results'
import ShoppingCart from '../../components/client/Profile/ShoppingCart'
import Login from '../../components/client/Auth/Login'
import Register from '../../components/client/Auth/Register'
import Logout from '../../components/client/Auth/Logout'
import WishList from '../../components/client/Profile/WishList'
import AllOrders from '../../components/client/Orders/AllOrders'
import Order from '../../components/client/Orders/Order'
import Dashboard from "../../components/admin/includes/Dashboard";

Vue.use(Router)

let router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'test',
      component: Test
    },
    {
      path: '/products',
      name: 'products',
      component: ProductsIndex
    },
    {
      path: '/products/:id',
      name: 'product',
      component: Product
    },
    {
      path: '/search/products/',
      name: 'searchProduct',
      component: Results
    },
    {
      path: '/categories',
      name: 'categories',
      component: CategoriesIndex
    },
    {
      path: '/categories/:id',
      name: 'category',
      component: Category
    },
    {
      path: '/categories/:id/products',
      name: 'categoryProducts',
      component: FinalCategory
    },
    {
      path: '/cart',
      name: 'shoppingCart',
      component: ShoppingCart
    },
    {
      path: '/wishlist',
      name: 'wishList',
      component: WishList
    },
    // orders
    {
      path: '/orders',
      name: 'orders',
      component: AllOrders
    },
    {
      path: '/orders/:id',
      name: 'order',
      component: Order
    },
    //  auth
    {
      path: '/login',
      component: Login,
      name: 'login',
      meta: {
        requiresVisitor: true
      }
    },
    {
      path: '/register',
      component: Register,
      name: 'register',
      meta: {
        requiresVisitor: true
      }
    },
    {
      path: '/logout',
      component: Logout,
      name: 'logout'
    }
  ]
})

export default router
