<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-left">
                <h2>Удаленные категории</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Введите название категории ...">
            </div>
             <div class="col-md-6 text-right">
                <b-button variant="info" :to="{ name: 'categories' }">Категории</b-button>
            </div>
        </div>
        <br>
        <div class="category-table">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col">Восстановить</th>
                        <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody class="categories_list" id="categories_list">
                    <tr v-for="(category, index) in trashed_categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <b-button
                                variant="success"
                                size="sm"
                                v-on:click="restoreCategory(category.id, index)">
                                    Восстановить
                            </b-button>
                        </td>
                        <td>
                            <b-button
                                variant="danger"
                                size="sm"
                                v-on:click="deleteCategory(category.id, index)">
                                Полное удаление
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search_param: "",
        }
    },
    computed: {
        trashed_categories() {
            const categories = this.$store.getters.trashedCategories;
            if (this.search_param.length > 0) {
                return categories.filter((category) => category.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
            }
            return categories;
        }
    },
    mounted() {
        this.$store.dispatch('getTrashedCategories');
    },
    methods: {
        restoreCategory(category_id, category_index) {
            this.$store.dispatch('restoreCategory', { category_id, category_index });
        },
        deleteCategory(category_id, category_index) {
            if (confirm("Вы уверены что хотите полностью удалить, без возможности восстановления ?")) {
                this.$store.dispatch('deleteCategory', { category_id, category_index });
            }
        }
    }
}
</script>

