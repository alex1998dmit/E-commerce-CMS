<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Скидка категорий</h2>
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-primary" :to="{ name: 'dashboard' }">Главная</router-link>
                    <!-- <router-link class="btn btn-primary">Главная</router-link> -->
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <input type="text" class="form-control" placeholder="Поиск по скидкам ...">
                </div>
                <div class="col-6 text-right">
                    <b-button class="btn btn-success" @click="openCreateModal()">+ скидку</b-button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
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
                            <tr v-for="(discount, index) in discounts" :key="discount.id">
                                <td>{{ discount.id }}</td>
                                <td>{{ discount.name }}</td>
                                <td>{{ discount.discount }}</td>
                                <td>
                                    <b-button variant="info" @click="openAboutModal(discount, index)">
                                        Подробнее
                                    </b-button>
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
            <ModalCreateDiscount></ModalCreateDiscount>
            <AboutDiscount></AboutDiscount>
        </div>
    </div>
</template>

<script>
    // mixins
    import { crudDiscountMixin } from './mixins/crudDiscountMixin';

    // modals
    import ModalCreateDiscount from './includes/modals/CreateDiscount';
    import AboutDiscount from './includes/modals/AboutDiscount';

    import { mapGetters } from 'vuex';

    export default {
        components: {
            ModalCreateDiscount,
            AboutDiscount
        },
        mixins: [crudDiscountMixin],
        mounted() {
            this.$store.dispatch('getDiscounts');
        },
        computed: {
            ...mapGetters(['discounts']),
        },
        methods: {

        },
    }
</script>
