<template>
  <div class="pagination-block pagination-sm">
    <ul class="pagination">
      <li :class="{ 'page-item': true, disabled: page <= 1 }">
        <a class="page-link" href="#" tabindex="-1" @click.prevent="previous">Назад</a>
      </li>
      <li v-for="p in pages" :class="{ 'page-item': true, active: p === page }" :key="p">
        <a href="" @click.prevent="select($event, p)" class="page-link">{{ p }}</a>
      </li>
      <li :class="{ 'page-item': true, disabled: page === pageCount }">
        <a class="page-link" href="#" @click.prevent="next">Вперед</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Pager',
  props: {
    frame: {
      type: Number,
      default: 10
    },
    pageCount: Number,
    routerName: String
  },
  computed: {
    pages () {
      const { min, max } = this.getPagerLimits(this.pageCount, this.page)
      const pa = []
      for (let i = min; i <= max; i++) {
        pa.push(i)
      }
      return pa
    },
    page () {
      if (this.$route.query.page) {
        return Number(this.$route.query.page)
      }
      return Number(this.$store.getters.products.page)
    }
  },
  methods: {
    getPagerLimits (pageCount, page) {
      if (pageCount <= this.frame) {
        return { min: 1, max: pageCount }
      }
      const f1 = Math.floor(this.frame / 2)
      const f2 = pageCount - f1 + 1
      let min = 1
      if (f1 < page && page < f2) min = page - f1
      if (page >= f2) min = f2 - f1
      let max = min + this.frame - 1
      return { min, max }
    },
    select (event, page) {
      this.changePage(page)
    },
    previous (event) {
      this.changePage(this.page - 1)
    },
    next (event) {
      this.changePage(this.page + 1)
    },
    changePage (newPage) {
      this.$emit('updateItems', newPage)
      this.$router.push({name: this.routerName, query: {page: newPage}})
    }
  }
}
</script>

