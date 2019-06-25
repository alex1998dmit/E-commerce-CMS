@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User's Carts</div>
                <div class="card-body">
                   @foreach($carts as $cart)
                    <div class="col-md-12">
                        {{ $cart->user->name }}

                    </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
