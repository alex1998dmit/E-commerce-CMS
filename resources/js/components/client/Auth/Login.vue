<template>
  <div class="row">
    <div class="col-12">
      <div class="row justify-content-center">
        <h4>Вход</h4>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12 text-center" v-if="authErrors.login_error">
          <div class="error-message">
              <h5>Неправильно введены пароль или имя пользователя</h5>
          </div>
        </div>
        <div class="col-md-6">
          <form @submit.prevent="login">
            <div class="form-group">
              <label for="email" class="login-label">Email</label>
              <input type="email" v-model="username" class="form-control login-credentials" id="email" placeholder="Введите email адрес" required>
            </div>
            <div class="form-group">
              <label for="password" class="login-label">Пароль</label>
              <input type="password" v-model="password" class="form-control login-credentials" id="password" placeholder="Введите пароль" required>
            </div>
            <button type="submit" class="btn login-button">Войти</button>
            <router-link :to="{ name: 'register' }" class="register-link">Зарегистироваться</router-link>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data () {
    return {
      username: null,
      password: null
    }
  },
  computed: {
    authErrors () {
      return this.$store.getters.authErrors
    }
  },
  methods: {
    login () {
      this.$store.dispatch('retrieveToken', {
        username: this.username,
        password: this.password
      })
        .then(resp => {
          this.$store.commit('CLEAR_AUTH_ERRORS')
          this.$store.dispatch('getUserInfo')
            .then((resp) => {
                console.log(resp)
                if (!resp.email_verified_at) {
                  this.flash('Необходимо подтвердить почту, чтобы делать заказы', 'danger', {
                    important: true
                  })
                  this.$store.dispatch('destroyToken')
                } else {
                  this.flash('Вход выполнен', 'success')
                  this.$router.push({ name: 'products' })
                }
            })
          this.$store.dispatch('getShoppingCart')
        })
        .catch((error) => {
          this.$store.commit('LOGIN_FAILED', { error })
        })
    }
  }
}
</script>

<style scoped>
  .login-credentials {
    border-radius: 0px;
    font-size: 0.8em;
  }
  .login-label {
    font-size: 0.8em;
  }
  .login-button {
    font-size: 0.9em;
    background: lightgrey;
    color: #333;
    border-radius: 0;
  }
  .login-button:hover {
    background-color: #333;
    color:white;
  }
  .register-link {
    text-decoration: none;
    color: #333;
    font-size: 0.8em;
    padding-left: 5%;
  }
  .error-message h5 {
    font-size: 0.8em;
    color: red;
    padding-top: 2%;
    padding-bottom: 2%;
  }
</style>
