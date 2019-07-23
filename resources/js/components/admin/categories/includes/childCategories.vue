<template>
    <ul>
        <li v-for="child in childs" :key="child.id">
            {{ child.name }}
            <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(child.id)">+</button>
            <button type="button" class="btn btn-danger btn-sm" @click="removeCategory(child)">x</button>
            <button type="button" class="btn btn-warning btn-sm"  @click="changeCategory(child)">изменить</button>
            <button type="button" v-if="child.childs.length == 0" class="btn btn-info btn-sm"  @click="openFormWithProducts(child.id)">продукты</button>
            <button type="button" v-if="child.childs.length == 0" class="btn btn-primary btn-sm"  @click="createProductWithCategory(child.id)">+ продукт</button>
            <childCategories v-if="child.childs.length > 0" :childs="child.childs"></childCategories>
        </li>
    </ul>
</template>
<script>
import { createCategoryMixin } from '../mixins/createCategoryMixin.js';

export default {
    name: 'childCategories',
    mixins: [createCategoryMixin],
    props: {
        childs: Array
    },
    methods: {
        createProductWithCategory(category_id) {
            this.$store.commit('SET_CURRENT_CATEGORY_ID', category_id);
            this.$bvModal.show('bv-modal-add-product-category');
        },
        openFormWithProducts(category_id) {
            this.$store.commit('SET_CURRENT_CATEGORY_ID', category_id);
            this.$bvModal.show('bv-modal-products-with-category');
        }
    },
}
</script>



