<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col">
                    <h3>Заказ №{{ order.id }}({{ order.status.name }})</h3>
                </div>
                <div class="col text-right">
                    <button
                        class="btn btn-navigate"
                        @click="$router.go(-1)">
                            Назад
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <h5>Общая информация</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Заказчик (Имя)</th>
                                <!-- <th scope="col">Категория продукта</th> -->
                                <th scope="col">Заказчик (Email)</th>
                                <!-- <th scope="col">Кол-во товара</th> -->
                                <!-- <th scope="col">Цена за 1 ед</th> -->
                                <th scope="col">Сумма</th>
                                <th scope="col">Дата заказа</th>
                                <th scope="col">Дата изменения</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ order.id }}</td>
                                <td>{{ order.user.name }}</td>
                                <td>{{ order.user.email }}</td>
                                <td>{{ order.sum }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>{{ order.updated_at }}</td>
                                <td class="text-center">
                                    <a class="edit-icon" @click="openEditOrderModule">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="trash-icon">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br>
                    <h5>Товары в заказе</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID товара</th>
                                <th scope="col" class="text-center">Название товара</th>
                                <th scope="col" class="text-center">Категория товара</th>
                                <th scope="col" class="text-center">Количество товара</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, item_index) in order.order_items" :key="item.id">
                                <td class="text-center">{{ item.product.id }}</td>
                                <td class="text-center">{{ item.product.name }}</td>
                                <td class="text-center">{{ item.product.category.name }}</td>
                                <td class="text-center">{{ item.amount }}</td>
                                <td class="text-center">
                                    <a class="trash-icon" @click="openEditOrderProductsModule(item_index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="trash-icon" @click="removeItem(item.id, item_index)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <a class="add-product-to-order" @click="openAddOrderItemModule">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                          Товар к заказу
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <br>
                    <h5>История заказа</h5>
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
        <AddOrderItem></AddOrderItem>
        <ChangeOrder :order_index="index"></ChangeOrder>
        <ChangeOrderProduct :order_index="index" :id="id" :item_index="item_index"></ChangeOrderProduct>
    </div>
</template>

<script>
import ChangeOrderProduct from './includes/modals/ChangeOrderProduct'
import ChangeOrder from './includes/modals/ChangeOrder'
import AddOrderItem from './includes/modals/AddOrderItem'

export default {
    data () {
        return {
            index: null,
            id: null,
            item_index: 0
        }
    },
    components: {
        ChangeOrderProduct, ChangeOrder, AddOrderItem
    },
    computed: {
        orders () {
            return this.$store.getters.orders
        },
        order() {
            return this.$store.getters.selectedOrder;
        },
        order_history() {
            return this.$store.getters.orderHistory;
        }
    },
    mounted() {
        this.index = this.orders.map((order) => order.id).indexOf(this.$route.params.id)
        this.id = this.$route.params.id
        this.updateInfoAboutOrder()
    },
    methods: {
        updateInfoAboutOrder () {
            this.$store.dispatch('getOrder', this.id)
            this.$store.dispatch('getOrderHistory', this.id)
        },
        openEditOrderProductsModule(item_index) {
            this.item_index = item_index
            this.$bvModal.show('change-order-product')
        },
        openEditOrderModule () {
            this.$bvModal.show('change-order-modal')
        },
        openAddOrderItemModule () {
            this.$bvModal.show('add-order-item-module')
        },
        removeItem (orderItemId, itemIndex) {
            // removeOrderItem (context, { orderItemId, itemIndex }) {
            if (confirm("Вы уверены что хотите удалить товар из заказа ?")) {
                this.$store.dispatch('removeOrderItem', { orderItemId, itemIndex })
                    .then(resp => {
                        this.updateInfoAboutOrder()
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    },
    watch: {
        '$route'() {
            this.$store.dispatch('getOrder', this.$route.params.id);
            this.$store.dispatch('getOrderHistory', this.$route.params.id);
        },
    }
}
</script>
<style scoped>
    .add-product-to-order {
        padding: 10px;
        background: lightgrey;
        font-size: 0.8em;
    }
    .btn-navigate {
        border-bottom: 2px solid lightgrey;
        border-radius: 0px;
    }
    .btn-navigate:hover {
        border-bottom: 2px solid black;
    }
        /* .trash-icon {
            color: red;
        } */
</style>
