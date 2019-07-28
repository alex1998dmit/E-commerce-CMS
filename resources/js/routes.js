import DashboardAdmin from './components/admin/dashboard/DashboardIndex.vue';

import DiscountsIndex from './components/admin/discounts/DiscountsIndex.vue';
import DiscountsCreate from './components/admin/discounts/DiscountsCreate.vue';
import DiscountShow from './components/admin/discounts/DiscountShow.vue';

import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

import UsersIndex from './components/admin/users/UsersIndex.vue';

import CategoriesIndex from './components/admin/categories/CategoriesIndex.vue';
import CategoriesTree from './components/admin/categories/CategoriesTree.vue';
import CategoriesTrashed from './components/admin/categories/CategoriesTrashed.vue';

import ProductsIndex from './components/admin/products/ProductsIndex.vue';
import ProductEdit from './components/admin/products/ProductEdit.vue';
import ProductCreate from './components/admin/products/ProductCreate.vue';

import OrdersIndex from './components/admin/orders/OrdersIndex';
import OrdersWithStatus from './components/admin/orders/OrdersWithStatus';
import LoginUser from './components/admin/auth/Login';
import RegisterUser from './components/admin/auth/Register';


export const routes = [
    // discounts
    {
        path: '/discounts',
        name: 'discounts',
        component: DiscountsIndex
    },
    {
        path: '/discounts/:id',
        component: DiscountShow,
        name:'showDiscount'
    },

    // categories
    {
        path: '/categories',
        component: CategoriesIndex,
        name: 'categories'
    },
    {
        path: '/treeCateories',
        component: CategoriesTree,
        name: 'CategoriesTree'
    },
    {
        path: '/trashedCategories',
        component: CategoriesTrashed,
        name: 'CategoriesTrashed'
    },

    // auth
    {
        path: '/login',
        component: LoginUser,
        name:'login'
    },
    {
        path: '/register',
        component: RegisterUser,
        name: 'register'
    },

    // users
    {
        path: '/users',
        component: UsersIndex,
        name: 'users'
    },

    // products
    {
        path: '/products',
        component: ProductsIndex,
        name: 'products'
    },
    {
        path: '/products/edit/:id',
        component: ProductEdit,
        name: 'editProduct'
    },
    {
        path: '/products/create',
        component: ProductCreate,
        name: 'createProduct'
    },

    // admin
    {
        path: '/',
        component: DashboardAdmin,
        name: 'dashboard'
    },

    // orderWithStatus
    {
        path: '/orders/:statusId',
        component: OrdersWithStatus,
        name: 'OrdersWithStatus'
    },
    // orders
    {
        path: '/orders',
        component: OrdersIndex,
        name: 'Orders'
    }
];
