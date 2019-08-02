<template>
    <div>
        <nav id="sidebar" v-if="isLoggedIn">
            <div class="sidebar-header">
                <h3>Админ панель</h3>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Категория скидок</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <router-link :to="{ name: 'discounts' }">Все скидки</router-link>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#productsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Реквизиты</a>
                    <ul class="collapse list-unstyled" id="productsMenu">
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
                <li class="active">
                    <a href="#ordersMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Заказы</a>
                    <ul class="collapse list-unstyled" id="ordersMenu">
                        <li>
                             <router-link :to="{ name: 'Orders'}">Все заказы</router-link>
                        </li>
                        <li v-for="status in order_statuses" :key="status.id">
                             <router-link :to="{ name: 'OrdersWithStatus', params: {statusId: status.id}}">{{ status.name }}</router-link>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
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
        }
    },
    mounted() {
        this.$store.dispatch('getOrderStatuses');
    }
}
</script>

<style>
    #sidebar {
        color: white;
        height: 100%;
    }

    #sidebar ul li a {
        color: white;
    }
</style>
