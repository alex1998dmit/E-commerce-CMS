@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Discounts</div>
                    <div class="card-body" id="fromCartsContent">
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('requisite.create') }}" class="btn btn-xs btn-success">Добавить скидку</a>
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Наименование</th>
                                        <th scope="col">Размер скидки</th>
                                        <th scope="col">Описание</th>
                                        <th scope="col">Кол-во активных пользователей</th>
                                        <th scope="col">Добавить пользователя</th>
                                        <th scope="col">Удалить</th>
                                        <th scope="col">Редактировать</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($discounts  as $discount)
                                    <tr>
                                        <td>{{ $discount->id }}</td>
                                        <td>{{ $discount->name }}</td>
                                        <td>{{ $discount->discount }}</td>
                                        <td>{{ $discount->description ?? "-" }}</td>
                                        <td>{{ $discount->user()->count() }}</td>
                                        <td><a href="" class="btn btn-xs btn-success">Добавить пользователя</a></td></td>
                                        <td><a href="{{ route('discount.edit', ['id' => $discount->id]) }}" class="btn btn-xs btn-info">Редактировать</a></td></td>
                                        <td><a href="{{ route('discount.delete', ['id' => $discount->id]) }}" class="btn btn-xs btn-danger">Удалить</a></td>
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
