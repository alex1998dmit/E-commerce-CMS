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
        <li v-for="(category) in categoryTree" :key="category.id">
            {{ category.name }}
                <button type="button" class="btn btn-success btn-sm buttons-crud" @click="createCategory(category);" >+</button>
                <button type="button" class="btn btn-danger btn-sm buttons-crud"  @click="trashCategory(category)">x</button>
                <button type="button" class="btn btn-warning btn-sm buttons-crud"  @click="changeCategory(category)">изменить</button>
            <ChildsCategories v-if="category.childs.length > 0" :childs="category.childs"></ChildsCategories>
        </li>
        <CreateCategory></CreateCategory>
        <ChangeCategory></ChangeCategory>
        <CreateProductWithCategory></CreateProductWithCategory>
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
import CreateRootCategory from './includes/modals/CreateRootCategory';
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
}
</script>
