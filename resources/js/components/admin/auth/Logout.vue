<template>

</template>

<script>
export default {
    created(){
        this.$store.dispatch('destroyToken')
        .then(resp => {
            this.$router.push({ name: 'login' })
        })
    },
}
</script>

