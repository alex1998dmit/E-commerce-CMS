@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row  text-center">
                            <div class="col-md-6">
                                <div class="create-form">
                                    <form action="{{ route('category.add') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="name">Название категории</label>
                                            <input type="text" class="form-control" name="name" id="name"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_parent">Подкатегории</label>
                                            <select name="parent_id" id="parent_id" class="form-control">
                                                <option value="0" selected>-</option>
                                                @foreach($allCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Создать" />
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                @foreach($categories as $category)
                                    <li>
                                        {{ $category->name }}
                                        @if(count($category->childs))
                                            @include('admin.categories.manageChild',['childs' => $category->childs])
                                        @endif
                                    </li>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Подкатегории</th>
                                        <th scope="col">Удалить</th>
                                        <th scope="col">Редактировать</th>
                                        <th scope="col">Добавить товар</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($allCategories  as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @foreach($category->childs as $sub_category)
                                                {{ $sub_category->name }}
                                            @endforeach
                                        </td>
                                        <td><a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">Edit</a></td></td>
                                        <td><a href="{{ route('category.trash', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">Trash</a></td>
                                        <td><a href="" class="btn btn-xs btn-info">Добавить продукт</a></td>
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
