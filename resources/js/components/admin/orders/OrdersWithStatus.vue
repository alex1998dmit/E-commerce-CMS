<template>
    <div>
        <div class="row">
            <div class="col-md-6 main-sign">
                <h2>Управление заказами</h2>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-orders">
                     Все заказы
                </button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="order-statuses-buttons">
                    Сортировать по статусу:
                    <b-button v-for="status in statuses" :key="status.id"
                        class="menu-order-statuses-buttons"
                        :variant="status.id == order_status.id ? 'info' : 'outline-info'"
                        :to="{ name: 'OrdersWithStatus', params: {statusId: status.id}}"
                    >
                        {{ status.name }}
                    </b-button>
                </div>
            </div>
        </div>
        <br>
        <div class="row" v-if="!search_mode">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Товар</th>
                            <th>Покупатель(email)</th>
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
                                <select class="form-control status-select" name="status_id" id="status_id" v-model="order.status_id" @change="changeOrderStatus($event, order.id, order_index); uploadOrders()">
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
        <!-- <div class="row" v-if="search_mode">
            <div class="col">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">По id</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">По названию продукта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">По категории продукта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="user-email-tab" data-toggle="tab" href="#useremail" role="tab" aria-controls="useremail" aria-selected="false">По email пользователя</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="user-name-tab" data-toggle="tab" href="#username" role="tab" aria-controls="username" aria-selected="false">По имени пользователя</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <TabSearch :orders="find_by_id"></TabSearch>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <TabSearch :orders="find_by_product_name"></TabSearch>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <TabSearch :orders="find_by_category_name"></TabSearch>
                    </div>
                    <div class="tab-pane fade"  id="useremail" role="tabpanel" aria-labelledby="user-email-tab">
                        <TabSearch :orders="find_by_useremail"></TabSearch>
                    </div>
                    <div class="tab-pane fade"  id="username" role="tabpanel" aria-labelledby="user-name-tab">
                        <TabSearch :orders="find_by_username"></TabSearch>
                    </div>
                </div>
            </div>
        </div> -->
        <Pager
            v-if="!search_mode"
            routerName="OrdersWithStatus"
            :frame=10
            :pageCount="orders_page"
            @updateItems="uploadOrders">
        </Pager>
    </div>
</template>

<script>
import { crudOrdersMixin } from './mixins/crudOrdersMixin';
import TabSearch from './includes/searchResults/TabSearch';
import Pager from '../helpers/Pager'

export default {
    mixins: [crudOrdersMixin],
    components: {
        Pager
    },
    data() {
        return {
            search_param : null,
            search_mode: false,
        }
    },
    computed: {
        order_status() {
            return this.$store.getters.selectedOrderStatus;
        },
        orders() {
            return this.$store.getters.orders
        },
        statuses() {
            return this.$store.getters.orderStatuses
        },
        orders_page () {
            return this.$store.getters.ordersPageCount
        }
    },
    mounted() {
        const status_id = this.$route.params.statusId
        this.updateOrderStatus(status_id);
        this.uploadOrders();
        this.uploadOrderStatuses();
    },
    methods: {
        // Загрузка выбранного статуса
        updateOrderStatus(status_id) {
            this.$store.dispatch("getOrderStatuses", status_id);
        },
        // Загрузка всех заказов
        uploadOrders(page = 1) {
            const statusId = this.$route.params.statusId
            this.$store.dispatch("getOrdersWithStatusId", { statusId, page });
        },
        uploadOrderStatuses() {
            this.$store.dispatch("getOrderStatuses")
        }
    },
    watch: {
        '$route.params.statusId'() {
            this.updateOrderStatus(this.$route.params.statusId)
            this.uploadOrders()
        }
    }
}
</script>
<style scoped>
    ul {
        list-style-type: none;
        padding: 0px;
        font-size: 13px;
    }
    .unchecked-order {
        background-color: #f8f9fa;
    }
    .btn-orders {
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightgrey;
    }
    .btn-orders:hover {
        border-color: black;
    }
</style>

