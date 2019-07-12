import Vue from 'vue';
import VueRouter from 'vue-router';

import DiscountsIndex from './components/admin/discounts/DiscountsIndex.vue';
import DiscountsCreate from './components/admin/discounts/DiscountsCreate.vue';
import DiscountShow from './components/admin/discounts/DiscountShow.vue';

Vue.use(VueRouter);

const routes = [
    {path: '/',components: { DiscountsIndex: DiscountsIndex}},
    {path: '/admin/discounts/', component: DiscountsIndex},
    {path: '/admin/discounts/create', component: DiscountsCreate, name: 'createDiscount'},
    {path: '/admin/discounts/show/:id', component: DiscountShow, name:'showDiscount'}
];

const router = new VueRouter({ routes });

export default router;
