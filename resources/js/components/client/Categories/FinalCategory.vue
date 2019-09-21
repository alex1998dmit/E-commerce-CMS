<template>
  <div class="products-content">
    <div class="row">
      <!-- Верхний путь до категории     -->

      <!-- Фильтр     -->
      <div class="col-md-9">
        <h4>{{ category.name }}</h4>
      </div>
      <div class="col-md-3">
        <div class="product-filter">
          <label for=""></label>
          <select name="" id="" v-model="sortedBy" @change="updateProducts(1)">
            <option value="created_at">По новизне</option>
            <option value="alphabet">По алфавиту</option>
            <option value="price">По цене</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- SubCategoryName     -->
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
<!--            <h4>{{ category.name }}</h4>-->
          </div>
        </div>
        <div class="row">
          <ProductCard v-for="product in products.items" :key="product.id" v-bind:product="product"></ProductCard>
        </div>
        <div class="row">
          <div class="col-md-12">
            <Pager
              routerName="categoryProducts"
              :frame=8
              :pageCount="products.pageCount"
              @updateItems="updateProducts"
            ></Pager>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ProductCard from '../Products/ProductCard'
import Pager from '../Includes/Pager'

export default {
  name: 'FinalCategory',
  components: {
    ProductCard, Pager
  },
  data () {
    return {
      sortedBy: 'created_at',
      page: 1
    }
  },
  computed: {
    products () {
      return this.$store.getters.products
    },
    category () {
      return this.$store.getters.selectedCategory
    }
  },
  mounted () {
    this.updateProducts()
  },
  methods: {
    changePage (newPage) {
      this.updateProducts(newPage)
      this.$router.push({name: 'categoryProducts', query: {page: newPage}})
    },
    updateProducts (newPage = 1) {
      const CATEGORY_ID = this.$route.params.id
      this.$store.dispatch('getCategory', CATEGORY_ID)
      this.$store.dispatch('getCategoryWithProduct', {categoryId: CATEGORY_ID, page: newPage, sortedBy: this.sortedBy})
    }
  }
}
</script>

<style scoped>

</style>
