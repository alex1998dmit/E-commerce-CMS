export const crudCategoriesMixin = {
    methods: {
        setCurrentCategory(category) {
            if (category) {
                this.$store.commit('SET_CURRENT_CATEGORY', category);
            }
        },
        // open modals
        createRootCategory() {
            this.$bvModal.show("bv-modal-add-root-category");
        },
        createCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-create-category');
        },
        changeCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-change-category');
        },
        aboutCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-about-category');
        },
        // methods
        trashCategory(category) {
            if (confirm("Вы уверены что хотите удалить категорию ?")) {
                this.$store.dispatch('trashCategory', category);
            }
       },
    },
}
