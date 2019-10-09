<template>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center">
            <form action="" @submit.prevent.default="sendMail">
                <div class="form-group">
                    <input type="email" placeholder="Введите почту" v-model="email" class="form-control input-email">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-send-email">
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
              .catch(error => {
                  this.flash('Письмо не отправлено, проверьте правильность ввода email или попробуйте позже', {
                      timeout: 2000,
                      important: true
                  })
              })
           }
        }
    }
</script>

<style scoped>
    .btn-send-email {
        border-radius: 0;
        background-color: #f4f4f4;
        border: 0;
        font-size: 15px;
        font-style: normal;
        font-weight: 400;
        color: #333;
        line-height: 1.6;
    }
    .btn-send-email:hover {
        background-color: #333;
        color: white;
    }
    .input-email {
        border-radius: 0px;
    }

</style>
