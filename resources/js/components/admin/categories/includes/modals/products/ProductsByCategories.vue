<template>
    <b-modal id="bv-modal-products-with-category" size="xl" hide-footer title="Продукты категории">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <input type="text" class="form-control" v-model="search_param" placeholder="Поиск по продуктам категории">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Название</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Дата создания</th>
                                <th scope="col">Дата обновления</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in filteredProducts"  :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>{{ product.created_at }}</td>
                                    <td>{{ product.updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    data: () => {
        return {
            productsByCategory: [],
            filteredProducts: [],
            search_param: "",
        }
    },
    computed: {
        products() {
            return this.$store.getters.products;
        },
        selected_category() {
            return this.$store.getters.selectedCategory;
        }
    },
    methods: {
        updateProducts(category_id) {
            this.productsByCategory = this.getProductByCategory(category_id);
            this.filteredProducts = this.productsByCategory;
        },
        getProductByCategory(category_id) {
            let products = this.products;
            return products.filter(product => product.category_id === category_id);
        }
    },
    watch: {
        selected_category(category) {
            this.updateProducts(category.id);
        },
        search_param(param) {
            this.filteredProducts = param.length > 0 ? this.productsByCategory.filter((product) => product.name.toLowerCase().includes(param.toLocaleLowerCase())) : this.productsByCategory;
        }
    }
}
</script>


