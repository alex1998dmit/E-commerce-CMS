<template>
    <b-modal id="modal-xl" size="xl" title="О пользователе">
        <div class="row">
            <div class="col-md-12">
                <h5>{{ userModal.name}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="category-table">
                    <h5>{{ userModal.name}}</h5>
                    <h4>Заказы</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Наименование товара</th>
                                <th scope="col">Категория товара</th>
                                <th scope="col">Дата заказа</th>
                                <th scope="col">Количество купленного товара</th>
                                <th scope="col">Сумма (с учетом скидок)</th>
                                <th scope="col">Статус заказа</th>
                                <th scope="col">Подробнее</th>
                                <th scope="col">Редактировать</th>
                            </tr>
                        </thead>
                        <tbody class="categories_list" id="categories_list">
                            <tr>
                                <!-- <td>{{ $order->id }}</td> -->
                                <!-- <td>{{ $order->product->name }}</td> -->
                                <!-- <td>{{ $order->product->category->name }}</td> -->
                                <!-- <td>{{ $order->created_at }}</td> -->
                                <!-- <td>{{ $order->amount }}</td> -->
                                <!-- <td>{{ $order->sum }}</td> -->
                                <!-- <td>{{ $order->created_at }}</td> -->
                                <!-- {{-- <td><a href="{{ route('order', ['id' => $order->id]) }}" class="btn btn-xs btn-info">Подробнее</a></td> --}} -->
                                <!-- {{-- <td><a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-xs btn-info">Редактировать</a></td> --}} -->
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
    data: () => {
        return {
            
        }
    },
    mounted() {

    }

}
</script>
