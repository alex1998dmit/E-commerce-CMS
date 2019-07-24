export const createCategoryMixin = {
    data: function () {
        return {
            new_category: {
                name: "",
                parent_id: 0
            },
            updating_category: {
                id: 0,
                name: "",
                parent_id: 0,
            },
            open_form_with_products: false,
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
        // removeCategory(category) {
        //     if (confirm("Вы уверены что хотите удалить категорию ?")) {
        //         this.$store.dispatch('removeCategory', category);
        //     }
        // },
        changeCategory(category) {
            this.$data.updating_category.id = category.id;
            this.$data.updating_category.name = category.name;
            this.$data.updating_category.parent_id = category.parent_id;
            this.$bvModal.show('bv-modal-change-category');
        },
        updateCategory() {
            console.log('start udpate');
            this.$store.dispatch('updateCategory', this.updating_category);
        },
    },
}
