<template>
    <b-modal id="change-order-modal" title="Изменить заказ" hide-footer>
        <div class="row">
            <div class="col-12">
                <div class="current-order-params">
                    <p>
                        Пользователь (имя): {{ order.user.name }}
                        <a class="edit-pencil" @click="showUsersSearchForm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    </p>
                    <p>
                        Пользователь (email): {{ order.user.email }}
                        <a class="edit-pencil" @click="showUsersSearchForm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    </p>
                    <p>
                        Сумма: {{ order.sum }}
                        <a class="edit-pencil" @click="showOrderSumChangeForm">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-12" v-if="is_search_users">
                <h5 class="chose-user-sign">Поиск по пользователям</h5>
                <form action="" @submit.prevent="findUsers">
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" v-model="search_param" placeholder="Email пользователя">
                        </div>
                        <div class="col-4">
                            <input type="submit" class="btn btn-search" value="Найти">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="filtered-users" v-if="is_search_users">
                    Выберите пользователя:
                    <ul>
                        <li v-for="user in filtered_users" :key="user.id">
                            <a class="chose-product-button" @click="selectUser(user.id, user.name, user.email)">
                                {{ user.name }} - {{ user.email }}
                                <button class="chose-user-button">Заменить</button>
                                <!-- <i class="fa fa-plus" aria-hidden="true"></i> -->
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12" v-if="is_change_sum">
                <div class="row">
                    <div class="col-12">
                        <div class="previous-sum">
                            Предыдущая стоимость: {{ order.sum }}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="order-sum">
                            <input type="number" v-model="update_order_params.sum" class="form-control" placeholder="Новая стоимость">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="save-sum">
                            <input type="submit" class="save-price-button" value="Обновить" @click="changeSum">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    props: ['order_index'],
    data () {
        return {
            search_param: null,
            is_search_users: false,
            is_change_sum: false,
            old_order_params: {
                user_id: null,
                user_name: null,
                user_email: null,
                sum: 0
            },
            update_order_params: {
                user_id: null,
                sum: null
            }
        }
    },
    computed: {
        filtered_users() {
            return this.$store.getters.findedUsers
        },
        order () {
            return this.$store.getters.selectedOrder
        },
    },
    mounted() {
        this.update_order_params.user_id = this.order.user_id
        this.update_order_params.sum = this.order.sum
    },
    methods: {
        showUsersSearchForm () {
            this.is_search_users = true
            this.is_change_sum = false
        },
        showOrderSumChangeForm () {
            this.is_change_sum = true
            this.is_search_users = false
        },
        findUsers () {
            if (this.search_param.length > 3) {
                this.$store.dispatch('findUsers', this.search_param)
            } else {
                alert('Введите больше 3 символов')
            }
        },
        selectUser (user_id, user_name, user_email) {
            const order = { user_id }
            this.$store.dispatch('updateOrder', { order_id: this.order.id, index: this.order_index, order })
            this.is_search_users = false
        },
        changeSum () {
            const order = { sum: this.update_order_params.sum }
            this.$store.dispatch('updateOrder', { order_id: this.order.id, index: this.order_index, order })
        },
    }
}
</script>

<style scoped>
    ul {
        padding-top: 2%;
    }
    input {
        font-size: 0.8em;
    }
    form {
        padding-bottom: 5%;
    }
    p {
        margin-bottom: 0rem;
        color: black;
        font-size: 0.9em;
    }
    .btn-search {
        border: 0px;
        border-bottom: 2px solid blue;
        border-radius: 0px;
        font-size: 0.9em;
        width: 100%;
    }
    .btn-search:hover {
        border-color: lightblue;
    }
    .btn-save {
        border-radius: 0px;
        border: 0px;
        border-bottom: 2px solid green;
        font-size: 0.9em;
    }
    .btn-save:hover {
        border-color: lightgreen;
    }
    .btn-cancel {
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid red;
        font-size: 0.9em;
    }
    .btn-cancel:hover {
        border-color: brown;
    }
    .filtered-users {
        padding-left: 1%;
        padding-top: 2%;
        font-size: 0.9em;
    }
    .new-product-sign {
        padding-top: 3%;
        font-size: 0.9em;
    }
    .current-order-params {
        padding-bottom: 5%;
    }
    .edit-pencil {
        font-size: 0.8em;
    }
    .edit-pencil:hover {
        opacity: 0.5;
    }
    .chose-user-button, .save-price-button {
        font-size: 0.8em;
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightgreen;
        width: 100%;
    }
    .chose-user-button:hover {
        border-color: green;
    }
    .save-price-button:hover {
        border-color: green;
    }
    .chose-user-sign, .change-price-sign {
        font-size: 1em;
        padding-bottom: 2%;
    }
    .previous-sum {
        padding-bottom: 2%;
        font-size: 0.8em;
    }
</style>
