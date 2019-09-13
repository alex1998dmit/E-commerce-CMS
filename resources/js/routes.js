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
        path: '/',
        component: Dashboard,
        name: 'dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/error',
        component: Error,
        name: 'error',
        meta: { requiresAuth: true }
    },

    // discounts
    {
        path: '/discounts',
        name: 'discounts',
        component: DiscountsIndex,
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/discounts/:id',
        component: DiscountAbout,
        name:'discount',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // requisites
    {
        path: '/requisites',
        component: RequisitesIndex,
        name: 'requisites',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/trashedRequisuites',
        component: TrashedRequisuites,
        name: 'trashedRequisuites',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // categories
    {
        path: '/categories',
        component: CategoriesIndex,
        name: 'categories',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/treeCateories',
        component: CategoriesTree,
        name: 'CategoriesTree',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/trashedCategories',
        component: CategoriesTrashed,
        name: 'CategoriesTrashed',
        meta: { requiresAuth: true, adminAuth: true }

    },

    // auth
    {
        path: '/login',
        component: LoginUser,
        name:'login',
        meta: {
            requiresVisitor: true,
        }
    },
    {
        path: '/register',
        component: RegisterUser,
        name: 'register',
        meta: {
            requiresVisitor: true,
        }
    },
    {
        path: '/logout',
        component: LogoutUser,
        name: 'logout',
    },

    // users
    {
        path: '/users',
        component: UsersIndex,
        name: 'users',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/trashedUsers',
        component: TrashedUsers,
        name: 'trashedUsers',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/users/:id',
        component: AboutUser,
        name: 'user',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // products
    {
        path: '/products',
        component: ProductsIndex,
        name: 'products',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/products/:id/edit',
        component: ProductEdit,
        name: 'editProduct',
        meta: { requiresAuth: true, adminAuth: true }

    },
    {
        path: '/products/create',
        component: ProductCreate,
        name: 'createProduct',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/products/:id',
        component: AboutProduct,
        name: 'aboutProduct',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // orderWithStatus
    {
        path: '/orders/:statusId',
        component: OrdersWithStatus,
        name: 'OrdersWithStatus',
        meta: { requiresAuth: true, adminAuth: true }

    },
    // orders
    {
        path: '/orders/:id/about',
        component: OrderAbout,
        name: 'OrderAbout',
        meta: { requiresAuth: true, adminAuth: true }
    },
    {
        path: '/orders',
        component: OrdersIndex,
        name: 'Orders',
        meta: { requiresAuth: true, adminAuth: true }
    },

    // search
    {
        path: '/search',
        component: SearchIndex,
        name: 'search',
        meta: { requiresAuth: true, adminAuth: true }
    }
];
