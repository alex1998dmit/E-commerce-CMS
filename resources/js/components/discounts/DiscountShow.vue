<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>Информация о скидочной категории</h5>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <b>ID:</b><p>{{ discount.id }}</p>
                <b>Название:</b><p>{{ discount.name }}</p>
                <b>Размер скидки:</b><p>{{ discount.discount }}%</p>
            </div>
            <div class="col-md-6">
                <b>Описание:</b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID пользователя</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Подтверждение</th>
                            <th scope="col">О пользователе</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr v-for="user, index in discount.users">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.created_at }}</td>
                            <td><a href="" class="btn btn-info">О пользователе</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted(){
        let app = this;
        app.disountId = app.$route.params.id;
        axios.get('/api/v1/discounts/' + app.disountId)
            .then((resp) => {
                console.log(resp);
                app.discount = resp.data;
            })
            .catch((resp) => {
                console.log(resp);
                alert("Can't upload discount")
            })
    },
    data: () => {
        return {
            disountId: null,
            discount: {},
            users: {}
        }
    }
}
</script>

