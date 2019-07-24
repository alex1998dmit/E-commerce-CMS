export const crudCategoriesMixin = {
    methods: {
        setCurrentCategory(category) {
            if (category) {
                this.$store.commit('SET_CURRENT_CATEGORY', category);
            }
        },
        // open modals
        createCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-create-category');
        },
        changeCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-change-category');
        },
    },
}
