<template>
    <b-modal id="change-order-modal" size="xl" title="Изменить заказ" hide-footer>
        <div class="row">
            <div class="col">
                <form action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col">
                                    <p>Пользователь: {{ order.user.email }}   <b-button size="sm" variant="primary" @click="changeUser()">Изменить</b-button></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col">
                                    <p>Продукт: {{ order.product.name }}   <b-button size="sm" variant="primary" @click="changeProduct()">Изменить</b-button></p>
                                    <!-- <input type="text" class="form-control" v-model="order.product_id" disabled> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Количество</label>
                            <input type="text" class="form-control" v-model="order.amount">
                        </div>
                        <div class="col-md-6">
                            <label for="">Сумма</label>
                            <input type="text" class="form-control" v-model="order.sum">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <b-button variant="success" @click="updateOrder(order.id, order); closeModal()">Сохранить</b-button>
                            <b-button variant="danger" @click="closeModal()">Отмена</b-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <FindProduct></FindProduct>
        <FindUser></FindUser>
    </b-modal>
</template>
<script>
import { crudOrdersMixin } from '../../mixins/crudOrdersMixin';
import FindProduct from './FindProduct';
import FindUser from './FindUser';

export default {
    mixins: [ crudOrdersMixin ],
    components: {
        FindProduct, FindUser
    },
    computed: {
        order: {
            get() {
                return this.$store.getters.selectedOrder;
            },
            set(val) {

            }
        }
    },
    methods: {

        closeModal() {
            this.$bvModal.hide("change-order-modal");
        }
    },
}
</script>

