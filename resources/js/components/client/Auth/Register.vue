<template>
  <div class="row">
    <div class="col-12">
      <div class="row justify-content-center">
        <h4>Регистрация</h4>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          {{ authErrors.messages }}
        </div>
        <div class="col-md-6">
          <form @submit.prevent="register">
            <div class="form-group">
              <label for="username" class="register-label">Имя</label>
              <input type="text" class="form-control register-credentials" v-bind:class="{ 'is-invalid': authErrors.name.length > 0 }" id-="username" placeholder="Введите имя" v-model="name" required>
              <div class="invalid-feedback">
                <span v-for="(error, index) in authErrors.name" :key="index">{{ error }}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="register-label">Email</label>
              <input type="email" class="form-control register-credentials" v-bind:class="{ 'is-invalid': authErrors.email.length > 0 }" id="email" placeholder="Введите email адрес" v-model="email" required>
              <div class="invalid-feedback">
                <span v-for="(error, index) in authErrors.email" :key="index">{{ error }}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="register-label">Пароль</label>
              <input type="password" class="form-control register-credentials" v-bind:class="{ 'is-invalid': authErrors.password.length > 0 }" id="password" placeholder="Введите пароль" v-model="password" required>
              <div class="invalid-feedback">
                <span v-for="(error, index) in authErrors.password" :key="index">{{ error }}</span>
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn register-button">Регистрация</button>
              <router-link href="" :to="{ name: 'login' }" class="login-link">Уже есть акканут ?</router-link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data () {
    return {
      name: null,
      email: null,
      password: null
    }
  },
  computed: {
    authErrors () {
      return this.$store.getters.authErrors
    }
  },
  methods: {
    register () {
        console.log({ name: this.name, email: this.email, password: this.password })
      this.$store.dispatch('register', { name: this.name, email: this.email, password: this.password })
        .then(resp => {
          this.$store.commit('CLEAR_AUTH_ERRORS')
          this.flash('Регистрация прошла успешна, подтвердите почту', 'success', {
              timeout: 2000,
              important: true
          })
        })
        .catch(error => {
          this.$store.commit('REGISTER_FAILED', error.response.data.messages)
        })
    }
  }
}
</script>

<style scoped>
  .register-credentials {
    border-radius: 0px;
    font-size: 0.8em;
  }
  .register-label {
    font-size: 0.8em;
  }
  .register-button {
    font-size: 0.9em;
    background: lightgrey;
    color: #333;
    border-radius: 0;
  }
  .register-button:hover {
    background-color: #333;
    color:white;
  }
  .login-link {
    text-decoration: none;
    color: #333;
    font-size: 0.8em;
    padding-left: 5%;
  }
</style>
