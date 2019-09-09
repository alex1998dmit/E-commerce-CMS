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
                                <th scope="col">Заказчик (Email)</th>
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
                                <td class="text-center">
                                    <input type="number" class="form-control" v-model="item.amount" :disabled="updatingOrderItem.id !== item.id">
                                </td>
                                <td class="text-center">
                                    <!-- <a class="trash-icon" @click="openEditOrderProductsModule(item_index)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a> -->
                                     <a class="trash-icon" @click="editOrderItemAmount(item.id, item_index,item.amount)" v-if="buttons.amounts.edit">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="trash-icon" :disabled="updatingOrderItem.id === item.id" @click="updateOrderItem(item_index, item.id, item.amount)" v-if="buttons.amounts.save">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    </a>
                                    <a class="trash-icon" :disabled="updatingOrderItem.id === item.id" @click="resetAmountInput(item, item_index)" v-if="buttons.amounts.cancel">
                                       <i class="fa fa-times-circle" aria-hidden="true"></i>
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
                                <th scope="col">Предыдущее состояние</th>
                                <th scope="col">Новое состояние</th>
                                <th scope="col">Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in order.order_history" :key="record.id">
                                <td>{{ record.id }}</td>
                                <td>{{ record.prevStatusName }}</td>
                                <td>{{ record.newStatusName }}</td>
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
            item_index: 0,
            updatingOrderItem: {
                id: 0,
                old_amount: null,
                amount: null
            },
            buttons: {
                amounts: {
                    edit: true,
                    save: false,
                    cancel: false,
                }
            }
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
        },
        enableAmountButton (button) {
            this.buttons.amounts[button] = true
        },
        disableAmoutButton (button) {
            this.buttons.amounts[button] = false
        },
        disableAmountInput () {
            // enable and disable buttons
            this.disableAmoutButton('save')
            this.disableAmoutButton('cancel')
            this.enableAmountButton('edit')
        },
        resetUpdatingOrderItemParams() {
            this.updatingOrderItem.id = null
            this.updatingOrderItem.old_price = null
        },
        resetAmountInput (item, item_index) {
            this.disableAmoutButton()
            // update orderItem with old data
            this.order.order_items.splice(item_index, 1, {...item, amount: this.updatingOrderItem.old_amount })
            // reset updating Order params to default
            this.resetUpdatingOrderItemParams()
        },
        editOrderItemAmount (item_id, item_index, amount)
        {
            this.updatingOrderItem.old_amount = amount
            this.updatingOrderItem.id = item_id
            this.disableAmoutButton('edit')
            this.enableAmountButton('save')
            this.enableAmountButton('cancel')
        },
        updateOrderItem (item_index, item_id, amount) {
            const body = { amount: amount }
            console.log({
                order_index: this.index,
                item_index,
                item_id,
                body
            })
            this.$store.dispatch('updateOrderItem', {
                order_index: this.index,
                item_index,
                item_id,
                body
            })
            .then((item) => {
                this.disableAmountInput()
                this.resetUpdatingOrderItemParams()
                // this.resetAmountInput(item, item_index)

            })
            .catch(error => {
                console.log(error)
            })
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
    input {
        display: block;
        margin: 0 auto;
        width: 40%;
    }
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
