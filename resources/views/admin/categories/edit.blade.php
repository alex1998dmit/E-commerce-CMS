@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit category</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row  text-center">
                            <div class="col-md-6">
                                <div class="create-form">
                                    <form action="{{ route('category.update', ['id'=> $category->id]) }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="name">Название категории</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="category_parent">Подкатегории</label>
                                            <select name="parent_id" id="parent_id" class="form-control">
                                                <option value="{{ $parent_category->id ?? 0 }}" selected>{{ $parent_category->name ?? "-" }}</option>
                                                @foreach($all_categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Обновить" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
