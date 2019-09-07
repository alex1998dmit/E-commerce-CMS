<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Категория</th>
                <th scope="col">Цена</th>
                <th scope="col">В корзине:</th>
                <th scope="col">Покупок:</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>
                    <a
                        class="aboutProduct"
                    >
                        {{ product.name }}
                    </a>
                </td>
                <td>{{ product.category.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.wish_list.length }}</td>
                <td>{{ product.order_items.length }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        products: Array
    }
}
</script>

<style>

</style>
