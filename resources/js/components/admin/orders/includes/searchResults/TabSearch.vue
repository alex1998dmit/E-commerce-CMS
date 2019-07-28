<template>
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
</template>
<script>
import { crudOrdersMixin } from '../../mixins/crudOrdersMixin';

export default {
    mixins: [crudOrdersMixin],
    props: {
        orders: null,
    },
}
</script>

