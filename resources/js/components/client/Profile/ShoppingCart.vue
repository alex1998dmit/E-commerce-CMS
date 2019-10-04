<template>
  <div class="row">
    <div class="col-md-12">
      <div class="table-header">
        <div class="row">
          <div class="col-6">
            <div class="table-head product">
              Продукт
            </div>
          </div>
          <div class="col-2">
            <div class="table-head price">
              Цена
            </div>
          </div>
          <div class="col-2">
            <div class="table-head quantity">
              Кол-во
            </div>
          </div>
          <div class="col-2">
            <div class="table-head total">
              Сумма
            </div>
          </div>
        </div>
      </div>
      <div class="table-body">
        <div class="products">
          <div class="item" v-for="(item, index) in cartItems" :key="item.id">
            <div class="row">
              <div class="col-6">
                <div class="row">
                  <div class="col-4">
                    <div class="img-block">
                      <img :src="`${host}/upload/products/${item.product.photo[0].path}`" alt="">
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="product-description">
                      <div class="product-name">
                        <router-link :to="{ name: 'product', params: { id: item.product_id }}">{{ item.product.name }}</router-link>
                      </div>
                      <div class="category">
                        {{ item.product.category.name}}
                      </div>
                      <div class="remove-button">
                        <button @click="removeFromShoppingCart(item.id, index)">Убрать</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-2">
                <div class="product-price">
                  {{ item.product.price}} ₽
                </div>
              </div>
              <div class="col-2">
                <div class="product-quantity">
                  <input type="number" class="quanity-selector" min="1" max="1000000" v-model="item.amount" @change="updateCart(item.id, index, { amount: item.amount })">
                </div>
              </div>
              <div class="col-2">
                <div class="product-total">
                  {{ (item.amount * item.product.price) }} ₽
                </div>
              </div>
            </div>
          </div>
          <div class="table-footer">
            <div class="row">
              <div class="col-md-6">
<!--                <textarea name="" id="" cols="30" rows="5" class="order-comment form-control" placeholder="Комментарий к заказу"></textarea>-->
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-12">
                    <div class="price-total text-right">
                      <h4>Итого: <strike v-if="discountCategory.discount > 0">{{ subTotal }}</strike> {{ subTotal - (Number(discountCategory.discount) * (subTotal))/100 }} ₽</h4>
                      <small v-if="discountCategory.discount > 0">С учетом вашей персональной скидки *</small>
                    </div>
                  </div>
                  <div class="col-12 text-right">
                    <router-link :to="{ name: 'test' }" class="btn continue-shopping-button">Продолжить покупки</router-link>
                  </div>
                  <div class="col-12 text-right">
                    <input type="submit" class="btn check-out-button" value="Оформить заказ" @click="makeOrder">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ProductActions } from '../../../client/mixins/ProductActions'

export default {
  name: 'ShoppingCart',
  mixins: [ProductActions],
  computed: {
    cartItems () {
      return this.$store.getters.shoppingCartItems
    },
    discountSize () {
      return 0
    },
    subTotal () {
      return this.$store.getters.shoppingCartItems.reduce((acc, item) => {
        acc = acc + item.amount * item.product.price
        return acc
      }, 0)
    },
    discountCategory () {
      return this.$store.getters.currentUser.discount
    },
    host () {
      return this.$store.getters.host
    }
  },
  mounted() {
    this.$store.dispatch('getShoppingCart')
  },
  methods: {
    updateCart (cartId, index, data) {
      data.amount = data.amount > 0 ? data.amount : 1
      this.$store.dispatch('updateCart', { cartId, index, data })
    },
    makeOrder () {
      let products = this.cartItems.reduce((acc, item) => {
        return [...acc, { id: item.product_id, amount: item.amount }]
      }, [])
      this.$store.dispatch('createOrder', { products })
        .then(resp => {
          this.flash('Заказ оформлен', 'success', {
              timeout: 2000,
              important: true
          })
          this.$router.push('orders')
        })
        .catch(error => {
          this.flash('Произошла ошибка при оформлении заказа, попробуйте позже', 'danger', {
              timeout: 2000,
              important: true
          })
          console.log(error)
        })
    }
  }
}
</script>

<style scoped>
  a {
    color: #333;
    text-decoration: none;
  }
  .table-head {
    padding: 0;
    font-size: 0.9em;
     color: #333;
    font-weight: 600;
  }
  .img-block img {
    width: 100%;
    height: auto;
  }
  .product-name a {
    color: #333;
    text-decoration: none;
    font-size: 0.9em;
  }
  .category {
    color: #333;
    font-size: 0.7em;
  }
  .remove-button {
    padding-top: 5%;
    font-size: 0.8em;
  }
  .remove-button button {
    border: 0px;
    background: lightgrey;
    font-size: 0.9em;
  }
  .remove-button:hover {
    opacity: 0.8;
  }
  .product-price, .product-total {
    font-size: 0.8em;
    color: #333;
  }
  .quanity-selector {
    font-size: 0.8em;
    width: 55px;
    border-radius: 0;
    max-width: 100%;
    background-color: #f4f4f4;
    border: 0;
    padding: 8px;
  }
  .table-body {
    padding-top: 5%;
  }
  .order-comment {
    border: 0px;
    border-radius: 0px;
    background: #f4f4f4;
    font-size: 0.8em;
  }
  .price-total {
    padding-bottom: 5%;
  }
  .continue-shopping-button {
    border: 1px solid black;
    border-radius: 0px;
    color: #333;
    font-size: 0.9em;
  }
  .continue-shopping-button:hover {
    opacity: 0.8;
  }
  .check-out-button {
    border-radius: 0px;
    color: white;
    font-size: 0.9em;
    margin-top: 3%;
    background: #333;
  }
  .check-out-button:hover {
    opacity: 0.8;
  }
  .table-footer {
    padding-top: 5%;
  }
</style>
