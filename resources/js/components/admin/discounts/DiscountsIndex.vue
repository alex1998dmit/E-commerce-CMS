<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Скидка категорий</h2>
                </div>
                <div class="col-6 text-right">
                    <router-link class="btn btn-primary" :to="{ name: 'dashboard' }">Главная</router-link>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <input type="text" class="form-control" placeholder="Поиск по скидкам ..." v-model="search_param">
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
                                <th scope="col">Пользователи</th>
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
                                    <b-button id="show-btn" variant="primary" @click="openEditModal(discount)">
                                        Редактировать
                                    </b-button>
                                </td>
                                <td>
                                    <b-button id="users" variant="success" @click="openUsersModal(discount)">
                                        Пользователи
                                    </b-button>
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
            <EditDiscount></EditDiscount>
            <UsersModal></UsersModal>
        </div>
    </div>
</template>

<script>
    // mixins
    import { crudDiscountMixin } from './mixins/crudDiscountMixin';

    // modals
    import ModalCreateDiscount from './includes/modals/CreateDiscount';
    import AboutDiscount from './includes/modals/AboutDiscount';
    import EditDiscount from './includes/modals/EditDiscount';
    import UsersModal from './includes/modals/UsersModal';

    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                search_param: "",
            }
        },
        components: {
            ModalCreateDiscount,
            AboutDiscount,
            EditDiscount,
            UsersModal,
        },
        mixins: [crudDiscountMixin],
        mounted() {
            this.$store.dispatch('getDiscounts');
            this.$store.dispatch('getUsers');
        },
        computed: {
            discounts() {
                if (this.search_param) {
                    return this.$store.getters.discounts.filter((discount) => discount.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()))
                }
                return this.$store.getters.discounts;
            }
        },
        methods: {
            openUsersModal(discount) {
                this.$store.commit("SET_SELECTED_DISCOUNT", discount);
                this.$bvModal.show("discount-users-modal");
            }
        },
    }
</script>
