<template>
    <div>
        <div class="row">
            <div class="col-md-6 text-left">
                <div class="form-group mx-sm-3">
                    <!-- <input class="form-control" v-model="search_param" @change="search()" id="user_param" name="param" type="text" placeholder="Поиск.."> -->
                </div>
            </div>
            <div class="col-md-6 text-right">
                <router-link :to="{ name: 'users' }" class="btn btn-navigate">Все пользователи</router-link>
            </div>
            </div>
            <br>
            <div class="category-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">emal</th>
                            <th scope="col">Дата удаления аккаунта</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="categories_list" id="categories_list">
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.deleted_at }}</td>
                            <td class="text-center restore-td">
                                <button class="btn-restore" @click="restoreUser(user.id, index)">
                                    Восстановить
                                </button>
                            </td>
                            <!-- <td>
                                <b-button v-b-modal.modal-xl variant="primary" @click="showUserModal(user.id)">Заказы</b-button>
                            </td> -->
                            <!-- <td><a href="" class="btn btn-xs btn-info">Подробнее</a></td> -->
                            <!-- <td><a href="" class="btn btn-xs btn-danger">Удалить</a></td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => {
        return {
            search_param: "",
            user: {
                name: "",
                order: []
            },
        }
    },
    computed: {
        users () {
            return this.$store.getters.trashedUsers
        }
    },
    mounted() {
        this.$store.dispatch('getTrashedUsers')
    },
    methods: {
        restoreUser (user_id, index) {
            this.$store.dispatch('restoreUser', { user_id, index })
        }
    },

}
</script>
<style scoped>
    .btn-restore {
        background-color: transparent;
        border: 0px;
        border-radius: 0px;
        border-bottom: 2px solid lightgreen;
    }
    .btn-restore:hover {
        border-color: green;
    }
    .btn-navigate {
        border-bottom: 2px solid lightgrey;
        border-radius: 0px;
    }
    .btn-navigate:hover {
        border-bottom: 2px solid black;
    }
</style>
