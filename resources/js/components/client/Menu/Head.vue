<template>
  <nav class="navbar navbar-expand-lg navbar-light navbar-head">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="search">
        <form class="form-inline my-2 my-lg-0" @submit.prevent="findProducts()">
          <span class="fa fa-search form-control-feedback"></span>
          <input class="form-control mr-sm-2" type="search" placeholder="Поиск продуктов ..." aria-label="Search" v-model="search_param">
        </form>
      </div>
      <ul class="navbar-nav ml-auto logged-user" v-if="isLoggedIn">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'shoppingCart' }">
            <i class="fa fa-shopping-cart">
                <span class="head-nav-icon-sign">Корзина {{ shoppingCartAmount }}</span>
<!--              <span class="head-nav-icon-sign">({{ user.at_cart_count }})</span>-->
            </i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'wishList' }">
            <i class="fa fa-heart">
                <span class="head-nav-icon-sign">Избранное {{ wishListAmount }}</span>
<!--              <span class="head-nav-icon-sign">({{ user.wishlist_count }})</span>-->
            </i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'orders' }">
            <i class="fa fa-user-circle-o">
              <span class="head-nav-icon-sign">Заказы</span>
            </i>
          </router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-if="isAdmin" @click="redirectToAdminPage">
              <i class="fa fa-lock">
                <span class="head-nav-icon-sign">Панель</span>
              </i>
          </a>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'logout' }">
            <i class="fa fa-sign-out">
              <span class="head-nav-icon-sign">Выйти</span>
            </i>
          </router-link>
        </li>
      </ul>
      <!-- UnLogged In     -->
      <ul class="navbar-nav ml-auto logged-user" v-else>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'login' }">
            <i class="fa fa-sign-in" aria-hidden="true">
              <span class="head-nav-icon-sign">Войти</span>
            </i>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'register' }">
              <i class="fa fa-user-plus" aria-hidden="true">
                <span class="head-nav-icon-sign">Регистрация</span>
              </i>
          </router-link>
        </li>

      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Head',
  data () {
    return {
      search_param: null
    }
  },
  computed: {
    isLoggedIn () {
      return this.$store.getters.isLoggedIn
    },
    shoppingCartAmount () {
      return this.$store.getters.shoppingCartItems.length
    },
    user () {
      if (this.isLoggedIn) {
        return this.$store.getters.currentUser
      }
    },
    wishListAmount () {
      return this.$store.getters.wishListItems.length
    },
    isAdmin () {
      return this.user.role.filter(role => role.name === 'admin').length > 0
    }
  },
  mounted() {
    if (this.isLoggedIn) {
      this.$store.dispatch('getShoppingCart')
      this.$store.dispatch('getWishList')
    }
  },
  methods: {
    findProducts () {
      this.$store.commit('SET_SEARCH_PARAM', this.search_param)
      this.$store.dispatch('getFindedProducts', { search_param: this.search_param })
      this.$router.push({name: 'searchProduct'})
    },
    redirectToAdminPage () {
        window.location.href = `${process.env.MIX_APP_HOST_NAME}/admin/orders`
    }
  }
}
</script>

<style scoped>

</style>
