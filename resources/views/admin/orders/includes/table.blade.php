<table class="table">
        <thead>
            <tr>
                <th scope="col">Дата заказа</th>
                <th scope="col">Заказчик</th>
                <th scope="col">Товар</th>
                <th scope="col">Категория товара</th>
                <th scope="col">Количества товара</th>
                <th scope="col">Сумма за товар</th>
                <th scope="col">Статус заказа</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
        </thead>
        <tbody class="orders_list" id="orders_list">
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->product->category->name }}</td>
                    <td>{{ $order->amount }}</td>
                    <td>{{ $order->sum }}</td>
                    <td>{{ $order->status->name }}</td>
                    <td><a href="" class="btn btn-xs btn-info">Edit</a></td></td>
                    <td><a href="{{ route('order.delete', ['id'=> $order->id]) }}" class="btn btn-xs btn-danger">Trash</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
