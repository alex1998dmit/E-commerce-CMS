<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h2>Заказы</h2>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <br>
        <form @submit.prevent="filterOrders">
            <div class="row">
                <div class="col-md-5">
                    <div class="search-field">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control search-input" placeholder="Поиск по заказам..." v-model="search_param">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="price-filter">
                        <input type="number" class="form-control" placeholder="Мин стоимость" v-model="min_price">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="price-filter">
                        <input type="number" class="form-control" placeholder="Макс стоимость" v-model="max_price">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="id-filter">
                        <input type="text" class="form-control" placeholder="ID" v-model="order_id">
                    </div>
                </div>
                <div class="col-md-1">
                    <input type="submit" class="btn btn-search" name="" id="" value="Найти">
                </div>
            </div>
        </form>
        <div class="row" v-if="search_mode">
            <div class="col-md-12 text-left">
                <button class="filter-param" @click="searchModeOff"><i class="fa fa-times" aria-hidden="true"></i>   {{ search_param }} ({{ min_price }} - {{ max_price }})</button>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Товар</th>
                            <th>Покупатель(email)</th>
                            <th>Стоимость</th>
                            <th>Дата заказа</th>
                            <th colspan="5">Изменить статус</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, order_index) in orders" :key="order_index" :class="{ 'unchecked-order': order.is_checked === 0 }">
                            <td class="text-center">{{ order.id }}</td>
                            <td class="text-left">
                                <ul class="products-items">
                                    <li v-for="(item, index) in order.order_items" :key="index">
                                        {{ item.product.name }} ({{ item.amount}})
                                    </li>
                                </ul>
                            </td>
                            <td class="text-center">{{ order.user.name ?? 'Пользователь удален' }}</td>
                            <td class="text-center">{{ order.sum }}</td>
                            <td>{{ order.created_at }}</td>
                            <td class="text-center" colspan="5">
                                <select class="form-control status-select" name="status_id" id="status_id" v-model="order.status_id" @change="changeOrderStatus($event, order.id, order_index)">
                                    <option v-for="status in statuses" :key="status.id" v-bind:value="status.id">
                                        {{ status.name }}
                                    </option>
                                </select>
                            </td>
                            <td class="text-center">
                                <a
                                    class="view-icon"
                                    v-if="!order.is_checked"
                                    @click="checkNotification(order, order_index)">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a
                                    v-else
                                    class="view-icon"
                                    @click="uncheckedNotification(order.id, order_index)"
                                    >
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="trash-icon" @click="openAboutOrder(order)">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="trash-icon" @click="trashOrder(order.id, order_index)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="pagination">
                    <Pager
                        v-if="!search_mode"
                        routerName="Orders"
                        :frame=10
                        :pageCount="orders_page"
                        @updateItems="getOrders">
                    </Pager>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { crudOrdersMixin } from './mixins/crudOrdersMixin'
import Pager from '../helpers/Pager'

export default {
    mixins: [crudOrdersMixin],
    components: {
        Pager
    },
    data() {
        return {
            search_param: null,
            search_mode: false,
            min_price: null,
            max_price: null,
            order_id: null
        }
    },
    computed: {
        orders() {
            return this.$store.getters.orders
        },
        orders_page () {
            return this.$store.getters.ordersPageCount
        },
        statuses() {
            return this.$store.getters.orderStatuses
        }
    },
    mounted() {
        this.getOrders()
        // TODO заменить не на костыльное решение
        this.$router.push({ path: 'orders', query: { page: 1 }})
    },
    created() {
        // Echo.channel('orders')
        //     .listen('UpdateOrder', (e) => {
        //         this.$store.dispatch('getOrders', 1)
        //     })
    },
    methods: {
        getOrders (newPage = 1) {
            return new Promise((resolve, reject) => {
                this.$store.dispatch("getOrders", newPage)
            })
        },
        filterOrders () {
            const body = { search_param: this.search_param, min_price: this.min_price, max_price: this.max_price, order_id: this.order_id }
            Object.keys(body).forEach((key) => (body[key] == null) && delete body[key])
            this.$store.dispatch('filterOrders', body)
                .then(resp => this.search_mode = true)
                .catch(error => console.log(error))
        },
        searchModeOff () {
            this.search_mode = false
            this.getOrders()
            this.search_param = null
            this.min_price = null
            this.max_price = null
        }
    }
}
</script>

<style scoped>
    .products-items {
        list-style-type: none;
        padding: 0px;
        font-size: 13px;
    }
    .status-select {
        border-radius: 0px;
        border: 1px solid lightblue;
        width: 200px;
    }
    .wait-payment {
        border-color: grey;
    }
    .received-product {
        border-color: green;
    }
    .unchecked-order {
        background-color: #f8f9fa;
    }
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
    .search-field {
        padding-left: 3%;
        padding-bottom: 5%;
    }
    .search-input {
        padding-left: 10%;
    }
    .filter-param {
        margin-left: 1.5%;
        margin-bottom: 2%;
        color: #333;
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid grey;
        font-size: 0.9em;
    }
    .filter-param:hover {
        border-color: black;
    }

    .btn-search {
        border: 0px;
        border-bottom: 2px solid lightblue;
        border-radius: 0px;
    }
    .btn-search:hover {
        border-color: blue;
    }
</style>
