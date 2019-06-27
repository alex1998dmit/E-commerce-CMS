@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Дата заказа</th>
                                        <th scope="col">Заказчик</th>
                                        <th scope="col">Товар</th>
                                        <th scope="col">Категория товара</th>
                                        <th scope="col">Изменить</th>
                                        <th scope="col">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->product->name }}</td>
                                        <td>{{ $order->product->category->name }}</td>
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
    </div>
@endsection
