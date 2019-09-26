@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Trashed categories</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Название</th>
                                    <th scope="col">Восстановить</th>
                                    <th scope="col">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($allCategories  as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td><a href="{{ route('category.restore', ['id' => $category->id]) }}" class="btn btn-xs btn-success">Restore</a></td>
                                        {{-- TODO Фунционал окончательного удаления --}}
                                        <td><a href="{{ route('category.restore', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">Delete</a></td>
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
