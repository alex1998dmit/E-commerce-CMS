export const crudDiscountMixin= {
    methods: {
        // openModal
        openCreateModal() {
            this.$bvModal.show("create-discount-modal");
        },
        openEditModal(discount) {
            this.$store.commit("SET_SELECTED_DISCOUNT", discount);
            this.$bvModal.show("create-discount");
        },
        openAboutModal(discount, index) {
            this.$store.commit("SET_SELECTED_DISCOUNT", discount);
            this.$bvModal.show("about-discount-modal");
        },

        // logic
        createDiscount() {

        },
        updateDiscount(discount_id, discount) {
            this.$store.dispatch('updateDiscount', { discount, discount_id });
        },
        removeDiscount() {

        },
        updateUserDiscount(){
            this.$store.dispatch('')
        },
    },
}
