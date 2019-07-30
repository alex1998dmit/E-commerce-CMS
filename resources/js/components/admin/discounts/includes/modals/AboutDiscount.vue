<template>
    <b-modal id="about-discount-modal" size="xl" title="Подробнее о скидочной категории" hide-footer>
        <div class="row">
            <div class="col-md-12 text-left">
                <h2>Информация о скидочной категории</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID скидочной категори</th>
                            <th scope="col">Название</th>
                            <th scope="col">Размер скидки</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Дата обновления</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ discount.id }}</td>
                            <td>{{ discount.name }}</td>
                            <td>{{ discount.discount }}</td>
                            <td>{{ discount.created_at }}</td>
                            <td>{{ discount.upadted_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 text-left">
                <h5>Пользователи этой категории:</h5>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по пользователям ...">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID пользователя</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Дата регистрации</th>
                            <th scope="col">Дата подтверждения</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>{{ user.email_verified_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            search_param: "",
        }
    },
    computed: {
        discount() {
            return this.$store.getters.selectedDiscount;
        },
        users() {
            if (this.search_param) {
                return this.discount.users.filter((user) => user.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return this.discount.users;
        }
    },
}
</script>

<style>

</style>
