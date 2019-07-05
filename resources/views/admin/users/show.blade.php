@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="well well-sm">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-8">
                                                <h4>{{ $user->name }}</h4>
                                                <small>
                                                    <cite title="San Francisco, USA">
                                                        @foreach($user->role as $role)
                                                            {{ $role->name, }}
                                                        @endforeach
                                                    </cite>
                                                </small>
                                                <p>
                                                Почта: {{ $user->email }}
                                                <br/>
                                                Подтвеждение: {{ $user->email_verified_at ?? "Не подтвержден"}}
                                                <br/>
                                                Дата регистрации: {{ $user->created_at }}
                                                <br/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- <a href="{{ route('requisite.create') }}" class="btn btn-xs btn-success">Добавить реквизит</a> --}}
                            </div>
                        </div>
                        <br>
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
                                        <th scope="col">Сумма (с учетом скидок)</th>
                                        <th scope="col">Статус заказа</th>
                                        <th scope="col">Подробнее</th>
                                        <th scope="col">Редактировать</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($orders  as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->product->name }}</td>
                                        <td>{{ $order->product->category->name }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->sum }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        {{-- <td><a href="{{ route('order', ['id' => $order->id]) }}" class="btn btn-xs btn-info">Подробнее</a></td> --}}
                                        {{-- <td><a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-xs btn-info">Редактировать</a></td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
