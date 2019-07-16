export const createCategoryMixin = {
    data: function () {
        return {
            new_category: {
                name: "",
                parent_id: 0
            },
        }
    },
    methods: {
        openModalWindowForCategoryCreate() {
            this.$bvModal.show('bv-modal-create-category');
        },
        changeParentCategory(category_id) {
            this.openModalWindowForCategoryCreate();
            this.$store.dispatch('addNewCategoryParam', { "parent_id" : category_id });
        },
        addSubcategory() {
            this.$store.dispatch('addNewCategoryParam', { "name" : this.new_category.name });
            this.$store.dispatch('createCategories');
            this.$bvModal.hide('bv-modal-create-category');
        },
        removeCategory(category) {
            if (confirm("Вы уверены что хотите удалить категорию ?")) {
                this.$store.dispatch('removeCategory', category);
            }
        }
    }
}
