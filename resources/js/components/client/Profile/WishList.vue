<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col">
          <h4>Избранное</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
        </div>
        <div class="table-body">
          <div class="products">
            <div class="item" v-for="(item, index) in products" :key="item.id">
              <div class="row">
                <div class="col-6">
                  <div class="row">
                    <div class="col-4">
                      <div class="img-block">
                        <img :src="'http://passportapi/upload/products/' + item.product.photo[0].path" alt="">
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
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="product-price">
                    {{ item.product.price }} ₽
                  </div>
                </div>
                <div class="col-3">
                  <div class="add-to-cart-button">
                    <button @click="addToShoppingCart(item.product_id)">В корзину</button>
                  </div>
                  <div class="remove-button">
                    <button @click="removeFromWishList(item.id, index)">Убрать</button>
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
import ProductCard from '../Products/ProductCard'
import { ProductActions } from '../../../client/mixins/ProductActions'

export default {
  name: 'WishList',
  components: {
    ProductCard
  },
  mixins: [ProductActions],
  computed: {
    products () {
      return this.$store.getters.wishListItems
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
  .table-body {
    padding-top: 5%;
  }
  .add-to-cart-button button {
    width: 100%;
    height: 40px;
    padding: 7px 15px;
    background-color: white;
    color: #333;
    border: 2px solid #333;
    font-size: 14px;
    letter-spacing: 1px;
  }
  .add-to-cart-button button:hover {
    opacity: 0.8;
  }
  .remove-button button {
    width: 100%;
    height: 40px;
    padding: 7px 15px;
    background-color: #333;
    color: white;
    font-size: 14px;
    letter-spacing: 1px;
  }
</style>
