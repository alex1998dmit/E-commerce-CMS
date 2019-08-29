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
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Товар</th>
                            <th>Покупатель(email)</th>
                            <!-- <th>Количество</th> -->
                            <th>Cтоиомость</th>
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
                            <td class="text-center">{{ order.user.name }}</td>
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
                                    @click="checkNotification(order.id, order_index)">
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
                                <a class="trash-icon" @click="openAboutOrder(order.id)">
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
                        routerName="Orders"
                        :frame=8
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
            checkedOrders: [],
            search_param: null,
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
        this.getOrders();
    },
    methods: {
        getOrders (newPage = 1) {
            return this.$store.dispatch("getOrders", newPage)
        },
        findOrder () {
            this.$store.context('SET_SEARCH_PARAM', this.search_param)
            this.$store.dispatch('getFindedOrders')
            this.$router.push({ name: "searchOrder" })
        },
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
</style>
