<template>
    <ul>
        <li v-for="child in childs">
            {{ child.name }}
            <button type="button" class="btn btn-success btn-sm" @click="changeParentCategory(child.id)">+</button>
            <button type="button" class="btn btn-danger btn-sm" @click="removeCategory(child)">x</button>
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
}
</script>



