<template>
  <div class="products-content">
    <div class="row">
      <!--   Список продуктов   -->
    </div>
      <!-- SubCategoryName     -->
    <div class="subcategory-with-product" v-for="subcategory in subcategories.final_sub_categories" :key="subcategory.id">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <h4>
                <router-link :to="{ name: 'categoryProducts', params: { id: subcategory.id }}">
                  {{ subcategory.name }}
                </router-link>
              </h4>
            </div>
          </div>
          <!--  Products      -->
            <div class="row">
              <ProductCard v-for="(product, index) in subcategory.products" v-if="index <= 2" :key="product.id" v-bind:product="product"></ProductCard>
            </div>
          <!-- Подробнее кнопка         -->
          <div class="show-all-products">
            <div class="row">
              <div class="col-md-12 text-center">
                <button class="btn show-all-products-button" @click="openAllProducts(subcategory.id)">
                  Все товары
                </button>
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

export default {
  name: 'Category',
  components: {
    ProductCard
  },
  computed: {
    subcategories () {
      return this.$store.getters.selectedCategory
    }
  },
  mounted () {
    const CATEGORY_ID = this.$route.params.id
    this.$store.dispatch('getCategory', CATEGORY_ID)
  },
  methods: {
    openAllProducts (id) {
      this.$router.push({name: 'categoryProducts', params: { id }})
    }
  },
  watch: {
    '$route' (new_val = null) {
      this.$store.dispatch('getCategory', this.$route.params.id)
    }
  }
}
</script>

<style scoped>
  h4 a {
    color: #333;
    text-decoration: none;
  }
</style>
