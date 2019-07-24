export const deleteCategoriesMixin = {
    methods: {
        deleteCategory(category) {
            console.log(category.id);
            if (confirm("Вы уверены что хотите удалить категорию ?")) {
                this.$store.dispatch('removeCategory', category);
            }
       }
    },
}
