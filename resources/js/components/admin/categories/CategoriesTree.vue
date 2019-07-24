<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h2>Дерево категорий</h2>
            </div>
            <div class="col-md-6 text-right">
                <b-button variant="info" :to="{ name:'categories' }">Категории</b-button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 text-left">
                <button type="button" class="btn btn-success btn-sm" @click="createCategory()">+</button>
            </div>
        </div>
        <li v-for="(category) in categoryTree" :key="category.id">
            {{ category.name }}
                <button type="button" class="btn btn-success btn-sm buttons-crud" @click="createCategory(category);" >+</button>
                <button type="button" class="btn btn-danger btn-sm buttons-crud"  @click="trashCategory(category)">x</button>
                <button type="button" class="btn btn-warning btn-sm buttons-crud"  @click="changeCategory(category)">изменить</button>
            <ChildsCategories v-if="category.childs.length > 0" :childs="category.childs"></ChildsCategories>
        </li>
        <!-- Create New Category -->
        <CreateCategory></CreateCategory>
        <!-- Изменение категории -->
        <ChangeCategory></ChangeCategory>
        <!-- Создать продукт с категорией-->
        <CreateProductWithCategory></CreateProductWithCategory>
        <!-- Список продуктов категории -->
        <ProductsByCategory></ProductsByCategory>
    </div>
</template>
<script>
// mixins
import { crudCategoriesMixin } from './mixins/crudCategoriesMixin';
// components
import ChildsCategories from './includes/tree/ChildsCategories.vue';
import CreateCategory from './includes/modals/CreateCategory.vue';
import ChangeCategory from './includes/modals/ChangeCategory.vue';
import ProductsByCategory from './includes/modals/products/ProductsByCategories';
import CreateProductWithCategory from './includes/modals/products/CreateProductWithCategory';
// utils
import { generateArrayOfCategoriesTree } from './../../../helpers/categoryTree';

export default {
    mixins: [ crudCategoriesMixin ],
    components: {
        ChildsCategories, CreateCategory, ChangeCategory, ProductsByCategory, CreateProductWithCategory
    },
    computed: {
        categoryTree() {
            return generateArrayOfCategoriesTree(this.$store.getters.categories);
        },
    },
    mounted() {
        this.$store.dispatch('getCategories');
        this.$store.dispatch('getFinalCategories');
        this.$store.dispatch('getProducts');
    },
    methods: {
        setCurrentCategory(category) {
            if (category) {
                this.$store.commit('SET_CURRENT_CATEGORY', category);
            }
        },
        // open modals
        createCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-create-category');
        },
        changeCategory(category = null) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-change-category');
        },
        //
    },
}
</script>
