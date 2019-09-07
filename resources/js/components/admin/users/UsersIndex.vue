<template>
    <div>
        <div class="row">
            <div class="col-6 text-left">
                <h2>Пользователи</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 text-left">
                <div class="form-group mx-sm-3">
                    <form action="" @submit.prevent="search(); searchModeOn()">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input class="form-control search-input" v-model="search_param" id="user_param" name="param" type="text" placeholder="Введите поиск или имя пользователя ...">
                    </form>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <router-link :to="{ name: 'trashedUsers' }" class="btn btn-trashed">Удаленные пользователи</router-link>
            </div>
            </div>
            <br>
            <div class="row" v-if="search_mode">
                <div class="col-md-12">
                    <button class="search-param-button" @click="searchModeOff(); setSearchParamNull()">
                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                        {{ search_param }}
                    </button>
                </div>
            </div>
            <div class="category-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">emal</th>
                            <th scope="col">Категория пользователя</th>
                            <th scope="col">Дата регистрации</th>
                            <th scope="col">Дата подтверждения аккаунта</th>
                            <th scope="col">Кол-во заказов</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody v-if="!search_mode">
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.discount.name }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.email_verified_at }}</td>
                            <td>{{ user.order.length }}</td>
                            <td>
                                <a class="change-user-status" @click="changeUserDiscount(user)">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="about-icon" @click="openAboutUser(user.id)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center trash-td">
                                <a class="trash-icon" @click="trashUser(user.id, index)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <!-- filtered users -->
                    <tbody v-if="search_mode">
                        <tr v-for="(user, index) in filtered_users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.discount.name }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.email_verified_at }}</td>
                            <td>{{ user.order.length }}</td>
                            <td>
                                <a class="change-user-status" @click="changeUserDiscount(user)">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a class="about-icon" @click="openAboutUser(user.id)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="text-center trash-td">
                                <a class="trash-icon" @click="trashUser(user.id, index)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <Pager
                            v-if="!search_mode && users_page > 1"
                            routerName="users"
                            :frame=10
                            :pageCount="users_page"
                            @updateItems="getUsers">
                        </Pager>
                    </div>
                </div>
            </div>
            <ChangeUserDiscount></ChangeUserDiscount>
        </div>
</template>
<script>
import Pager from '../helpers/Pager'
import ChangeUserDiscount from './includes/modals/ChangeUserDiscount'

export default {
    components: {
        Pager, ChangeUserDiscount
    },
    data () {
        return {
            search_param: null,
            search_mode: false
        }
    },
    computed: {
        users () {
            return this.$store.getters.users
        },
        filtered_users () {
            return this.$store.getters.findedUsers
        },
        users_page () {
            return this.$store.getters.usersPageCount
        }
    },
    mounted() {
        this.$store.dispatch('getUsers', 1)
        this.$store.dispatch('getDiscounts')
    },
    methods: {
        search() {
            this.$store.dispatch('findUsers', this.search_param)
        },
        trashUser (user_id, index) {
            this.$store.dispatch('trashUser', { user_id, index })
        },
        openAboutUser (id) {
            this.$router.push({ name: 'user', params: { id }})
        },
        getUsers (page = 1) {
            this.$store.dispatch('getUsers', page)
        },
        setSearchParamNull () {
            this.search_param = null
        },
        searchModeOn () {
            this.search_mode = true
        },
        searchModeOff () {
            this.search_mode = false
        },
        clearSearchParam () {
            this.search_param = null
        },
        changeUserDiscount (user) {
            this.$store.commit('SET_SELECTED_USER', user)
            this.$bvModal.show('change-user-discount')
        }
    },

}
</script>
<style scoped>
    .trash-icon {
        color: red;
    }
    .btn-trashed {
        background-color: transparent;
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightgrey;
    }
    .btn-trashed {
        border-color: orange;
    }
    .btn-trashed:hover {
        border-color: red;
    }
    .trash-td {
        color: red;
    }
    .search-param-button {
        background-color: lightgrey;
        font-size: 0.9em;
        padding: 10px 20px 10px 20px;
        color: #333;
        border: 0px;
        /* margin-left: 1.5%; */
        margin-bottom: 3%;
    }
    /* search_param  */
    .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .search-field {
        padding-left: 3%;
        padding-bottom: 5%;
    }
    .search-input {
        padding-left: 10%;
    }
</style>
