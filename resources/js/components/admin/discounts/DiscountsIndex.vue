<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-6">
                    <h2>Категории скидок</h2>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-create" @click="openCreateModal()">Добавить категорию</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 text-left">
                    <!-- <input type="text" class="form-control" placeholder="Поиск по скидкам ..." v-model="search_param"> -->
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Название</th>
                                <th class="text-center" scope="col">Скидка</th>
                                <th class="text-center" scope="col" colspan="1"></th>
                                <th class="text-center" scope="col" colspan="1"></th>
                                <th class="text-center" scope="col" colspan="1"></th>
                                <th class="text-center" scope="col" colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(discount, index) in discounts" :key="discount.id">
                                <td class="text-center">{{ discount.id }}</td>
                                <td class="text-center">{{ discount.name }}</td>
                                <td class="text-center">{{ discount.discount }}</td>
                                <td>
                                    <a
                                        class="change-discount"
                                        @click="changeUserDiscount(discount)">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center" colspan="1">
                                    <a
                                        class="view-icon"
                                        @click="openAboutModal(discount, index)">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center" colspan="1">
                                    <a class="edit-icon" @click="openEditModal(discount)">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="text-center trash-icon" colspan="1">
                                    <a
                                        class="trash-icon"
                                        @click="trashDiscount(discount.id, index)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <ChangeUserDiscount></ChangeUserDiscount>
            <ModalCreateDiscount></ModalCreateDiscount>
            <AboutDiscount></AboutDiscount>
            <EditDiscount></EditDiscount>
            <UsersModal></UsersModal>
            <DeleteDiscount></DeleteDiscount>
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
    import DeleteDiscount from './includes/modals/DeleteDiscount';
    import ChangeUserDiscount from './includes/modals/ChangeUserDiscount'

    import { mapGetters } from 'vuex';

    export default {
        components: {
            ModalCreateDiscount,
            AboutDiscount,
            EditDiscount,
            UsersModal,
            DeleteDiscount,
            ChangeUserDiscount
        },
        mixins: [crudDiscountMixin],
        mounted() {
            this.$store.dispatch('getDiscounts');
        },
        computed: {
            discounts() {
                return this.$store.getters.discounts;
            }
        },
        methods: {
            openUsersModal(discount) {
                this.$store.commit("SET_SELECTED_DISCOUNT", discount);
                this.$bvModal.show("discount-users-modal");
            },
            openDeleteModal(discount) {
                this.$store.commit("SET_SELECTED_DISCOUNT", discount);
                this.$bvModal.show("trash-discount-category");
            },
                    openCreateModal() {
            this.$bvModal.show("create-discount-modal");
            },
            openEditModal(discount) {
                this.$store.commit("SET_SELECTED_DISCOUNT", discount);
                this.$bvModal.show("create-discount");
            },
            openAboutModal(discount, index) {
                this.$store.commit("SET_SELECTED_DISCOUNT", discount);
                this.$bvModal.show("about-discount-modal");
            },
            trashDiscount (discount_id, index) {
                if (confirm("Вы уверены что хотите удалить категорию скидок ?")) {
                    this.$store.dispatch('trashDiscount', { discount_id, index });
                }
            },
            changeUserDiscount (discount) {
                this.$store.commit('SET_SELECTED_DISCOUNT', discount)
                this.$bvModal.show('change-user-discount')
            }
        },
    }
</script>
<style scoped>
.btn-create {
    border: 0px;
    border-radius: 0px;
    border-bottom: 2px solid lightgrey;
}
.btn-create:hover {
    border-color: black;
}
.trash-icon {
    color: red;
}
</style>
