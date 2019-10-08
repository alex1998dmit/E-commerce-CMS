<template>
    <div class="row">
        <div class="col-md-12 text-center">
            <form action="" @submit.prevent.default="sendMail">
                <div class="form-group">
                    <input type="email" placeholder="Введите почту" v-model="email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SendResetPasswordMail",
        data() {
            return {
              email: null,
            }
        },
        methods: {
          sendMail () {
            const data = { email: this.email }
            this.$store.dispatch('sendResetPasswordMail', data)
              .then(() => {
                 this.$router.push({ name: 'login' })
                 this.flash('Письмо с изменением пароля отправлено на почту', 'success', {
                    timeout: 2000,
                    important: true
                  })
              })
           }
        }
    }
</script>

<style scoped>

</style>
