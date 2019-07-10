@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                {{-- TODO: search what method should i use --}}
                                <form action="{{ route('products.search') }}" method="POST" class="form-inline">
                                    {{ csrf_field() }}
                                    <div class="form-group mx-sm-3">
                                        <input class="form-control" id="product_param" name="param" type="text" placeholder="Поиск..">
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Найти">
                                </form>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('orders.waitingPayment') }}" class="btn btn-primary">Ожидающие оплату</a>
                                    <a href="" class="btn btn-secondary">Оплата отправленна</a>
                                    <a href="" class="btn btn-warning">Оплата подтверждена</a>
                                    <a href="" class="btn btn-info">Заказ отправлен</a>
                                    <a href="" class="btn btn-dark">Ожидается получение</a>
                                    <a href="" class="btn btn-success">Заказ получен</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
