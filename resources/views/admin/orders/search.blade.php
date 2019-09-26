@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Orders</div>
                    <div class="card-body" id="fromCartsContent">
                        <div class="row">
                            @include('admin.orders.includes.search')
                            @include('admin.orders.includes.navigation')
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('product.create') }}" class="btn btn-success">Добавить заказы</a>
                                <a href="{{ route('orders.trashed') }}" class="btn btn-warning">Удаленные заказы</a>
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5> Результаты поиска по запросу <u>{{ $param }}</u>  :</h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">По id заказа</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">По пользователям</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">По продукции</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        @include('admin.orders.includes.table', ['orders' => $orders])
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        @include('admin.orders.includes.table', ['orders' => $order_users])
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        @include('admin.orders.includes.table', ['orders' => $order_products])
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
