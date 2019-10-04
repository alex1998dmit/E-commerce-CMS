export const crudOrdersMixin = {
    methods: {
        // openModal
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
        // logic
        openAboutOrder (order) {
            this.$router.push({ name: 'OrderAbout', params: { id: order.id }})
        },
        changeOrderStatus (event, order_id, order_index) {
            const status_id = event.target.value
            this.$store.dispatch('updateOrder', { order_id, index: order_index, order: { status_id }})
                .then(resp => {
                    this.$store.dispatch('getOrderStatuses')
                    // this.$store.commit('ADD_UNCHECKED_ORDER_TO_ORDER_STATUS', status_id)
                })
        },
        checkNotification (order, order_index) {
            const order_id = order.id
            const status_id = order.status_id
            const status_index = this.$store.getters.orderStatuses.map((orderStatus) => orderStatus.id).indexOf(status_id)
            const notification_index = this.$store.getters.orderNotifications.map((notification) => notification.id).indexOf(order_id)
            this.$store.dispatch('updateOrder', { order_id, index: order_index, order: { is_checked: true }})
                .then(resp => {
                    this.$store.commit('REMOVE_UNCHECKED_ORDER_FROM_ORDER_STATUS', status_index)
                    this.$store.commit('REMOVE_ORDER_NOTIFICATION', notification_index)
                })
        },
        uncheckedNotification (order_id, order_index) {
            this.$store.dispatch('updateOrder', { order_id, index: order_index, order: { is_checked: false }})
        },
        trashOrder (order_id, order_index) {
            if (confirm("Подтвердите удаление заказа")) {
                this.$store.dispatch('trashOrder', { order_id, order_index })
            }
        }
    },
}
