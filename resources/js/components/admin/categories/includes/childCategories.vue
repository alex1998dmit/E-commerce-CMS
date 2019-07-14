<template>
    <ul>
        <li v-for="child in childs">
            {{ child.name }}
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
    mounted() {
    }
}
</script>



