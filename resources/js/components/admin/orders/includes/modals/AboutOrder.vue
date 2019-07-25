<template>
    <b-modal id="about-order-modal" size="xl" title="О заказе" hide-footer>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h3>Заказ №{{ order.id }}({{ order.status.name }})</h3>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Продукт</th>
                                    <th scope="col">Категория продукта</th>
                                    <th scope="col">Заказчик (Имя)</th>
                                    <th scope="col">Заказчик (Email)</th>
                                    <th scope="col">Кол-во товара</th>
                                    <th scope="col">Цена за 1 ед</th>
                                    <th scope="col">Сумма</th>
                                    <th scope="col">Дата заказа</th>
                                    <th scope="col">Дата изменения</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   <td>{{ order.id }}</td>
                                   <td>{{ order.product.name }}</td>
                                   <td>{{ order.product.category.name }}</td>
                                   <td>{{ order.user.name }}</td>
                                   <td>{{ order.user.email }}</td>
                                   <td>{{ order.amount }}</td>
                                   <td>{{ order.product.price }}</td>
                                   <td>{{ order.sum }}</td>
                                   <td>{{ order.created_at }}</td>
                                   <td>{{ order.updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>

<script>
export default {
    computed: {
        order() {
            return this.$store.getters.selectedOrder;
        }
    },
}
</script>

