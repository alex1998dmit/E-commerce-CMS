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
        <div class="row">
            <div class="col-md-6">
                 <form class="form-inline my-2 my-lg-0" @submit.prevent="findOrder">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input class="form-control mr-sm-2" type="search" placeholder="Поиск продуктов ..." aria-label="Search" v-model="search_param">
                </form>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Товар</th>
                            <th>Покупатель(email)</th>
                            <th>Количество</th>
                            <th>Общая стоиомсть</th>
                            <th>Дата заказа</th>
                            <th>Просмотрено</th>
                            <th>Изменить статус</th>
                            <th>Подробнее</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id" :class="{ 'unchecked-order': !order.isChecked }">
                            <td class="text-center">{{ order.id }}</td>
                            <td class="text-center">{{ order.product.name }}</td>
                            <td class="text-center">{{ order.user.name }}</td>
                            <td class="text-center">{{ order.amount }}</td>
                            <td class="text-center">{{ order.sum }}</td>
                            <td>{{ order.created_at }}</td>
                            <td class="text-center">
                                <b-button
                                    v-if="!order.isChecked"
                                    size="sm"
                                    @click="checkNotification(order.id); updateOrder(order.id, { isChecked: true })"
                                    variant="light">
                                        Просмотрено
                                </b-button>
                                <p v-else>
                                    -
                                </p>
                            </td>
                            <td class="text-center">
                                <b-button
                                    size="sm"
                                    @click="changeOrderStatus(order)"
                                    variant="primary">
                                        Изменить статус
                                </b-button>
                            </td>
                            <td class="text-center">
                                <b-button
                                    size="sm"
                                    @click="openAboutOrder(order)"
                                    variant="warning">
                                        Подробнее
                                </b-button>
                            </td>
                            <td class="text-center">
                                <b-button
                                    size="sm"
                                    @click="openChangeOrder(order)"
                                    variant="success">
                                        Изменить
                                </b-button>
                            </td>
                            <td class="text-center">
                                <b-button
                                    size="sm"
                                    @click="trashOrder(order)"
                                    variant="danger">
                                        Удалить
                                </b-button>
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
    },
    mounted() {
        this.getOrders();
    },
    methods: {
        getOrders (newPage = 1) {
            console.log('updateOrders')
            return this.$store.dispatch("getOrders", newPage)
        },
        findOrder () {
            this.$store.context('SET_SEARCH_PARAM', this.search_param)
            this.$store.dispatch('getFindedOrders')
            this.$router.push({ name: "searchOrder" })
        }
    }
}
</script>

