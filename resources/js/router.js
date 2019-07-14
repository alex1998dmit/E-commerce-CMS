import Vue from 'vue';
import VueRouter from 'vue-router';

import DiscountsIndex from './components/admin/discounts/DiscountsIndex.vue';
import DiscountsCreate from './components/admin/discounts/DiscountsCreate.vue';
import DiscountShow from './components/admin/discounts/DiscountShow.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';
import DashboardAdmin from './components/admin/dashboard/DashboardIndex.vue';

import UsersIndex from './components/admin/users/UsersIndex.vue';

import CategoriesIndex from './components/admin/categories/CategoriesIndex.vue';

Vue.use(VueRouter);

const routes = [
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
    {
        path: '/users',
        component: UsersIndex,
        name: 'users'
    },
    {
        path: '/categories',
        component: CategoriesIndex,
        name: 'categories'
    },
    {
        path: '/login',
        component: PersonalAccessTokens,
        name:'login'
    },
];

const router = new VueRouter({ routes });

export default router;
