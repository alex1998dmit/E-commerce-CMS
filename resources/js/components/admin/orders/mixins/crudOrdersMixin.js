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
        openAboutOrder (order_id) {
            this.$router.push({ name: 'OrderAbout', params: { id: order_id }})
        },
        changeOrderStatus (event, order_id, order_index) {
            const status_id = event.target.value
            this.$store.dispatch('updateOrder', { order_id, index: order_index, order: { status_id }})
        },
        checkNotification (order_id, order_index) {
            this.$store.dispatch('updateOrder', { order_id, index: order_index, order: { is_checked: true }})
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
