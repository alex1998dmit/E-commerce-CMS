<template>
    <div class="row">
        <div class="col-md-12">
            {{ authErrors.messages }}
        </div>
        <div class="col-md-12 text-center" v-if="isCorrectUser">
            <form action="" @submit.prevent.default="resetPassword">
                <div class="form-group">
                    <label for="">Новый пароль</label>
                    <input type="text" v-model="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Подтвердите новый пароль</label>
                    <input type="text" v-model="password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success">
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
                this.$store.dispatch('resetPassword', data)
                    .then(() => {
                        this.$router.push('login')
                        this.flash('Пароль изменен', 'success', {
                            timeout: 2000,
                            important: true
                        })
                    })
                    .catch(error => {
                        this.flash('Ошибка при сбросе пароля', 'danger', {
                            timeout: 2000,
                            important: true
                        })
                        this.authErrors = error.response.data.messages
                    })
            }
        }
    }
</script>

<style scoped>

</style>
