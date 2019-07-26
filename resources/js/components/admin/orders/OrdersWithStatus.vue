<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h2>Статусы заказа</h2>
                <h5>{{ order_status.name }}</h5>
            </div>
            <div class="col-md-6 text-right">
                <b-button
                    variant="info">
                        Все заказы
                </b-button>
                <b-button
                    variant="primary">
                        Меню
                </b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <b-button v-for="status in order_statuses" :key="status.id"
                        class="menu-order-statuses-buttons"
                        variant="outline-info"
                        :to="{ name: 'OrdersWithStatus', params: {statusId: status.id}}"
                    >
                        {{ status.name }}
                    </b-button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Поиск по заказам...">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Продукт</th>
                        <th scope="col">Заказчик</th>
                        <th scope="col">Кол-во товара</th>
                        <th scope="col">Цена за 1 ед</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">Новый статус</th>
                        <th scope="col">Подробнее</th>
                        <th scope="col">Редактировать</th>
                        <th scope="col">Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td>{{ order.id }}</td>
                            <td>{{ order.product.name }}</td>
                            <td>{{ order.user.name }}</td>
                            <td>{{ order.amount }}</td>
                            <td>{{ order.product.price }}</td>
                            <td>{{ order.sum }}</td>
                            <td>
                                <b-button
                                    @click="changeOrderStatus(order)"
                                    variant="primary">Изменить статус</b-button>
                            </td>
                            <td>
                                <b-button
                                    @click="openAboutOrder(order)"
                                    variant="warning">
                                        Подробнее
                                </b-button>
                            </td>
                            <td>
                                <b-button
                                    @click="openChangeOrder(order)"
                                    variant="success">
                                        Редактировать
                                </b-button>
                            </td>
                            <td>
                                <b-button
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
        <AboutOrder></AboutOrder>
        <ChangeOrder></ChangeOrder>
    </div>
</template>

<script>
import { crudOrdersMixin } from './mixins/crudOrdersMixin';
import AboutOrder from './includes/modals/AboutOrder';
import ChangeOrder from './includes/modals/ChangeOrder';

export default {
    mixins: [crudOrdersMixin],
    components: {
        AboutOrder, ChangeOrder
    },
    computed: {
        order_status() {
            return this.$store.getters.selectedOrderStatus;
        },
        orders() {
            const orders = this.$store.getters.orders;
            return orders.filter(order => order.status_id === this.order_status.id);
        },
        order_statuses() {
            return this.$store.getters.orderStatuses;
        }
    },
    mounted() {
        const status_id = this.$route.params.statusId;
        this.updateOrderStatus(status_id);
        this.uploadOrders();
        this.uploadOrderStatuses();
    },
    methods: {
        // Загрузка выбранного статуса
        updateOrderStatus(status_id) {
            this.$store.dispatch("getSelectedOrderStatus", status_id);
        },
        // Загрузка всех заказов
        uploadOrders() {
            this.$store.dispatch("getOrders");
        },
        uploadOrderStatuses() {
            this.$store.dispatch("getOrderStatuses")
        }
    },
    watch: {
        '$route'() {
            this.updateOrderStatus(this.$route.params.statusId);
            this.uploadOrders();
        }
    }
}
</script>


