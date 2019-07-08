@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products</div>
                    <div class="card-body" id="fromCartsContent">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('product.create') }}" class="btn btn-success">Добавить продукт</a>
                                    <a href="{{ route('products') }}" class="btn btn-info">Все продукты</a>
                                </div>
                            </div>
                            <br>
                        <br>
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Категория товара</th>
                                        <th scope="col">Цена</th>
                                        <th scope="col">Описание</th>
                                        <th scope="col">Фото</th>
                                        <th scope="col">Дата создания</th>
                                        <th scope="col">Дата обновления</th>
                                        <th scope="col">Восстановить</th>
                                        <th scope="col">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody class="orders_list" id="orders_list">
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>
                                                @foreach($product->photo as $photo)
                                                    <img src="{{ url('/upload/products/' . $photo->path )}}" alt="" width="" height="90px">
                                                @endforeach
                                            </td>

                                            <td>{{ $product->created_at ?? "-" }}</td>
                                            <td>{{ $product->updated_at ?? "-" }}</td>
                                            <td><a href="{{ route('product.restore', ['id' => $product->id])}}" class="btn btn-xs btn-warning">Restore</a></td>
                                            <td><a href="{{ route('product.trash', ['id' => $product->id])}}" class="btn btn-xs btn-danger">Kill</a></td>
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
