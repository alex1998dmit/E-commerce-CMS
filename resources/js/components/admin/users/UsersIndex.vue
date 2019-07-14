<template>
    <div>
        <div class="row">
            <div class="col-md-6 text-left">
                <div class="form-group mx-sm-3">
                    <input class="form-control" v-model="search_param" @change="search()" id="user_param" name="param" type="text" placeholder="Поиск..">
                </div>
            </div>
            <div class="col-md-6 text-right">
                <a href="" class="btn btn-xs btn-warning">Удаленные пользователи</a>
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
                            <th scope="col">Дата регистрации</th>
                            <th scope="col">Дата подтверждения аккаунта</th>
                            <th scope="col">Кол-во заказов</th>
                            <th scope="col">В сумме потрачено</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Подробнее</th>
                            <th scope="col">Удалить</th>
                        </tr>
                    </thead>
                    <tbody class="categories_list" id="categories_list">
                        <tr v-for="user in users">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.email_verified_at }}</td>
                            <!-- <td>{{ user.order }}</td> -->
                            <td>В разработке</td>
                            <td>{{ 'В разработке' }}</td>
                            <td>
                                <tr v-for="role in user.role">
                                    {{ role.name }}
                                </tr>
                            </td>
                            <td>
                                <b-button v-b-modal.modal-xl variant="primary" @click="showUserModal(user.id)">Заказы</b-button>
                            </td>
                            <!-- <td><a href="" class="btn btn-xs btn-info">Подробнее</a></td> -->
                            <td><a href="" class="btn btn-xs btn-danger">Удалить</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <singleUserModal :user="user"></singleUserModal>
        </div>
    </div>
</template>
<script>
import singleUserModal from './includes/singleUserModal';

export default {
    components: {
        singleUserModal
    },
    data: () => {
        return {
            search_param: "",
            users: [],
            user: {
                name: "",
                order: []
            },
        }
    },
    mounted() {
        let app = this;
        axios.get('/api/v1/users')
            .then((resp) => {
                app.users = resp.data;
            })
            .catch((resp) => {
                console.log(resp);
                alert("Возникла проблемма при загрузке");
            });
    },
    methods: {
        showUserModal(id) {
            let app = this;
            axios.get('/api/v1/users/' + id)
            .then((resp) => {
                app.user = resp.data;
                console.log(app.user);
            })
            .catch((resp) => {
                console.log(resp);
                alert("Возникла проблемма при загрузке");
            });
        },
        search() {
            event.preventDefault();
            let app = this;
            axios.get('/api/v1/users/search', {
                params: {
                    param: app.search_param
                }
            })
            .then((resp) => {
                app.users = resp.data;
            })
            .catch((resp) => {
                console.log(resp);
                alert("Возникла проблемма при поиске");
            });
        }
    }
}
</script>
