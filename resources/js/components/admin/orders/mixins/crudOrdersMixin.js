export const crudOrdersMixin = {
    methods: {
        // openModal
        openAboutOrder(order) {
            this.$store.commit("SET_SELECTED_ORDER", order);
            this.$bvModal.show("about-order-modal");
        }
    },
}
