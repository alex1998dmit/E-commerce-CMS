<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryWithProducts;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }

    // Soft delete
    public function trash()
    {

    }

    public function edit($id)
    {

    }

    public function update()
    {
        
    }

    public function trash($id)
    {

    }

    public function delete()
    {

    }
}
