export const crudOrdersMixin = {
    methods: {
        // openModal
        openAboutOrder(order) {
            this.$store.commit("SET_SELECTED_ORDER", order);
            this.$bvModal.show("about-order-modal");
        },
        openChangeOrder(order) {
            this.$store.commit("SET_SELECTED_ORDER", order);
            this.$bvModal.show("change-order-modal");
        },
        changeProduct() {
            this.$bvModal.show("update-product-at-order");
        },
        changeUser() {
            this.$bvModal.show("update-user-at-order");
        },
        changeOrderStatus(order) {
            this.$store.commit("SET_SELECTED_ORDER", order);
            this.$bvModal.show("change-status-at-order");
        },
        // logic
        updateOrder(order_id, order) {
            this.$store.dispatch("updateOrder", { order_id, order });
        },
        checkNotification(notification_id) {
            const notifications = this.$store.getters.orderNotifications;
            const index = notifications.map((notification) => notification.id).indexOf(notification_id);
            this.$store.dispatch('checkOrderNotification', { index, notification_id });
        },
    },
}
