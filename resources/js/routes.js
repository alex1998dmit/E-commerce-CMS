import DashboardAdmin from './components/admin/dashboard/DashboardIndex.vue';
import DiscountsIndex from './components/admin/discounts/DiscountsIndex.vue';
import DiscountsCreate from './components/admin/discounts/DiscountsCreate.vue';
import DiscountShow from './components/admin/discounts/DiscountShow.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';
import UsersIndex from './components/admin/users/UsersIndex.vue';
import CategoriesIndex from './components/admin/categories/CategoriesIndex.vue';
import Login from './components/admin/auth/Login';
import ProductsIndex from './components/admin/products/ProductsIndex.vue';

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

    // auth
    {
        path: '/login',
        component: Login,
        name:'login'
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
        path: '/',
        component: DashboardAdmin,
        name: 'dashboard'
    }
];
