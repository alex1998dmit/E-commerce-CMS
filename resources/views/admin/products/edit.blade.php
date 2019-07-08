@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create product</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row  text-center">
                            <div class="col-md-12">
                                <div class="create-form">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="name">Название продукта</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Категория</label>
                                            <select name="category_id" id="category" class="form-control">
                                                <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Стоимость продукта</label>
                                            <input type="text" class="form-control" name="price" id="price" value="{{ $product->price }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Описание товара</label>
                                            <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            @foreach($product->photo as $photo)
                                            <input checked="checked" name="uploaded_images[]" type="checkbox" value="{{ $photo->id }}">
                                                <img src="{{ url('/upload/products/' . $photo->path )}}" alt="" width="300px" height="">
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="photos">Загрузка новой фотографии</label>
                                            <input type="file" class="form-control" name="photos[]" id="photos" multiple/>
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
