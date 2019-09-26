@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row  text-center">
                            <div class="col-md-12">
                                <div class="create-form">
                                    <form action="{{ route('requisite.store') }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <div class="form-group">
                                            <label for="title">Название реквизита</label>
                                            <input type="text" class="form-control" name="title" id="title"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="requisite">Реквизит</label>
                                            <input type="text" class="form-control" name="requisite" id="requisite"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Комментарии</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
