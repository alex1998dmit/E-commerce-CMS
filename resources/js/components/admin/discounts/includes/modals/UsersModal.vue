<template>
    <b-modal id="discount-users-modal" size="xl" hide-footer title="Пользователи скидочной категории">
        <div class="row">
            <div class="col">
                <h3>{{ discount.name }}</h3>
            </div>
            <div class="col text-right">
                <b-button variant="success" @click="openAddUserModal">Добавить пользователя</b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по пользователям">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID пользователя</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Изменить категорию</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <b-button
                                    variant="warning"
                                    @click="openChangeUserDiscount(user)"
                                    >
                                        Поменять категорию
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <AddUser></AddUser>
        <ChangeUserDiscount></ChangeUserDiscount>
    </b-modal>
</template>

<script>
// mixins
import { crudDiscountMixin } from '../../mixins/crudDiscountMixin';

// modals
import AddUser from './AddUser';
import ChangeUserDiscount from '../../../users/includes/modals/ChangeUserDiscount';

export default {
    mixins: [crudDiscountMixin],
    components: {
        AddUser,
        ChangeUserDiscount
    },
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        discount() {
            return this.$store.getters.selectedDiscount;
        },
        users() {
            const users = this.$store.getters.users.filter(user => user.discount_id === this.discount.id);
            if (this.search_param) {
                return users.filter((user) => user.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return users;
        }
    },
    methods: {
        openAddUserModal() {
            this.$bvModal.show("add-discount-to-user");
        },
        openChangeUserDiscount(user) {
            this.$store.commit('SET_SELECTED_USER', user);
            this.$bvModal.show("change-user-discount");
        }
    },
}
</script>

<style>

</style>
