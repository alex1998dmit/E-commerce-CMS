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
                <td>
                    <a
                        class="aboutProduct"
                        @click="$emit('openProduct', product)">
                        {{ product.name }}
                    </a>
                </td>
                <td>{{ product.category.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.wish_list.length }}</td>
                <td>{{ product.order_items.length }}</td>
                <td>
                    <router-link href="#" class="edit-icon" :to="{ name: 'editProduct', params: { id: product.id }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </router-link>
                </td>
                <td>
                    <a href="#" class="trash-icon" @click="$emit('trashProduct', product.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        products: Array,
    },
}
</script>
<style scoped>
    .fa .fa-pencil {
        color: black;
    }
    .edit-icon {
        color: black;
    }
    .trash-icon {
        color: red;
    }
    .add-product-button {
        border-bottom: 2px solid lightgrey;
        border-radius: 0px;
        color: black;
    }
    .add-product-button:hover {
        border-bottom: 2px solid black;
    }
    .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .search-field {
        padding-left: 3%;
    }
    .search-input {
        padding-left: 10%;
    }
    .aboutProduct {
        color: #333;
        text-decoration: none;
    }
</style>

