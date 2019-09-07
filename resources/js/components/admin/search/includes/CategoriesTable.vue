<template>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Название</th>
            <th scope="col">Подкатегории</th>
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
        </tr>
    </tbody>
</table>
</template>

<script>
export default {
    props: {
        categories: Array
    }
}
</script>

<style>

</style>
