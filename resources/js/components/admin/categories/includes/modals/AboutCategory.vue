<template>
    <div>
        <b-modal id="bv-modal-about-category" size="xl" title="Подробнее о категории" hide-footer>
            <div class="row">
                <div class="col">
                    <h3>{{ selected_category.name }}</h3>
                </div>
            </div>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col">Подкатегории</th>
                        <th scope="col">Количество товаров</th>
                        <th scope="col">Количество заказов</th>
                        <th scope="col">Создано</th>
                        <th scope="col">Обновленно</th>
                    </tr>
                </thead>
                <tbody class="categories_list" id="categories_list">
                    <tr>
                        <td>{{ selected_category.id }}</td>
                        <td>{{ selected_category.name }}</td>
                        <td>
                            <tr v-for="subcategory in selected_category.childs" :key="subcategory.id">
                                <td>{{ subcategory.name }}</td>
                            </tr>
                        </td>
                        <td>{{ selected_category.product.length }}</td>
                        <td>{{ countOrders(selected_category.product) }}</td>
                        <td>{{ selected_category.created_at }}</td>
                        <td>{{ selected_category.updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </b-modal>
    </div>
</template>
<script>
export default {
    mounted() {
        console.log(this.selected_category);
    },
    computed: {
        selected_category() {
            return this.$store.getters.selectedCategory;
        }
    },
    methods: {
        countOrders(products) {
            return products.reduce((acc, product) => {
                return acc + product.order.length;
            }, 0);
        }
    }
}
</script>
