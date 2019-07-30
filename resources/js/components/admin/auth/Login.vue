<template>
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <h2>Вход</h2>
            <form action="" @submit.prevent="login">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">Почта</label>
                        <input type="email" name="email" id="" class="form-control" v-model="username">
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control" v-model="password">
                    </div>
                </div>
                <div class="col-xs-12">
                    <b-button variant="outline-success" @click="login">Войти</b-button>
                    <b-button variant="primary" :to="{ name: 'register' }">Регистрация</b-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: "",
            password: "",
        }
    },
    methods: {
        login() {
            this.$store.dispatch('retrieveToken', {
                username: this.username,
                password: this.password,
            })
            .then(resp => {
                this.$store.dispatch("getUserInfo")
                    .then((resp) => {
                        this.$router.push({ name: "dashboard" });
                    })
            });
        }
    }
}
</script>

<style>

</style>
