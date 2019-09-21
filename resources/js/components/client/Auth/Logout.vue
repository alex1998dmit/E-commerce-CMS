<template>
  <div class=""></div>
</template>
<script>
export default {
  name: 'Logout',
  created () {
    this.$store.dispatch('destroyToken')
      .then(resp => {
        this.$router.push({ name: 'login' })
      })
  }
}
</script>

<style scoped>

</style>
