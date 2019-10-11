<template>
    <div>
        <nav id="sidebar" v-if="isLoggedIn">
            <div class="sidebar-header">
                <h3>Админ панель</h3>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <router-link :to="{ name: 'search' }">Поиск</router-link>
                </li>
                <li class="active statuses">
                    <a href="#ordersMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Заказы
                        <div class="unchecked-orders-amount" v-if="unchecked_orders_amount > 0">
                            {{ unchecked_orders_amount }}
                        </div>
                    </a>
                    <ul class="collapse list-unstyled" id="ordersMenu">
                        <li>
                             <router-link :to="{ name: 'Orders'}">Все заказы</router-link>
                        </li>
                        <li v-for="status in order_statuses" :key="status.id">
                             <router-link :to="{ name: 'OrdersWithStatus', params: {statusId: status.id}}">{{ status.name }}
                                 <div class="orders-amount">
                                    {{ status.orders_num }}
                                 </div>
                                 <div class="unchecked-orders-amount" v-if="status.unchecked_orders_num > 0">
                                    {{ status.unchecked_orders_num }}
                                 </div>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Категории скидок</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <router-link :to="{ name: 'discounts' }">Все скидки</router-link>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#requisites" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Реквизиты</a>
                    <ul class="collapse list-unstyled" id="requisites">
                        <li>
                            <router-link :to="{ name: 'requisites' }">Активные реквизиты</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'trashedRequisuites' }">Удаленные реквизиты</router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link :to="{ name: 'users' }">Пользователи</router-link>
                </li>
                <li class="active">
                    <a href="#productsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Товары</a>
                    <ul class="collapse list-unstyled" id="productsMenu">
                        <li>
                            <router-link :to="{ name: 'createProduct' }">Добавить продукт</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'products' }">Все товары</router-link>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#categoriesMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Категории</a>
                    <ul class="collapse list-unstyled" id="categoriesMenu">
                        <li>
                            <router-link :to="{ name: 'categories' }">Таблица категорий</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'CategoriesTree' }">Дерево категорий</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'CategoriesTrashed' }">Удаленные категории</router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
export default {
    computed: {
        order_statuses() {
            return this.$store.getters.orderStatuses;
        },
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },
        unchecked_orders_amount () {
            return this.order_statuses.reduce((unchecked_orders_amount, order_status) => {
                unchecked_orders_amount = unchecked_orders_amount + order_status.unchecked_orders_num
                return unchecked_orders_amount
            }, 0)
        }
    },
    mounted() {
        if (this.isLoggedIn) {
            this.$store.dispatch('getOrderStatuses');
        }
    }
}
</script>

<style scoped>
    #sidebar {
        /* color: white; */
        height: 100%;
    }

    #sidebar ul li a {
        color: white;
    }
    #sidebar ul li a:hover {
        background-color: lightblue;
    }
    .orders-amount {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50px;
        background-color: lightgrey;
        color: black;
        padding-left: 7px;
        font-size: 0.8em;
        padding-top: 1px;
    }
    .unchecked-orders-amount {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50px;
        background-color: red;
        padding-left: 7px;
        font-size: 0.8em;
        padding-top: 1px;
    }


</style>
