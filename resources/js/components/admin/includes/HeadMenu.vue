<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <router-link class="nav-link btn btn-light" v-if="!isLoggedIn" :to="{ name: 'login' }">Вход</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link btn btn-light" v-if="!isLoggedIn" :to="{ name: 'register' }">Регистрация</router-link>
            </li>

            <li class="nav-item active">
                <router-link class="nav-link" v-if="isLoggedIn" :to="{ name: 'logout' }">{{ currentUser.name }}</router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link btn btn-light" v-if="isLoggedIn" :to="{ name: 'logout' }">Выйти</router-link>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    mounted() {
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },
        currentUser() {
            return this.$store.getters.currentUser;
        }
    },
}
</script>
