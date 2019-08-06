<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <h3>Заказ №{{ order.id }}({{ order.status.name }})</h3>
                </div>
                <div class="col text-right">
                    <b-button
                       variant="primary"
                        @click="$router.go(-1)">
                            Назад
                    </b-button>
                    <b-button
                        variant="info"
                        :to="{ name: 'orders' }">
                            Все заказы
                    </b-button>
                    <b-button
                        variant="warning"
                        :to="{ name: 'orders' }">
                           Редактировать
                    </b-button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Продукт</th>
                                <th scope="col">Категория продукта</th>
                                <th scope="col">Заказчик (Имя)</th>
                                <th scope="col">Заказчик (Email)</th>
                                <th scope="col">Кол-во товара</th>
                                <th scope="col">Цена за 1 ед</th>
                                <th scope="col">Сумма</th>
                                <th scope="col">Дата заказа</th>
                                <th scope="col">Дата изменения</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ order.id }}</td>
                                <td>{{ order.product.name }}</td>
                                <td>{{ order.product.category.name }}</td>
                                <td>{{ order.user.name }}</td>
                                <td>{{ order.user.email }}</td>
                                <td>{{ order.amount }}</td>
                                <td>{{ order.product.price }}</td>
                                <td>{{ order.sum }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>{{ order.updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>История заказа</h4>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">ID Заказа</th>
                                <th scope="col">Предыдущее состояние</th>
                                <th scope="col">Новое состояние</th>
                                <th scope="col">Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in order_history" :key="record.id">
                                <td>{{ record.id }}</td>
                                <td>{{ record.order_id }}</td>
                                <td>{{ record.prev_status.name }}</td>
                                <td>{{ record.cur_status.name }}</td>
                                <td>{{ record.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        order() {
            return this.$store.getters.selectedOrder;
        },
        order_history() {
            return this.$store.getters.orderHistory;
        }
    },
    mounted() {
        this.$store.dispatch('getOrder', this.$route.params.id);
        this.$store.dispatch('getOrderHistory', this.$route.params.id);
    }
}
</script>

