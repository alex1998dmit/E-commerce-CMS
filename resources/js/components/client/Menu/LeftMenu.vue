<template>
  <div class="nav-left-menu">
    <ul>
      <li class="nav-left-menu-item">
        <a href="" class="nav-link">Меню</a>
      </li>
      <li class="nav-left-menu-item" v-for="category in main_categories" :key="category.id">
        <router-link class="nav-link" :to="{ name: 'category', params: {id: category.id}}">
          {{ category.name }}
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'LeftMenu',
  computed: {
    main_categories () {
      return this.$store.getters.categories.filter(category => category.parent_id === 0)
    }
  },
  mounted () {
    this.$store.dispatch('getCategories')
  }
}
</script>

<style scoped>

</style>
