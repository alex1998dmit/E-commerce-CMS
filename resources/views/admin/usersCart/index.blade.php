@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User's Carts</div>
                <div class="card-body" id="fromCartsContent">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Заказчик</th>
                                <th scope="col">Email заказчика</th>
                                <th scope="col">Продукт</th>
                                <th scope="col">Категория продукта</th>
                                <th scope="col">Количества продукта</th>
                                <th scope="col">Сумма за товар</th>
                                <th scope="col">Дата добавления</th>
                                <th scope="col">Изменить</th>
                                <th scope="col">Удалить</th>
                            </tr>
                        </thead>
                        <tbody class="carts_list" id="carts_list">
                            @foreach($carts as $cart)
                                <tr>
                                    <th>{{ $cart->user->name}}</th>
                                    <th>{{ $cart->user->email}}</th>
                                    <th>{{ $cart->product->name}}</th>
                                    <th>{{ $cart->product->category->name}}</th>
                                    <th>{{ $cart->amount}}</th>
                                    <th>{{ $cart->product->price * $cart->amount}}</th>
                                    <th>{{ $cart->created_at}}</th>
                                    <td><a href="" class="btn btn-xs btn-info">Edit</a></td></td>
                                    <td><a href="" class="btn btn-xs btn-danger">Trash</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
