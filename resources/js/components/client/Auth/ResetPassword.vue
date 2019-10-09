<template>
    <div class="row">
        <div class="col-md-12 text-center">
            <h6 v-for="error in errors" class="error-message">
                {{ error.message }}
            </h6>
        </div>
        <div class="col-md-6 offset-md-3 text-center" v-if="isCorrectUser">
            <form action="" @submit.prevent.default="resetPassword">
                <div class="form-group">
                    <label for="">Новый пароль</label>
                    <input type="password" v-model="password" class="form-control input-password" v-bind:class="{ 'is-invalid': errors.length > 0 }">
                </div>
                <div class="form-group">
                    <label for="">Подтвердите новый пароль</label>
                    <input type="password" v-model="password_confirmation" class="form-control input-password" v-bind:class="{ 'is-invalid': errors.length > 0 }">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-reset-password">
                </div>
            </form>
        </div>
        <div class="col-md-4" v-else>
            <h3>Пользователь не найден</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResetPassword",
        data() {
            return {
                user: {
                  email: null,
                  updated_at: null,
                },
                password: null,
                password_confirmation: null,
                token: null,
                errors: [],
                authErrors: {
                    messages: null
                }
            }
        },
        computed: {
            isCorrectUser() {
                return this.user.email
            }
        },
        mounted() {
            this.token = this.$route.params.token
            this.$store.dispatch('getUserInfoByPasswordResetToken', this.token)
                .then(user => this.user = user )
        },
        methods: {
            resetPassword () {
                const data = {
                    email: this.user.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token
                }
                this.errors = []
                this.validate()
                this.$store.dispatch('resetPassword', data)
                    .then(() => {
                        this.flash('Пароль изменен', 'success', {
                            timeout: 2000,
                            important: true
                        })
                        this.$router.push({ name: 'login' })
                    })
                    .catch(error => {
                        this.flash('Ошибка при сбросе пароля', 'danger', {
                            timeout: 2000,
                            important: true
                        })
                        this.authErrors = error.response.data.messages
                    })
            },
            validate () {
                if (this.password !== this.password_confirmation) {
                    this.errors.push({
                        message: 'Парооли не совпадают'
                    })
                }
                if (this.password.length < 5) {
                    this.errors.push({
                        message: 'Короткий пароль'
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .btn-reset-password {
        border-radius: 0;
        background-color: #f4f4f4;
        border: 0;
        font-size: 15px;
        font-style: normal;
        font-weight: 400;
        color: #333;
        line-height: 1.6;
    }
    .btn-reset-password:hover {
        background-color: #333;
        color: white;
    }
    .input-password {
        border-radius: 0px;
    }
    .error-message {
        color: red;
    }
</style>
