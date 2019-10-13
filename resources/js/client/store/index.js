import axios from 'axios'

export default {
  state: {
    host: process.env.MIX_APP_HOST_NAME,
    auth: {
      currentUser: JSON.parse(localStorage.getItem('user')) || null,
      token: localStorage.getItem('access_token') || null,
      secret: process.env.MIX_SECRET_CODE,
      loading: false,
      errors: {
        login_error: null,
        name: [],
        email: [],
        password: []
      }
    },
    search_param: null,
    categories: {
      items: [],
      selected: {
        name: null,
        final_sub_categories: []
      }
    },
    products: {
      items: [],
      similar: [],
      page: 1,
      pageCount: 0,
      sortedBy: 'date',
      selected: {
        name: null,
        photo: [
          {path: 'default.jpeg'}
        ],
        category: {}
      }
    },
    shoppingCart: {
      items: [],
      selected: {}
    },
    wishList: {
      items: [],
      selected: {}
    },
    orders: {
      items: [],
      selected: {},
      page: 1,
      pageCount: 0
    },
    requisites: {
      items: []
    }
  },
  getters: {
    host: (state) => state.host,
    categories: (state) => state.categories.items,
    selectedCategory: (state) => state.categories.selected,
    products: (state) => state.products,
    searchParam: (state) => state.search_param,
    isLoggedIn: (state) => state.auth.token !== null,
    authErrors: (state) => state.auth.errors,
    currentUser: (state) => state.auth.currentUser,
    shoppingCartItems: (state) => state.shoppingCart.items,
    wishListItems: (state) => state.wishList.items,
    orders: (state) => state.orders.items,
    requisites: (state) => state.requisites.items
  },
  mutations: {
    SET_CATEGORIES_ITEMS: (state, categories) => { state.categories.items = categories },
    SET_SELECTED_CATEGORY: (state, category) => { state.categories.selected = category },
    // products
    SET_PRODUCTS_ITEMS: (state, products) => {
      state.products.items = products.data
      state.products.pageCount = products.last_page
    },
    SET_PRODUCTS_PAGE: (state, page) => { state.products.page = page },
    SET_SELECTED_PRODUCT: (state, product) => { state.products.selected = product },
    SET_SIMILAR_PRODUCTS: (state, products) => { state.products.similar = products },
    SET_SEARCH_PARAM: (state, param) => { state.search_param = param },
    //  auth
    SET_USER_TOKEN: (state, token) => { state.auth.token = token },
    DESTROY_TOKEN: (state) => { state.auth.token = null },
    REMOVE_USER_PARAMS: (state) => { state.auth.currentUser = null },
    SET_CURRENT_USER_PARAMS: (state, user) => { state.auth.currentUser = user },
    REGISTER_FAILED: (state, errors) => {
      state.auth.loading = false
      for (let key in errors) {
        state.auth.errors[key] = errors[key]
      }
    },
    LOGIN_FAILED: (state, error) => {
      state.auth.loading = false
      state.auth.errors.login_error = error
    },
    CLEAR_AUTH_ERRORS: (state) => { state.auth.errors = { name: [], email: [], password: [], login_error: null } },
    // shoppingCart
    SET_SHOPPING_CART_ITEMS: (state, items) => { state.shoppingCart.items = items },
    ADD_TO_SHOPPING_CART_ITEMS: (state, item) => {
        if (state.shoppingCart.items.filter(cartItem => cartItem.product_id === item.product_id).length === 0) {
          state.shoppingCart.items.push(item)
        }
    },
    REMOVE_FROM_SHOPPING_CART: (state, index) => { state.shoppingCart.items.splice(index, 1) },
    UPDATE_SHOPPING_CART_ITEM: (state, { index, item }) => { state.shoppingCart.items.splice(index, 1, item) },
    // wishList
    SET_WISH_LIST_ITEMS: (state, items) => { state.wishList.items = items },
    ADD_TO_WISH_LIST_ITEMS: (state, item) => { state.wishList.items.push(item) },
    REMOVE_FROM_WISH_LIST: (state, index) => { state.wishList.items.splice(index, 1) },
    UPDATE_WISH_LIST_ITEM: (state, { index, item }) => { state.wishList.items.splice(index, 1, item) },
    // orders
    SET_ORDER_ITEMS: (state, orders) => { state.orders.items = orders },
    ADD_ORDER: (state, order) => { state.orders.items.push(order) },
    UPDATE_ORDER_ITEM: (state, { index, order }) => { state.orders.items.splice(index, 1, order) },
    // requisites
    SET_REQUISITES_ITEMS: (state, requisites) => { state.requisites.items = requisites }
  },
  actions: {
    getCategories: (context) => {
      axios
        .get(`${context.getters.host}/api/v1/client/categories`)
        .then(response => context.commit('SET_CATEGORIES_ITEMS', response.data))
    },
    getCategory: (context, categoryId) => {
      axios
        .get(`${context.getters.host}/api/v1/client/categories/${categoryId}`)
        .then(response => context.commit('SET_SELECTED_CATEGORY', response.data))
    },
    getCategoryWithProduct: (context, { categoryId, page, sortedBy }) => {
      axios
        .get(`${context.getters.host}/api/v1/client/categories/${categoryId}/products?page=${page}&sortedBy=${sortedBy}`)
        .then(response => context.commit('SET_PRODUCTS_ITEMS', response.data))
    },
    getProducts: (context) => {
      axios
        .get(`${context.getters.host}/api/v1/client/products`)
        .then(response => context.commit('SET_PRODUCTS_ITEMS', response.data))
    },
    getProduct: (context, productId) => {
      axios
        .get(`${context.getters.host}/api/v1/client/products/${productId}`)
        .then(response => context.commit('SET_SELECTED_PRODUCT', response.data))
    },
    getSimilarProducts: (context, productId) => {
      axios
        .get(`${context.getters.host}/api/v1/client/products/${productId}/similar`)
        .then(response => context.commit('SET_SIMILAR_PRODUCTS', response.data))
    },
    getFindedProducts: (context) => {
      let searchParam = { search_param: context.getters.searchParam }
      axios
        .post(`${context.getters.host}/api/v1/client/search/products`, searchParam)
        .then(response => context.commit('SET_PRODUCTS_ITEMS', response.data))
    },
    // auth
    register: (context, data) => {
      return new Promise((resolve, reject) => {
        axios.post(`${context.getters.host}/api/v1/register`, {
          name: data.name,
          email: data.email,
          password: data.password
        })
          .then((resp) => {
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при регистрации')
            reject(error)
          })
      })
    },
    retrieveToken: (context, credentials) => {
      context.state.auth.loading = true
      return new Promise((resolve, reject) => {
        axios.post(`${context.getters.host}/api/v1/login`, {
          username: credentials.username,
          password: credentials.password,
          secret: context.state.auth.secret
        })
          .then((resp) => {
            const token = resp.data.access_token
            localStorage.setItem('access_token', token)
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            context.commit('SET_USER_TOKEN', token)
            context.commit('CLEAR_AUTH_ERRORS')
            resolve(resp)
          })
          .catch((error) => {
            // console.log('Ошибка при входе')
            reject(error)
          })
      })
    },
    destroyToken: (context) => {
      axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
      if (context.getters.isLoggedIn) {
        return new Promise((resolve, reject) => {
          axios.post(`${context.getters.host}/api/v1/logout`)
            .then((resp) => {
              localStorage.removeItem('access_token')
              context.commit('DESTROY_TOKEN')
              resolve(resp)
            })
            .catch((error) => {
              localStorage.removeItem('access_token')
              localStorage.removeItem('user')
              context.commit('DESTROY_TOKEN')
              context.commit('REMOVE_USER_PARAMS')
              console.log('Ошибка при выходе')
              console.log(error)
              reject(error)
            })
        })
      }
    },
    getUserInfo: (context) => {
      return new Promise((resolve, reject) => {
        if (context.state.auth.token) {
          axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
          axios.get(`${context.getters.host}/api/v1/user`)
            .then((resp) => {
              localStorage.setItem('user', JSON.stringify(resp.data))
              context.commit('SET_CURRENT_USER_PARAMS', resp.data)
              resolve(resp.data)
            })
            .catch((error) => {
              console.log('Ошибка при получении информации о пользователе')
              reject(error)
            })
        }
      })
    },
    // password reset
      getUserInfoByPasswordResetToken (context, token) {
          return new Promise((resolve, reject) => {
              axios.get(`${context.getters.host}/api/password/find/${token}`)
                  .then(resp => resolve(resp.data))
                  .catch((error) => {
                      console.log('Ошибка при сбросе пароля');
                      console.log(error);
                      reject(error);
                  })
          })
      },
      resetPassword (context, data) {
        return new Promise((resolve, reject) => {
          axios.post(`${context.getters.host}/api/password/reset`, data)
              .then(resp => resolve(resp.data))
              .catch(error => {
                  console.log('Ошибка при сбросе пароля')
                  // console.log.log(error)
                  reject(error)
              })
        })
      },
      sendResetPasswordMail (context, data) {
        return new Promise((resolve, reject) => {
            axios.post(`${context.getters.host}/api/password/create`, data)
                .then(resp => resolve(resp.data))
                .catch(error => {
                    console.log('Ошибка при сбросе пароля')
                    // console.log.log(error)
                    reject(error)
                })
        })
    },
    // shoppingCart
    getShoppingCart: (context) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/cart`)
          .then((resp) => {
            context.commit('SET_SHOPPING_CART_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при получении товаров корзины')
            reject(error)
          })
      })
    },
    addToShoppingCart: (context, data) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.post(`${context.getters.host}/api/v1/client/cart`, data)
          .then((resp) => {
            context.commit('ADD_TO_SHOPPING_CART_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при добавлении товара в коризину')
            reject(error)
          })
      })
    },
    removeFromShoppingCart: (context, { cartId, index }) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/cart/${cartId}/remove`)
          .then((resp) => {
            context.commit('REMOVE_FROM_SHOPPING_CART', index)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при удалении товара в корзине')
            reject(error)
          })
      })
    },
    updateCart: (context, { cartId, data, index }) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.put(`${context.getters.host}/api/v1/client/cart/${cartId}`, data)
          .then((resp) => {
            context.commit('UPDATE_SHOPPING_CART_ITEM', { index, item: resp.data })
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при обновлении товара в корзине')
            reject(error)
          })
      })
    },
    // wishList
    getWishList: (context) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/wishlist`)
          .then((resp) => {
            context.commit('SET_WISH_LIST_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при получении товаров cо списка любимых')
            reject(error)
          })
      })
    },
    addToWishList: (context, data) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.post(`${context.getters.host}/api/v1/client/wishlist`, data)
          .then((resp) => {
            context.commit('ADD_TO_WISH_LIST_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при добавлении товара в списко любимых')
            reject(error)
          })
      })
    },
    removeFromWishList: (context, { wishListId, index }) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/wishlist/${wishListId}/remove`)
          .then((resp) => {
            context.commit('REMOVE_FROM_WISH_LIST', index)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при удалении товара из спика избранных')
            reject(error)
          })
      })
    },
    updateWishList: (context, { wishListId, data, index }) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.put(`${context.getters.host}/api/v1/client/wishlist/${wishListId}`, data)
          .then((resp) => {
            context.commit('UPDATE_WISH_LIST_ITEM', { index, item: resp.data })
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при обновлении товара в спике избранных')
            reject(error)
          })
      })
    },
    // Order
    getOrder: (context) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/orders`)
          .then((resp) => {
            context.commit('SET_ORDER_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при получении заказов')
            reject(error)
          })
      })
    },
    createOrder: (context, order) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.post(`${context.getters.host}/api/v1/client/orders`, order)
          .then((resp) => {
            context.commit('ADD_ORDER', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при создании')
            reject(error)
          })
      })
    },
    changeOrderStatus: (context, { orderId, statusId, index }) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.put(`${context.getters.host}/api/v1/client/orders/${orderId}`, { status_id: statusId })
          .then((resp) => {
            context.commit('UPDATE_ORDER_ITEM', { order: resp.data, index })
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при обновлении заказа')
            reject(error)
          })
      })
    },
    // Requisites
    getRequisites: (context) => {
      return new Promise((resolve, reject) => {
        axios.defaults.headers.common['Authorization'] = `Bearer ${context.state.auth.token}`
        axios.get(`${context.getters.host}/api/v1/client/requisites`)
          .then((resp) => {
            context.commit('SET_REQUISITES_ITEMS', resp.data)
            resolve(resp)
          })
          .catch((error) => {
            console.log('Ошибка при создании')
            reject(error)
          })
      })
    }
  }
}
