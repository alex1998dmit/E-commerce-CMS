<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <b-button v-b-modal.modal-xl variant="primary">Открыть дерево категорий</b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-">
                <ul id="level-0">

                </ul>
            </div>
        </div>
        <div class="category-table">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Название</th>
                        <th scope="col">Подкатегории</th>
                        <th scope="col">Количество товаров</th>
                        <th scope="col">Количество заказов</th>
                        <th scope="col">Удалить</th>
                        <th scope="col">Редактировать</th>
                    </tr>
                </thead>
                <tbody class="categories_list" id="categories_list">
                    <!-- @foreach ($allCategories  as $category) -->
                    <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <tr v-for="subcategory in category.childs" :key="subcategory.id">
                                <td>{{ subcategory.name }}</td>
                            </tr>
                        </td>
                        <td>В разработке</td>
                        <td>В разработке</td>
                        <td>
                            <a href="#"
                                class="btn btn-xs btn-danger"
                                v-on:click="removeCategory(category)">
                                    Удалить
                            </a>
                        </td>
                        <td>
                            <a href="#"
                                class="btn btn-xs btn-warning"
                                v-on:click="$bvModal.show('bv-modal-edit_category'); editCategory(category)">
                                    Изменить
                            </a>
                        </td>
                        <!-- <td><a href="{{ route('category.trash', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">Trash</a></td> -->
                        <!-- <td><a href="" class="btn btn-xs btn-info">Добавить продукт</a></td> -->
                    </tr>
                </tbody>
            </table>
            <b-modal id="bv-modal-edit_category" hide-footer title="Редактировать категорию">
                <div class="form-group">
                    <input type="text" class="form-control" :placeholder="this.updating_category.name" v-model="updating_category.name">
                </div>
                <b-button variant="outline-success" block @click="$bvModal.hide('bv-modal-edit_category'); updateCategory()">Обновить</b-button>
                <b-button variant="outline-danger" block @click="$bvModal.hide('bv-modal-edit_category')">Close Me</b-button>
            </b-modal>
        </div>
        <treeCategories v-if="categories.length > 0" :categories="this.categories"></treeCategories>
    </div>
</template>
<script>
import treeCategories from './includes/treeCategories';
import { mapGetters } from 'vuex'

export default {
    components: {
        treeCategories,
    },
    data: () => {
        return {
            updating_category: {
                id: 0,
                name: "",
                parent_id: 0
            },
        }
    },
    mounted() {
        this.$store.dispatch('getCategories');
    },
    computed: {
        ...mapGetters(['categories'])
    },
    methods: {
        createCategory() {
            this.$store.dispatch('createCategories', this.new_category_data);
        },
        removeCategory(category) {
            if (confirm("Вы уверены что хотите удалить категорию ?")) {
                this.$store.dispatch('removeCategory', category);
            }
        },
        editCategory(category) {
            this.updating_category.id = category.id;
            this.updating_category.name = category.name;
            this.updating_category.parent_id = category.parent_id;
        },
        updateCategory() {
            this.$store.dispatch('updateCategory', this.updating_category);
        }
    }
}
</script>
