<template>
    <b-modal id="update-product-at-order" title="Обновить продукт" hide-footer>
        <div class="col">
            <div class="row">
                <div class="col">
                    <p>Текущий продукт: {{ order.product.name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по названию продукта ...">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <ul>
                        <li v-for="(product, product_index) in products" :key="product.id">{{ product.name }}
                            <b-button
                                size="sm"
                                variant="success"
                                @click="updateProduct(product.id, product_index); closeModal()">
                                    Выбрать
                            </b-button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </b-modal>

</template>

<script>
export default {
    data() {
        return {
            search_param: null,
        }
    },
    computed: {
        order() {
            return this.$store.getters.selectedOrder;
        },
        orders() {
            return this.$store.getters.orders;
        },
        products: {
            get() {
                if (this.search_param) {
                    return this.$store.getters.products.filter((product) => product.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
                }
                return [];
            }
        }
    },
    mounted() {
        this.$store.dispatch('getProducts');
    },
    methods: {
        closeModal() {
            this.$bvModal.hide("update-product-at-order");
        },
        updateProduct(product_id, product_index) {
            const order_id = this.order.id;
            const product = this.products[product_index];
            this.order.product_id = product_id;
            this.order.product = product;
            this.$store.dispatch('updateOrder', { order_id, order: this.order });
        }
    },
}
</script>

