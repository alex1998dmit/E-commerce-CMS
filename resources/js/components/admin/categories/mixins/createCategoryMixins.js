export const createCategoryMixin = {
    data: () => {
        return {
            new_category: {
                name: "",
                parent_id: 0,
            }
        }
    },
    computed: {
        selected_category() {
            return this.$store.getters.selectedCategory;
        }
    },
    methods: {
        closeModal() {
            this.$bvModal.hide('bv-modal-create-category');
        },
        createCategory() {
            console.log(this.new_category);
            // this.$store.dispatch('createCategories', this.new_category);
        }
    },
    watch: {
        selected_category(category) {
            this.new_category.parent_id = category.id;
        }
    }
}
