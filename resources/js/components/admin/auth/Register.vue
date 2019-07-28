<template>
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <h3>Регистрация</h3>
            <form action="" @submit.prevent="register">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="username">ФИО</label>
                        <input type="username" name="username" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input type="email" name="email" id="" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12">
                    <b-button variant="outline-primary">Зарегистрироваться</b-button>
                    <b-button variant="success">Войти</b-button>
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
        register() {

        }
    }
}
</script>

<style>

</style>
