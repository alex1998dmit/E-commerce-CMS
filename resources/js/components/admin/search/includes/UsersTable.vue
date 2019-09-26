<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">ФИО</th>
                <th scope="col">emal</th>
                <th scope="col">Дата регистрации</th>
                <th scope="col">Дата подтверждения аккаунта</th>
                <th scope="col">Кол-во заказов</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(user, index) in users" :key="index">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.created_at }}</td>
                <td>{{ user.email_verified_at }}</td>
                <td>{{ user.order.length }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        users: Array
    }
}
</script>

<style>

</style>
