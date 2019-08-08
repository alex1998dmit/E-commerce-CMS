<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
                <b-button v-if="orderNotifications.length > 0 && isLoggedIn" variant="warning" @click="openNotificationsForm">Уведомления: {{ orderNotifications.length }}</b-button>
            </li>
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
        <HeadMenu></HeadMenu>

    </div>
</template>
<script>
import HeadMenu from './Notifications';

export default {
    components: {
        HeadMenu
    },
    created() {
        Echo.channel('orders')
            .listen('NewOrder', (e) => {
                console.log(e.order);
                this.$store.commit('ADD_ORDER_NOTIFICATION', e.order);
            })
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters.isLoggedIn;
        },
        currentUser() {
            return this.$store.getters.currentUser;
        },
        orderNotifications() {
            return this.$store.getters.orderNotifications;
        },
    },
    methods: {
        openNotificationsForm() {
            this.$bvModal.show('orders-notifications');
        }
    }
}
</script>
