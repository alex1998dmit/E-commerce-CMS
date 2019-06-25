@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User's Carts</div>
                <div class="card-body">
                   @foreach($carts as $cart)
                    <div class="row">
                        <div class="col-md-3">
                            {{ $cart->user->name }}
                        </div>
                        <div class="col-md-3">
                            {{ $cart->user->email }}
                        </div>
                        <div class="col-md-3">
                            {{ $cart->product->name }}
                        </div>
                        <div class="col-md-3">
                            {{ $cart->amount }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <h5>{{ $cart->product->price * $cart->amount }}</h5>
                        </div>
                    </div>
                    <br>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
