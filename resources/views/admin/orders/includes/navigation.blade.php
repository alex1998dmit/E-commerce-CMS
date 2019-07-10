<div class="col-md-6 text-right">
    <a href="{{ route('orders.withStatus', ['status_id' => 1]) }}" class="btn btn-primary">Ожидающие оплату</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 2]) }}" class="btn btn-secondary">Оплата отправленна</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 3]) }}" class="btn btn-warning">Оплата подтверждена</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 4]) }}" class="btn btn-light">Заказ готовится к отправке</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 5]) }}" class="btn btn-info">Заказ отправлен</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 6]) }}" class="btn btn-dark">Ожидается получение</a>
    <a href="{{ route('orders.withStatus', ['status_id' => 7]) }}" class="btn btn-success">Заказ получен</a>
</div>
