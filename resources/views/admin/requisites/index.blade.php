@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Requisites</div>
                    <div class="card-body" id="fromCartsContent">
                        <br>
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Наименование</th>
                                        <th scope="col">Реквизит</th>
                                        <th scope="col">Описание</th>
                                        <th scope="col">Удалить</th>
                                        <th scope="col">Редактировать</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($requisites  as $requisite)
                                    <tr>
                                        <td>{{ $requisite->id }}</td>
                                        <td>{{ $requisite->title }}</td>
                                        <td>{{ $requisite->requisite }}</td>
                                        <td>{{ $requisite->description ?? "-" }}</td>
                                        <td><a href="{{ route('requisite.edit', ['id' => $requisite->id]) }}" class="btn btn-xs btn-info">Edit</a></td></td>
                                        <td><a href="{{ route('requisite.trash', ['id' => $requisite->id]) }}" class="btn btn-xs btn-danger">Trash</a></td>
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
