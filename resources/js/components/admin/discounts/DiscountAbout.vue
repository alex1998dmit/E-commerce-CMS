<template>
    <div class="row">
        <div class="col-md-6 text-left">
            <h2>О скидочной категории</h2>
            <h4>{{ discount.name }}</h4>
        </div>
        <div class="col-md-6 text-right">
            <button
                class="btn-navigate-back"
                @click="$router.go(-1)">
                    Назад
            </button>
        </div>
        <div class="col-md-12">
            <div class="discount-info">
                <p>Название скидочной категории: <span>{{ discount.name }}</span></p>
                <p>Размер скидки: <span>{{ discount.discount}}</span></p>
                <p>Описание:
                    {{ discount.description }}
                </p>
                <p>Создано: {{ discount.created_at }}</p>
                <p>Обновлено в последний раз: {{ discount.updated_at }}</p>
                <p>Количество пользователей: {{ discount.users.length}}</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="discount-users">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">emal</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in discount.users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td class="text-center">
                                <a class="about-icon" @click="openAboutUser(user.id)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        discount() {
            return this.$store.getters.selectedDiscount
        }
    },
    mounted () {
        const id = this.$route.params.id
        this.$store.dispatch('getDiscount', { id })
    },
    methods: {
        openAboutUser (user_id) {
            this.$router.push({ name: 'user',  params: { id: user_id }})
        }
    }
}
</script>

<style>
    .discount-info {
        padding-top: 3%;
    }

    .discount-info p {
        font-size: 0.9em;
        color: black;
    }
</style>
