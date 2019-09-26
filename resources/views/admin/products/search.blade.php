@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Products</div>
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
                                    <a href="{{ route('product.create') }}" class="btn btn-success">Добавить продукт</a>
                                    <a href="{{ route('products') }}" class="btn btn-info">Все продукты</a>
                                    <a href="{{ route('products.trashed') }}" class="btn btn-warning">Удаленные продукты</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h5> Результаты поиска по запросу <u>{{ $param }}</u>  :</h5>
                            </div>
                        </div>
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
                                        <th scope="col">Изменить</th>
                                        <th scope="col">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody class="orders_list" id="orders_list">
                                    @if($products->count() > 0)
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
                                                <td><a href="{{ route('product.edit', ['id' => $product->id])}}" class="btn btn-xs btn-info">Edit</a></td></td>
                                                <td><a href="{{ route('product.trash', ['id' => $product->id])}}" class="btn btn-xs btn-danger">Trash</a></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h5>Запрос не дал никаких результатов</h5>
                                                </div>
                                            </div>
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
