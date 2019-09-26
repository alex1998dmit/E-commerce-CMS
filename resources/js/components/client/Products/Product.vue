<template>
<div class="product-info">
  <div class="row">
    <div class="col-md-6">
      <img v-bind:src="`${host}/upload/products/${product.photo[0].path}`" alt="">
    </div>
    <div class="col-md-6">
      <div class="about-product">
        <div class="row">
          <div class="col-md-12">
            <h1>
              {{ product.name }}
            </h1>
          </div>

          <div class="col-md-12">
            <div class="product-price" v-if="isLoggedIn">
              {{ product.price }} ₽
            </div>
          </div>
          <div class="col-md-12 buttons" v-if="isLoggedIn">
            <div class="col-md-12">
              <div class="button-add-to-cart">
                <button class="add-to-card-button" @click="addToShoppingCart(product.id)" v-if="!isAddedToCart(product.id)">В корзину</button>
              </div>
            </div>
            <div class="col-md-12">
              <div class="button-add-to-favourites">
                <button class="add-to-favourite-list" @click="addToWishList(product.id)" v-if="!isAddedToWishList(product.id)">В избранное</button>
              </div>
            </div>
<!--            <div class="col-md-12">-->
<!--              <div class="block-buy-product">-->
<!--                <button class="buy-now-product-button" @click="test">Купить сейчас</button>-->
<!--              </div>-->
<!--            </div>-->
          </div>
          <div class="col-md-12 unauthorized-product-button" v-else>
            <h5>Необходимо войти чтобы заказать товар</h5>
            <router-link class="login-button" :to="{ name: 'login' }">Войти</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="photos">
        <gallery :images="images" :index="index" @close="index = null"></gallery>
        <div
          class="image"
          v-for="(image, imageIndex) in images"
          :key="imageIndex"
          @click="index = imageIndex"
          :style="{ backgroundImage: `url(${host}/upload/products/${image})`, width: '300px', height: '200px' }"
        ></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="description-block">
        {{ product.description }}
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <div class="similar-products-block">
        <h5 class="similar-products-sign">Вам также могут понравиться:</h5>
        <div class="row">
          <ProductCard v-for="product in similar_products" :key="product.id" v-bind:product="product"></ProductCard>
        </div>
      </div>
    </div>
  </div>

</div>
</template>

<script>
import VueGallery from 'vue-gallery'
import ProductCard from './ProductCard'
import { ProductActions } from '../../../client/mixins/ProductActions'

export default {
  name: 'Product.vue',
  mixins: [ ProductActions ],
  data () {
    return {
      index: null
    }
  },
  mounted () {
    this.updateProduct()
  },
  components: {
    'gallery': VueGallery,
    ProductCard
  },
  computed: {
    product () {
      return this.$store.getters.products.selected
    },
    images () {
      return this.product.photo.map(photo => photo.path)
    },
    similar_products () {
      return this.$store.getters.products.similar
    },
    isLoggedIn () {
      return this.$store.getters.isLoggedIn
    },
    shoppingCartItems () {
      return this.$store.getters.shoppingCartItems
    },
    host () {
      return this.$store.getters.host
    }
  },
  methods: {
    updateProduct () {
      const PRODUCT_ID = this.$route.params.id
      this.$store.dispatch('getProduct', PRODUCT_ID)
      this.$store.dispatch('getSimilarProducts', PRODUCT_ID)
    }
  },
  watch: {
    '$route.params.id' () {
      this.updateProduct()
    }
  }
}
</script>

<style scoped>
  .image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 5px;
  }
  img {
    width: 300px;
    height: auto;
  }
  .about-product {
    padding-top: 50px;
  }
  .about-product h1 {
    font-size: 1.86667em;
  }
  .buttons {
    padding-top: 5%;
    padding-left: 0px;
  }
  .button-add-to-cart, .button-add-to-favourites {
    padding-bottom: 3%;
  }
  .product-price {
    padding-top: 2%;
  }
  .add-to-card-button {
    width: 50%;
    height: 40px;
    padding: 7px 15px;
    background-color: transparent;
    color: #333;
    border: 2px solid #333;
    font-size: 14px;
    letter-spacing: 1px;
  }
  .add-to-card-button:hover {
    opacity: 0.8;
    background-color: transparent;
    color: #333;
    border: 2px solid #333;
  }
  .buy-now-product-button {
    width: 50%;
    height: 40px;
    padding: 7px 15px;
    background-color: #333;
    color: white;
    border: 2px solid #333;
    font-size: 14px;
    letter-spacing: 1px;
  }
  .buy-now-product-button:hover {
    opacity: 0.8;
  }
  .description-block {
    padding-top: 5%;
    font-size: 13px;
    color: #333;
  }
  .similar-products-sign {
    font-family: "Times New Roman",Times,serif;
    font-weight: 400;
    font-style: normal;
    text-rendering: optimizeLegibility;
    margin: 0 0 1em;
    line-height: 1.4;
    color: #333;
  }
  .photos {
   padding-top: 10%;
  }
  .login-button {
    color: #333;
    text-decoration: none;
  }
  .login-button:hover {
    opacity: 0.8;
  }
  .add-to-favourite-list {
    width: 50%;
    height: 40px;
    padding: 7px 15px;
    background-color: white;
    color: #333;
    border: 2px solid #333;
    font-size: 14px;
    letter-spacing: 1px;
  }
  .add-to-favourite-list:hover {
    opacity: 0.8;
  }

</style>
