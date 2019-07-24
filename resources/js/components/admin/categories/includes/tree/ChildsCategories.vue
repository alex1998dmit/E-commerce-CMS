<template>
    <ul>
        <li v-for="child in childs" :key="child.id">
            {{ child.name }}
            <button type="button" class="btn btn-success btn-sm buttons-crud" @click="createCategory(child);" >+</button>
            <button type="button" class="btn btn-danger btn-sm buttons-crud"  @click="deleteCategory(child)">x</button>
            <button type="button" class="btn btn-warning btn-sm buttons-crud"  @click="changeCategory(child)">изменить</button>
            <button type="button" v-if="child.childs.length == 0" class="btn btn-info btn-sm"  @click="productsByCategory(child)">продукты</button>
            <button type="button" v-if="child.childs.length == 0" class="btn btn-primary btn-sm"  @click="createProductWithCategory(child)">+ продукт</button>
            <childCategories v-if="child.childs.length > 0" :childs="child.childs"></childCategories>
        </li>
    </ul>
</template>
<script>

import { deleteCategoriesMixin } from '../../mixins/deleteCategoriesMixin';
import { crudCategoriesMixin } from '../../mixins/crudCategoriesMixin';

export default {
    name: 'childCategories',
    mixins: [ deleteCategoriesMixin, crudCategoriesMixin ],
    props: {
        childs: Array
    },
    methods: {
        createProductWithCategory(category) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-add-product-category');
        },
        productsByCategory(category) {
            this.setCurrentCategory(category);
            this.$bvModal.show('bv-modal-products-with-category');
        }
    },
}
</script>
