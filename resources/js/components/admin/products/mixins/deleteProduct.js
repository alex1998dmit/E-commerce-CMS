export const deleteProductMixin = {
    methods: {
        trashProduct(product_id) {
            this.$store.dispatch('trashProduct', id);
        }
    }
}
