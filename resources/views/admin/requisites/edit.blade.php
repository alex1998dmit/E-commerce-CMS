@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit category</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row  text-center">
                            <div class="col-md-12">
                                <div class="create-form">
                                    <form action="{{ route('requisite.update', ['id'=> $requisite->id]) }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="name">Название реквизита</label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{ $requisite->title }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="requisite">Реквизит</label>
                                            <input type="text" class="form-control" name="requisite" id="requisite" value="{{ $requisite->requisite }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Комментарии</label>
                                            <textarea class="form-control" id="description" name="description" rows="3">{{ $requisite->description }}"</textarea>
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
