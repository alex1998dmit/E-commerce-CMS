<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-left">
                <h2>Категории</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="search_param" placeholder="Введите название категории ...">
            </div>
             <div class="col-md-6 text-right">
                <b-button variant="success" @click="$bvModal.show('bv-modal-create-from-menu-category')">Добавить категорию</b-button>
                <b-button variant="primary" :to="{ name: 'CategoriesTree' }">Дерево категорий</b-button>
                <b-button variant="warning" :to="{ name: 'CategoriesTrashed' }">Удаленные категории</b-button>
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
    </div>
</template>
<script>
import { mapGetters } from 'vuex';

export default {
    data: () => {
        return {
            search_param: "",
        }
    },
    mounted() {
        this.$store.dispatch('getCategories');
        // TODO !! Нужно ли отслеживать все изменения ?
        this.$store.subscribe((mutation, state) => {
            switch(mutation.type) {
                case 'UPDATE_CATEGORIES':
                    this.$store.dispatch('getCategories');
                break;
            }
        })
    },
    computed: {
        categories: {
            get() {
                return this.$store.getters.categories;
            },
            set(val) {}
        },
        // categories() {
        //     let categories = this.$store.getters.categories;
        //     if (this.search_param === "") {
        //         return categories;
        //     }
        //     return categories.filter(category => category.name.toLowerCase().includes(this.$data.search_param.toLocaleLowerCase()))
        // },
    },
    methods: {

    },
    watch: {
        search_param(val) {
            // this.categories.filter(category => category);
        }
    }
}
</script>
