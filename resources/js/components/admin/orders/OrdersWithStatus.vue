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
                        :variant="status.id == order_status.id ? 'info' : 'outline-info'"
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
                <input type="text" class="form-control" placeholder="Поиск по заказам..." v-model="search_param">
            </div>
        </div>
        <br>
        <div class="row" v-if="!search_mode">
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
                                    variant="primary">Изменить статус
                                </b-button>
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
        <div class="row" v-if="search_mode">
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
        </div>
        <AboutOrder></AboutOrder>
        <ChangeOrder></ChangeOrder>
        <ChangeStatus></ChangeStatus>
    </div>
</template>

<script>
import { crudOrdersMixin } from './mixins/crudOrdersMixin';
import AboutOrder from './includes/modals/AboutOrder';
import ChangeOrder from './includes/modals/ChangeOrder';
import ChangeStatus from './includes/modals/ChangeStatus';
import TabSearch from './includes/searchResults/TabSearch';


export default {
    mixins: [crudOrdersMixin],
    data() {
        return {
            search_param : null,
            search_mode: false,
            find_by_id: [],
            find_by_product_name: [],
            find_by_category_name: [],
            find_by_useremail: [],

        }
    },
    components: {
        AboutOrder, ChangeOrder, ChangeStatus, TabSearch
    },
    computed: {
        order_status() {
            return this.$store.getters.selectedOrderStatus;
        },
        orders() {
            return this.$store.getters.orders.filter((order) => order.status_id === this.order_status.id);
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
        },
        setButtonType(status_id) {
            if (this.order_status.id = status_id) {
                return "success";
            }
            return "danger";
        }
    },
    watch: {
        '$route'() {
            this.updateOrderStatus(this.$route.params.statusId);
            this.uploadOrders();
        },
        search_param(search_param) {
             if (search_param) {
                this.search_mode = true;
                this.find_by_id = this.orders.filter((order) => order.id === search_param);
                this.find_by_product_name = this.orders.filter(order => order.product.name.toLowerCase().includes(this.search_param.toLowerCase()));
                this.find_by_category_name = this.orders.filter(order => order.product.category.name.toLowerCase().includes(this.search_param.toLowerCase()));
                this.find_by_username = this.orders.filter(order => order.user.name.toLowerCase().includes(this.search_param.toLowerCase()));
                this.find_by_useremail = this.orders.filter(order => order.user.email.toLowerCase().includes(this.search_param.toLowerCase()));
            } else {
                this.search_mode = false;
            }
        }
    }
}
</script>


