export const crudDiscountMixin= {
    methods: {
        // openModal
        openCreateModal() {
            this.$bvModal.show("create-discount-modal");
        },
        openEditModal() {

        },
        openAboutModal(discount, index) {
            this.$store.commit("SET_SELECTED_DISCOUNT", discount);
            this.$bvModal.show("about-discount-modal");
        },

        // logic
        createDiscount() {

        },
        updateDiscount() {

        },
        removeDiscount() {

        }
    },
}
