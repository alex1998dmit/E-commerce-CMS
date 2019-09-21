<template>
  <div class="search-results">
    <div class="row">
      <div class="col-md-12">
        <h2 class="search-param-sign">Результаты поиска по запросу "{{ this.search_param }}"</h2>
      </div>
    </div>
    <div class="row">
      <ProductCard v-for="product in products.items" :key="product.id" v-bind:product="product"></ProductCard>
    </div>
  </div>
</template>

<script>
import ProductCard from '../../Products/ProductCard'

export default {
  name: 'Results',
  components: {
    ProductCard
  },
  computed: {
    products () {
      return this.$store.getters.products
    },
    search_param () {
      return this.$store.getters.searchParam
    }
  }
}
</script>

<style scoped>
  .search-param-sign {
    font-size: 1.53333em;
    font-family: "Times New Roman",Times,serif;
    font-weight: 400;
    font-style: normal;
    text-rendering: optimizeLegibility;
    margin: 0 0 1em;
    line-height: 1.4;
    color: #333;
  }
</style>
