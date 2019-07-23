<template>
    <div>
        <div class="row">
            <div class="col-md-6 text-left">
                <h2>Категории</h2>
            </div>
            <div class="col-md-6 text-right">
                <b-button variant="success" @click="$bvModal.show('bv-modal-create-from-menu-category')">Добавить категорию</b-button>
                <b-button v-b-modal.modal-xl variant="primary">Дерево категорий</b-button>
                <b-button variant="warning">Удаленные категории</b-button>
            </div>
        </div>
        <br>
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
                    <tr v-for="category in this.$store.state.categories" :key="category.id">
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
                            <b-button
                                class="btn btn-xs btn-danger"
                                size="sm"
                                v-on:click="removeCategory(category)">
                                    Удалить
                            </b-button>
                        </td>
                        <td>
                            <b-button
                                variant="primary"
                                size="sm"
                                v-on:click="$bvModal.show('bv-modal-edit_category'); editCategory(category)">
                                Изменить
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <b-modal id="bv-modal-edit_category" hide-footer title="Редактировать категорию">
                <div class="form-group">
                    <input type="text" class="form-control" :placeholder="this.updating_category.name" v-model="updating_category.name">
                </div>
                <b-button variant="outline-success" block @click="$bvModal.hide('bv-modal-edit_category'); updateCategory()">Обновить</b-button>
                <b-button variant="outline-danger" block @click="$bvModal.hide('bv-modal-edit_category')">Закрыть</b-button>
            </b-modal>
            <b-modal id="bv-modal-create-from-menu-category" hide-footer title="Создать категорию">
                <div class="form-group">
                    <label for="">Название категории</label>
                    <input type="text" class="form-control" v-model="new_category_params.name">
                </div>
                <div class="form-group">
                    <label for="">Родительская категория</label>
                    <select name="category_id" id="category" class="form-control" v-model="new_category_params.parent_id">
                        <option value="0">-</option>
                        <option v-for="category in categories" :key="category.id" v-bind:value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <b-button variant="outline-success" block @click="$bvModal.hide('bv-modal-create-from-menu-category'); storeCategory()">Создать</b-button>
                <b-button variant="outline-danger" block @click="$bvModal.hide('bv-modal-create-from-menu-category')">Закрыть</b-button>
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
            new_category_params: {
                name: "",
                parent_id: 0
            }
        }
    },
    mounted() {
        this.$store.dispatch('getCategories');
        // TODO !! Нужно ли отслеживать все изменения ?
        this.$store.subscribe((mutation, state) => {
            console.log('mutation ' + mutation.type);
            switch(mutation.type) {
                case 'UPDATE_CATEGORIES':
                    this.$store.dispatch('getCategories');
                break;
            }
        })
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
        },
        storeCategory() {
            this.$store.dispatch('createCategory', this.new_category_params);
        }
    }
}
</script>
