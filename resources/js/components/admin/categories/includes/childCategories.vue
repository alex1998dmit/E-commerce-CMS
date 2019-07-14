<template>
    <ul>
        <li v-for="child in childs">
            {{ child.name }}
            <button type="button" class="btn btn-success btn-sm" @click="addSubcategory(child); ">+</button>
            <childCategories v-if="child.childs.length > 0" :childs="child.childs"></childCategories>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'childCategories',
    props: {
        childs: Array
    },
    data: () => {
        return {
            inputField: []
        }
    },
    mounted() {
        console.log(this.$parent);
    },
    methods: {
        addSubcategory(category) {
            let app = this;
            this.$emit('update', category);
        },
    }
}
</script>



