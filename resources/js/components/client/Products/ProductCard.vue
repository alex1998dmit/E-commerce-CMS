<template>
    <div class="col-md-4">
      <div class="product-card">
        <div class="image" @click="openProduct">
          <img v-bind:src="`${host}/upload/products/${product.photo[0].path}`" alt="">
        </div>
        <div class="product-info-card">
          <div class="description text-left" @click="openProduct">
            <a href="">{{ product.name }}</a>
          </div>
          <div class="price text-left">
                <span class="product-menu-price">
                  {{ product.price }}₽
                </span>
          </div>
          <div class="product-buttons text-left">
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { ProductActions } from '../../../client/mixins/ProductActions'

export default {
  name: 'ProductCard',
  mixins: [ProductActions],
  props: {
    product: Object
  },
  computed: {
    host () {
        return this.$store.getters.host
    }
  },
  methods: {
    openProduct () {
      this.$router.push({ name: 'product', params: { id: this.product.id } })
    },
    addToShoppingList (productId) {
      return productId
    },
    addToWishList (productId) {
      return productId
    }
  }
}
</script>

<style scoped>
  .product-buttons {
    padding-top: 7%;
  }
  .product-card:hover {
    opacity: 0.8;
  }
  .add-to-shopping-card-button {
    border-radius: 5px;
    background-color: #333;
    border: 0;
    padding: 6px;
    font-style: normal;
    font-weight: 400;
    font-size: 13px;
    color: white;
    line-height: 1.6;
  }
  .button-like {
    border: 0;
    background-color: transparent;
    text-decoration: none;
    padding: 1rem;
    position: relative;
    vertical-align: middle;
    text-align: center;
    display: inline-block;
    border-radius: 3rem;
    color: #8a8a8a;
    transition: all ease 0.4s;
  }

  .button-like span {
    margin-left: 0.5rem;
  }

  .button-like .fa,
  .button-like span {
    transition: all ease 0.4s;
  }

  .button-like:focus {
    background-color: transparent;
  }

  .button-like:focus .fa,
  .button-like:focus span {
    color: #8a8a8a;
  }

  .button-like:hover {
    border-color: #cc4b37;
    background-color: transparent;
  }

  .button-like:hover .fa,
  .button-like:hover span {
    color: #cc4b37;
  }

  .liked {
    background-color: #cc4b37;
    border-color: #cc4b37;
  }

  .liked .fa,
  .liked span {
    color: #fefefe;
  }

  .liked:focus {
    background-color: #cc4b37;
  }

  .liked:focus .fa,
  .liked:focus span {
    color: #fefefe;
  }

  .liked:hover {
    background-color: #cc4b37;
    border-color: #cc4b37;
  }

  .liked:hover .fa,
  .liked:hover span {
    color: #fefefe;
  }
  .added-to-shopping-card-button {
    border-radius: 5px;
    background: white;
    color: #333;
    border: 1px solid #333;
    padding: 6px;
    font-style: normal;
    font-weight: 400;
    font-size: 13px;
    line-height: 1.6;
  }
  .added-to-shopping-card-button:hover {
    background: #f4f4f4;
  }

</style>
