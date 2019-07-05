@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users</div>
                    <div class="card-body" id="fromCartsContent">
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- <a href="{{ route('requisite.create') }}" class="btn btn-xs btn-success">Добавить реквизит</a> --}}
                            </div>
                        </div>
                        <br>
                        <div class="category-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">ФИО</th>
                                        <th scope="col">emal</th>
                                        <th scope="col">Дата регистрации</th>
                                        <th scope="col">Дата подтверждения аккаунта</th>
                                        <th scope="col">Кол-во заказов</th>
                                        <th scope="col">В сумме потрачено</th>
                                        <th scope="col">Роль</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Подробнее</th>
                                        <th scope="col">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody class="categories_list" id="categories_list">
                                    @foreach ($users  as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->email_verified_at ?? "Не подтвержден" }}</td>
                                        <td>{{ $user->order->count() }}</td>
                                        <td>{{ $user->order->sum('sum') }}</td>
                                        <td>
                                            @foreach($user->role as $role)
                                                {{ $role->name }}
                                            @endforeach
                                        </td>
                                        <td>{{ 'в разработке' }}</td>
                                        <td><a href="{{ route('user', ['id' => $user->id]) }}" class="btn btn-xs btn-info">Подробнее</a></td>
                                        <td><a href="{{ route('user.trash', ['id' => $user->id]) }}" class="btn btn-xs btn-danger">Удалить</a></td>
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
