<template>
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
            <tr v-for="(order, order_index) in orders" :key="order_index">
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
</template>

<script>
export default {
    props: {
        orders: Array
    },
    computed: {
        statuses() {
            return this.$store.getters.orderStatuses
        }
    }
}
</script>
