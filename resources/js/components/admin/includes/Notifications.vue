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
                <div class="notification" v-for="notification in today_notifications" :key="notification.id" v-on:click="aboutOrder($event, notification.id); checkNotification(notification.id); closeModal();">
                    <div class="row">
                        <div class="col-3">
                            <img :src="`http://passportapi/upload/products/${notification.product.photo[0].path}`" alt="" width="100px" height="auto">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    {{ notification.user.email }}
                                </div>
                                <div class="col-12">
                                    {{ notification.product.name }}
                                </div>
                                <div class="col-12">
                                    {{ notification.amount }}
                                </div>
                                <div class="col-12">
                                    {{ notification.sum }}
                                </div>
                            </div>
                        </div>
                        <div class="col-3 button-checked-block">
                            <b-button size="sm" variant="light" @click="checkNotification(notification.id)">Просмотрено</b-button>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="row today-notifacation-row">
                    <div class="col today-notifications-sign">
                        <p>Предыдущий месяц</p>
                    </div>
                </div>
                <div class="notification" v-for="notification in last_week_notifications" :key="notification.id" v-on:click="aboutOrder($event, notification.id); checkNotification(notification.id); closeModal();">
                    <div class="row">
                        <div class="col-3">
                            <img :src="`http://passportapi/upload/products/${notification.product.photo[0].path}`" alt="" width="100px" height="auto">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    {{ notification.user.email }}
                                </div>
                                <div class="col-12">
                                    {{ notification.product.name }}
                                </div>
                                <div class="col-12">
                                    {{ notification.amount }}
                                </div>
                                <div class="col-12">
                                    {{ notification.sum }}
                                </div>
                            </div>
                        </div>
                        <div class="col-3 button-checked-block">
                            <b-button size="sm" variant="light" @click="checkNotification(notification.id)">Просмотрено</b-button>
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
            this.$store.dispatch('checkAllNotification');
        },
        setSelectedOrder(order) {
            this.$store.commit("SET_SELECTED_ORDER", order);
        },
        aboutOrder(event, id) {
            console.log('aaaa');
            if (event.target.tagName === 'DIV') {
                console.log(id);
                this.$router.push({ name: "OrderAbout", params: { id }});
            }
        }
    },
}
</script>

<style>

</style>
