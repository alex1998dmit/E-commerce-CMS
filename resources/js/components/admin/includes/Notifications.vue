<template>
    <b-modal id="orders-notifications" hide-header hide-footer>
        <div class="row">
            <div class="col">
                <h5>Уведомления</h5>
            </div>
            <div class="col text-right">
                <a href="#" class="checked-all-link" @click="checkAllNotifications();">Отметить все как просмотренные</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row today-notifacation-row">
                    <div class="col today-notifications-sign">
                        <p>Сегодня</p>
                    </div>
                </div>
                <div class="notification" v-for="notification in today_notifications" :key="notification.id">
                    <div class="row">
                        <div class="col-3">
                            <img v-for ="item in notification.order_items" :key="item.id" :src="`${window.location.hostname}/upload/products/${item.product.photo[0].path}`" alt="" width="33px" height="auto">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="order-email">
                                        {{ notification.user.email }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-productname" v-for="item in notification.order_items" :key="item.id">
                                        {{ item.product.name }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-sum">
                                        {{ notification.sum }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 button-checked-block">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn-view" @click="aboutOrder(notification.id)">Подробнее</button>
                                </div>
                                <div class="col-12">
                                    <button class="btn-check" @click="checkNotification(notification.id)">Просмотрено</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="row today-notifacation-row">
                    <div class="col today-notifications-sign">
                        <p>Предыдущий месяц</p>
                    </div>
                </div>
                <div class="notification" v-for="notification in last_week_notifications" :key="notification.id">
                    <div class="row">
                        <div class="col-3">
                            <img v-for ="item in notification.order_items" :key="item.id" :src="`${window.location.hostname}/upload/products/${item.product.photo[0].path}`" alt="" width="100px" height="auto">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="order-email">
                                        {{ notification.user.email }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-productname" v-for="item in notification.order_items" :key="item.id">
                                        {{ item.product.name }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-sum">
                                        {{ notification.sum }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 button-checked-block text-center">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn-view" @click="aboutOrder(notification.id)">Подробнее</button>
                                </div>
                                <div class="col-12">
                                    <button class="btn-check" @click="checkNotification(notification.id)">Просмотрено</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            isChecked: []
        }
    },
    computed: {
        notifications() {
            return this.$store.getters.orderNotifications;
        },
        today_notifications() {
            return this.notifications.filter(notification => {
                const cur_date = new Date().getDate() + new Date().getMonth();
                const not_date = new Date(notification.created_at).getDate() + new Date(notification.created_at).getMonth();
                return cur_date === not_date;
            });
        },
        last_week_notifications() {
            return this.notifications.filter(notification => {
                const cur_date = new Date().getDate() + new Date().getMonth();
                const not_date = new Date(notification.created_at).getDate() + new Date(notification.created_at).getMonth();
                return cur_date !== not_date;
            });
        },
    },
    methods: {
        closeModal() {
            this.$bvModal.hide('orders-notifications');
        },
        checkNotification(notification_id) {
            const index = this.notifications.map((notification) => notification.id).indexOf(notification_id);
            this.$store.dispatch('checkOrderNotification', { index, notification_id });
        },
        checkAllNotifications() {
            this.$store.dispatch('checkAllNotification')
        },
        setSelectedOrder(order) {
            this.$store.commit("SET_SELECTED_ORDER", order)
        },
        aboutOrder(id) {
            this.$router.push({ name: "OrderAbout", params: { id }})
            this.closeModal()
        }
    },
}
</script>

<style scoped>
    .order-email, .order-productname, .order-sum {
        font-size: 0.9em;
    }
    .btn-check {
        border: 0px;
        border-radius: 0px;
        border-bottom: 1px solid lightgrey;
        font-size: 0.8em;
    }
    .btn-check:hover {
        border-color: black;
    }
    .btn-view {
        border: 0px;
        border-radius: 0px;
        border-bottom: 1px solid lightblue;
        font-size: 0.8em;
    }
    .btn-view:hover {
        border-color: blue;
    }
</style>
