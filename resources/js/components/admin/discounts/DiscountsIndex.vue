<template>
    <div class="col-md-12">
        <div class="card">
            <div class="row">
                <div class="col-md-12 text-center">
                    <br>
                    <h5>Скидки</h5>
                </div>
            </div>
            <div class="card-body" id="fromCartsContent">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <!-- <router-link :to="{name: 'createDiscount'}" class="btn btn-success">Создать новую скидку</router-link> -->
                        <router-link :to="{name: 'dashboard'}" class="btn btn-info">Главная</router-link>
                        <b-button id="show-btn" variant="outline-success" @click="$bvModal.show('create-discount-modal'); ">Создать новую скидку</b-button>
                    </div>
                </div>
                <br>
                <div class="category-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Скидка</th>
                            <th scope="col">Подробнее</th>
                            <th scope="col">Редактировать</th>
                            <th scope="col">Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="discount, index in discounts" :key="discount.id">
                                <td>{{ discount.id }}</td>
                                <td>{{ discount.name }}</td>
                                <td>{{ discount.discount }}</td>
                                <td>
                                    <router-link :to="{name: 'showDiscount', params: {id: discount.id}}" class="btn btn-xs btn-info">
                                        Подробнее
                                    </router-link>
                                </td>
                                <td>
                                    <!-- <b-button v-b-modal.modal-1 v-on:click="openModal(discount)">Открыть модалку</b-button> -->
                                    <b-button id="show-btn" variant="outline-info" @click="$bvModal.show('bv-modal-example'); openModal(discount, index)">Редактировать</b-button>
                                </td>
                                <td>
                                    <a href="#"
                                    class="btn btn-xs btn-danger"
                                    v-on:click="deleteEntry(discount.id, index)">
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <modalShow></modalShow>
        <modalCreate></modalCreate>
    </div>
</template>

<script>
    import modalShow from './includes/modalWindow.vue';
    import modalCreate from './includes/createDiscountModal.vue'
    import { mapGetters } from 'vuex';

    export default {
        components: {
            modalShow,
            modalCreate
        },
        mounted() {
            this.$store.dispatch('getDiscounts');
        },
        computed: {
            ...mapGetters(['discounts']),
            discount: {
                get() {
                    return this.$store.getters.updatingDiscount;
                },
                set(updating_discount) {
                    return this.$store.commit('SET_NEW_DISCOUNT_PARAM', updating_discount);
                }
            },
        },
        methods: {
            deleteEntry(id, index) {
                let app = this;
                if (confirm("Вы уверены что хотите удалить?")) {

                }
            },
            openModal(discount, index) {
                this.discount = { discount, index };
                console.log(this.discount);
            },
        },
    }
</script>
