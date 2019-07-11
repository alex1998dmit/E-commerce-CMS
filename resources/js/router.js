import Vue from 'vue';
import VueRouter from 'vue-router';

import DiscountsIndex from './components/discounts/DiscountsIndex.vue';
import DiscountsCreate from './components/discounts/DiscountsCreate.vue';

Vue.use(VueRouter);

const routes = [
    {path: '/',components: { DiscountsIndex: DiscountsIndex}},
    {path: '/admin/discounts/create', component: DiscountsCreate, name: 'createDiscount'},
];

const router = new VueRouter({ routes });

export default router;
