<template>
    <b-modal id="modal-xl" size="xl" title="Заказы пользователя">
        <div class="row">
            <div class="col-md-12">
                <h5>{{ user.name }}</h5>
                <h6>{{ user.email }}</h6>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="category-table">
                    <h4>Заказы</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Наименование товара</th>
                                <th scope="col">Категория товара</th>
                                <th scope="col">Дата заказа</th>
                                <th scope="col">Количество купленного товара</th>
                                <th scope="col">Цена за 1 единицу товара</th>
                                <th scope="col">Сумма (с учетом скидок)</th>
                                <th scope="col">Статус заказа</th>
                            </tr>
                        </thead>
                        <tbody class="categories_list" id="categories_list">
                            <tr v-for="order in user.order">
                                <td>{{ order.id }}</td>
                                <td>{{ order.product.name }}</td>
                                <td>{{ order.product.category.name }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>{{ order.amount }}</td>
                                <td>{{ order.product.price }}</td>
                                <td>{{ order.sum }}</td>
                                <td>{{ order.status.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    props: {
        user: Object
    },
}
</script>
