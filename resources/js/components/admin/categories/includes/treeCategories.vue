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
        <b-modal id="bv-modal-create-category" hide-footer title="Добавить новую категорию">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label for="category_name">Название новой категории</label>
                    <input type="text" class="form-control" name="category_name" v-model="new_category.name">
                </div>
            </div>
            <br>
            <b-button block variant="outline-success" @click="addSubcategory()">Добавить</b-button>
            <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-create-category')">Отмена</b-button>
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
