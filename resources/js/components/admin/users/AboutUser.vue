<template>
    <div class="row">
      <div class="col-md-12">
          <div class="row">
              <div class="col">
                  <h5>О пользователе</h5>
                  <h6>{{ user.email }}</h6>
              </div>
              <div class="col text-right">
                <button
                    class="btn-navigate-back"
                    @click="$router.go(-1)">
                        Назад
                </button>
            </div>
          </div>
        <div class="user-info">
            <div class="row">
                  <div class="col-6">
                      <div class="main-info">
                        <p>Имя пользователя: {{ user.name }}</p>
                        <p>Почта пользователя: {{ user.email }}</p>
                        <p>Категория пользователя: {{ user.discount.name }}</p>
                        <p>Заказов: {{ user.order.length }}</p>
                        <p>Товаров в корзине: {{ user.wish_list.length }}</p>
                        <p>Дата создания: {{ user.created_at }}</p>
                        <p>Дата подтверждения аккаунта: {{ user.email_verified_at }}</p>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="additional-info">
                        Роли пользователя:
                        <ul>
                            <li v-for="(role, index) in user.role" :key="index">
                                {{ role.name }}
                            </li>
                        </ul>
                        <hr>
                      </div>
                  </div>
              </div>
          </div>
          <hr>
          <div class="user-orders">
              <div class="row">
                  <div class="col-12 text-center">
                      <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Номер заказа</th>
                                <th scope="col">Сумма</th>
                                <th scope="col">Дата заказа</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in user.order" :key="index">
                                <th scope="row">{{ order.id }}</th>
                                <td>{{ order.sum }}</td>
                                <td>{{ order.created_at }}</td>
                            </tr>
                        </tbody>
                        </table>
                  </div>
              </div>
          </div>
      </div>
    </div>
</template>

<script>
export default {
    computed: {
        user() {
            return this.$store.getters.selectedUser
        }
    },
    mounted() {
        const user_id = this.$route.params.id
        this.$store.dispatch('getUser', user_id)
    }
}
</script>

<style scoped>
.user-info {
    padding-top: 5%;
}
.user-info p {
    color: #333;
    font-size: 0.9em;
}
</style>
