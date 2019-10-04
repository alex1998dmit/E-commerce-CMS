<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
<!--                <a class="nav-link" v-if="orderNotifications.length > 0 && isLoggedIn" @click="openNotificationsForm">-->
<!--                    <i class="fa fa-bell" aria-hidden="true"></i>-->
<!--                    <div class="notifications-amount">-->
<!--                        {{ orderNotifications.length }}-->
<!--                    </div>-->
<!--                </a>-->
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light" @click="redirectToAClientPage">
                    <i class="fa fa-shopping-basket" aria-hidden="true">
                        <span class="head-nav-icon-sign">Магазин</span>
                    </i>
                </a>
            </li>
            <li class="nav-item">
                <router-link class="nav-link btn btn-light" v-if="!isLoggedIn" :to="{ name: 'login' }">
                     <i class="fa fa-sign-in" aria-hidden="true">
                        <span class="head-nav-icon-sign">Вход</span>
                    </i>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link btn btn-light" v-if="!isLoggedIn" :to="{ name: 'register' }">
                    <i class="fa fa-user-plus" aria-hidden="true">
                        <span class="head-nav-icon-sign">Регистрация</span>
                    </i>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" v-if="isLoggedIn" :to="{ name: 'logout' }">
                    <i class="fa fa-user" aria-hidden="true">
                        <span class="head-nav-icon-sign">{{ currentUser.name }}</span>
                    </i>
                </router-link>
            </li>
            <li class="nav-item active">
                <router-link class="nav-link" v-if="isLoggedIn" :to="{ name: 'logout' }">
                    <i class="fa fa-sign-out logout-button" aria-hidden="true">
                        <span class="head-nav-icon-sign logout-button">Выйти</span>
                    </i>
                </router-link>
            </li>
        </ul>
<!--        <Notifications></Notifications>-->
    </div>
</template>
<script>
// import Notifications from './Notifications';

export default {
    // components: {
    //     Notifications
    // },
    created() {
        if (this.isLoggedIn) {
            // Echo.channel('orders')
            //     .listen('NewOrder', (e) => {
            //         const order_status_index = this.$store.getters.orderStatuses.map(status => status.id).indexOf(e.order.status_id)
            //         this.$store.commit('ADD_ORDER_NOTIFICATION', e.order)
            //         this.$store.commit('ADD_ORDER', e.order)
            //         this.$store.commit('ADD_ORDER_TO_ORDER_STATUS', order_status_index)
            //         this.$store.commit('ADD_UNCHECKED_ORDER_TO_ORDER_STATUS', order_status_index)
            //     })
            //     .listen('UpdateOrder', (e) => {
            //         const status_index = this.$store.getters.orderStatuses.map((orderStatus) => orderStatus.id).indexOf(status_id)
            //         const order_id = e.order.id
            //         const status_id = e.order.status_id
            //         // this.$store.commit('ADD_ORDER_TO_ORDER_STATUS', order_status_index)
            //         this.$store.commit('ADD_UNCHECKED_ORDER_TO_ORDER_STATUS', status_index)
            //     })
        }
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
        redirectToAClientPage () {
            window.location.href = `${process.env.MIX_APP_HOST_NAME}`
        },
        // openNotificationsForm() {
        //     this.$bvModal.show('orders-notifications');
        // }
    }
}
</script>

<style scoped>
 .head-nav-icon-sign {
    font-size: 13px;
    padding-left: 5%;
    font-family: Arial, Helvetica, Verdana, sans-serif;
 }
.logout-button {
    color: red;
 }
 .notifications-amount {
    display: inline-block;
    font-size: 0.6em;
    width: 15px;
    height: 15px;
    background-color: red;
    border-radius: 50px;
    padding-left: 4px;
    padding-bottom: -2px;
    color: white;
    position: relative;
    left: -10px;
    top: 2px;
 }
</style>
