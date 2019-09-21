import Dashboard from './components/admin/includes/Dashboard.vue';

import DiscountsIndex from './components/admin/discounts/DiscountsIndex.vue'
import DiscountAbout from './components/admin/discounts/DiscountAbout'

import RequisitesIndex from './components/admin/requisites/RequisitesIndex';
import TrashedRequisuites from './components/admin/requisites/TrashedRequisuites';

import UsersIndex from './components/admin/users/UsersIndex.vue'
import AboutUser from './components/admin/users/AboutUser.vue'
import TrashedUsers from './components/admin/users/TrashedUsers'

import CategoriesIndex from './components/admin/categories/CategoriesIndex.vue';
import CategoriesTree from './components/admin/categories/CategoriesTree.vue';
import CategoriesTrashed from './components/admin/categories/CategoriesTrashed.vue';

import ProductsIndex from './components/admin/products/ProductsIndex.vue';
import ProductEdit from './components/admin/products/ProductEdit.vue';
import ProductCreate from './components/admin/products/ProductCreate.vue';
import AboutProduct from './components/admin/products/AboutProduct.vue';

import OrdersIndex from './components/admin/orders/OrdersIndex';
import OrdersWithStatus from './components/admin/orders/OrdersWithStatus';
import OrderAbout from './components/admin/orders/OrderAbout';


import LoginUser from './components/admin/auth/Login';
import RegisterUser from './components/admin/auth/Register';
import LogoutUser from './components/admin/auth/Logout';

import Error from './components/admin/includes/Error';

import SearchIndex from './components/admin/search/SearchIndex'


export const routes = [
    // main
    // admin
    {
        path: '/admin',
        component: Dashboard,
        name: 'dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/admin/error',
        component: Error,
        name: 'error',
        meta: { requiresAuth: true }
    },

    // discounts
    {
        path: '/admin/discounts',
        name: 'discounts',
        component: DiscountsIndex,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/admin/discounts/:id',
        component: DiscountAbout,
        name:'discount',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // requisites
    {
        path: '/admin/requisites',
        component: RequisitesIndex,
        name: 'requisites',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/admin/trashedRequisuites',
        component: TrashedRequisuites,
        name: 'trashedRequisuites',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // categories
    {
        path: '/admin/categories',
        component: CategoriesIndex,
        name: 'categories',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/admin/treeCateories',
        component: CategoriesTree,
        name: 'CategoriesTree',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/admin/trashedCategories',
        component: CategoriesTrashed,
        name: 'CategoriesTrashed',
        meta: { requiresAuth: true, adminAuth: true }

    },

    // auth
    {
        path: '/admin/login',
        component: LoginUser,
        name:'login',
        meta: {
            requiresVisitor: true,
        }
    },
    {
        path: '/admin/register',
        component: RegisterUser,
        name: 'register',
        meta: {
            requiresVisitor: true,
        }
    },
    {
        path: '/admin/logout',
        component: LogoutUser,
        name: 'logout',
    },

    // users
    {
        path: '/admin/users',
        component: UsersIndex,
        name: 'users',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/admin/trashedUsers',
        component: TrashedUsers,
        name: 'trashedUsers',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/admin/users/:id',
        component: AboutUser,
        name: 'user',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // products
    {
        path: '/admin/products',
        component: ProductsIndex,
        name: 'products',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/admin/products/:id/edit',
        component: ProductEdit,
        name: 'editProduct',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/admin/products/create',
        component: ProductCreate,
        name: 'createProduct',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/admin/products/:id',
        component: AboutProduct,
        name: 'aboutProduct',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // orderWithStatus
    {
        path: '/admin/orders/:statusId',
        component: OrdersWithStatus,
        name: 'OrdersWithStatus',
        meta: { requiresAuth: true, adminAuth: true }

    },
    // orders
    {
        path: '/admin/orders/:id/about',
        component: OrderAbout,
        name: 'OrderAbout',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/admin/orders',
        component: OrdersIndex,
        name: 'Orders',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // search
    {
        path: '/admin/search',
        component: SearchIndex,
        name: 'search',
        meta: { requiresAuth: true, adminAuth: true }
    }
];
