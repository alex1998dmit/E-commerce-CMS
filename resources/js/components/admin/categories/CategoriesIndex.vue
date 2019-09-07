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
                <b-button variant="success" @click="createRootCategory">+ корневая категория</b-button>
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
                        <th scope="col">Подробнее</th>
                        <th scope="col">Удалить</th>
                        <th scope="col">Редактировать</th>
                    </tr>
                </thead>
                <tbody class="categories_list" id="categories_list">
                    <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <tr v-for="subcategory in category.childs" :key="subcategory.id">
                                <td>{{ subcategory.name }}</td>
                            </tr>
                        </td>
                        <td>
                            <b-button
                                variant="info"
                                size="sm"
                                @click="aboutCategory(category)">
                                    Подробнее
                            </b-button>
                        </td>
                        <td>
                            <b-button
                                class="btn btn-xs btn-danger"
                                size="sm"
                                v-on:click="trashCategory(category)">
                                    Удалить
                            </b-button>
                        </td>
                        <td>
                            <b-button
                                variant="primary"
                                size="sm"
                                v-on:click="changeCategory(category)">
                                Изменить
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <CreateCategory></CreateCategory>
        <ChangeCategory></ChangeCategory>
        <AboutCategory></AboutCategory>
        <CreateRootCategory></CreateRootCategory>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { crudCategoriesMixin } from './mixins/crudCategoriesMixin';
import CreateCategory from './includes/modals/CreateCategory';
import ChangeCategory from './includes/modals/ChangeCategory';
import AboutCategory from './includes/modals/AboutCategory';
import CreateRootCategory from './includes/modals/CreateRootCategory';

export default {
    mixins: [ crudCategoriesMixin ],
    components: {
        CreateCategory, ChangeCategory, AboutCategory, CreateRootCategory
    },
    data: () => {
        return {
            search_param: "",
        }
    },
    computed: {
        categories: {
            get() {
                let categories = this.$store.getters.categories;
                if (this.search_param != '') {
                    return categories.filter((category) => category.name.toLowerCase().includes(this.search_param.toLocaleLowerCase()));
                }
                return categories;
            },
            set(val) {}
        },
    },
    mounted() {
        this.$store.dispatch('getCategories');
    },
}
</script>
