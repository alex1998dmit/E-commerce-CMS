<template>
    <div class="row">
        <div class="col" v-if="isAdmin()">
            <h2>Главная</h2>
            <h5>Добро пожаловать</h5>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        currentUser() {
            return this.$store.getters.currentUser;
        }
    },
    methods: {
        isAdmin() {
            return this.currentUser.role.filter(role => role.name == 'operator' || role.name == 'admin').length > 0
        }
    }
}
</script>
