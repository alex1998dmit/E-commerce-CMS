<template>
    <div class="row">
        <div class="col-md-12">
            <h3>Поиск</h3>
        </div>
        <div class="col-md-12">
            <form action="" @submit.prevent="find">
                <div class="search-field">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control search-input" placeholder="Глобальный поиск" v-model="search_param">
                </div>
            </form>
        </div>
        <!-- search param -->
        <div class="row" v-if="search_mode">
            <div class="col-md-12">
                <button class="filter-param" @click="searchModeOff"><i class="fa fa-times-circle-o" aria-hidden="true"></i>
                    {{ search_param }}
                </button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="search-results" v-if="search_mode">
                <!-- Tab links  -->
                <ul class="nav nav-tabs" id="seachResults" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="true">Заказы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="false">Продукция</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="contact" aria-selected="false">Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="contact" aria-selected="false">Категория</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="requisites-tab" data-toggle="tab" href="#requisites" role="tab" aria-controls="contact" aria-selected="false">Реквизиты</a>
                    </li>
                </ul>
                <!-- Tab body  -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <OrdersTable :orders="orders"></OrdersTable>
                    </div>
                    <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                        <ProductsTable :products="products"></ProductsTable>
                    </div>
                    <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <UsersTable :users="users"></UsersTable>
                    </div>
                    <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                        <CategoriesTable :categories="categories"></CategoriesTable>
                    </div>
                    <div class="tab-pane fade" id="requisites" role="tabpanel" aria-labelledby="requisites-tab">
                        <RequisitesTable :requisites="requisites"></RequisitesTable>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import OrdersTable from './includes/OrdersTable'
import ProductsTable from './includes/ProductsTable'
import CategoriesTable from './includes/CategoriesTable'
import RequisitesTable from './includes/RequisitesTable'
import UsersTable from './includes/UsersTable'

export default {
    data() {
        return {
            search_param: null,
            search_mode: false
        }
    },
    components: {
        OrdersTable, ProductsTable, RequisitesTable, UsersTable, CategoriesTable
    },
    computed: {
        orders () {
            return this.$store.getters.orders
        },
        products () {
            return this.$store.getters.products
        },
        requisites () {
            return this.$store.getters.requisites
        },
        users () {
            return this.$store.getters.users
        },
        categories () {
            return this.$store.getters.categories
        }
    },
    methods: {
        find () {
            this.$store.dispatch('findGlobally', { search_param: this.search_param })
            this.search_mode = true
        },
        searchModeOff () {
            this.search_mode = false
            this.search_param = null
        }
    }
}
</script>

<style>

</style>
<style scoped>
    .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .search-input {
        padding-left: 5%;
    }
    .search-field {
        padding-top: 1%;
    }
    .search-results {
        padding-top: 2%;
    }
    .filter-param {
        background-color: lightgrey;
        font-size: 0.9em;
        padding: 10px 20px 10px 20px;
        color: #333;
        border: 0px;
        margin-bottom: 3%;
        margin-top: 11%;
        margin-left: 15px;
    }
</style>
