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
                                        {{ implode('', $errors->all('<div>:message</div>')) }}
                                    @endif
                                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="name">Название продукта</label>
                                            <input type="text" class="form-control" name="name" id="name"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Категория</label>
                                            <select name="category_id" id="category" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Стоимость продукта</label>
                                            <input type="text" class="form-control" name="price" id="price"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Описание товара</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="photos">Фотографии продукта</label>
                                            <input type="file" class="form-control" name="photos[]" id="photos" multiple/>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Создать" />
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
