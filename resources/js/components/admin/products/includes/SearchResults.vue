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
            <th scope="col">Подробнее</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.category.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.wish_list.length }}</td>
                <td>{{ product.order.length }}</td>
                <td>
                    <b-button
                        id="show-btn"
                        @click="$parent.openAboutProductModal(product)">
                            Подробнее
                    </b-button>
                </td>
                <td>
                    <a href="#"
                        class="btn btn-xs btn-danger"
                        @click="trashProduct(product.id)">
                            Удалить
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        products: null,
    },
}
</script>

