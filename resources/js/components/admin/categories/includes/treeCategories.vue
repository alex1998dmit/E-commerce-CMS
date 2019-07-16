<template>
    <div>
        <b-modal id="modal-xl" size="xl" title="Дерево категорий">
            <div class="row">
                <div class="col-md-12 text-left">
                    <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(0); resetNewCategory();">+</button>
                </div>
            </div>
            <li v-for="category in categoryTree">
                {{ category.name }}
                <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(category.id);">+</button>
                <button type="button" class="btn btn-danger btn-sm"  @click="removeCategory(category)">x</button>
                <childCategories v-if="category.childs.length > 0" :childs="category.childs"></childCategories>
            </li>
        </b-modal>
        <b-modal id="bv-modal-create-category" hide-footer>
            <div class="d-block text-center">
                <h5>Hello From This Modal!</h5>
            </div>
            <input type="text" v-model="new_category.name">
            <button type="button" class="mt-3 btn btn-success" @click="addSubcategory()">Добавить</button>
            <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example')">Close Me</b-button>
        </b-modal>
    </div>
</template>
<script>
import { createCategoryMixin } from '../mixins/createCategoryMixin.js';
import childCategories from './childCategories.vue';
import { generateArrayOfCategoriesTree } from '../../../../helpers/categoryTree';

export default {
    mixins: [createCategoryMixin],
    components: {
        childCategories
    },
    props: {
        categories: Array,
    },
    computed: {
        categoryTree() {
            return generateArrayOfCategoriesTree(this.$store.getters.categories);
        }
    }
}
</script>
