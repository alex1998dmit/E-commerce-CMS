<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use App\Requisite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequisitesController extends Controller
{
    public function index()
    {
        $requisites = Requisite::orderBy('created_at', 'desc')->get();
        $requisites->each(function ($requisite) {
            $requisite->products;
        });
        return $requisites;
    }

    public function store(Request $request)
    {
        $validation =  Validator::make($request->all(), [
            'title' => 'required|string|min:1|max:64',
            'account_num' => 'required|string|min:1|max:100',
            'description' => 'required|string|min:1|max:1000'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $requisite = Requisite::create([
            'title' => $request->title,
            'account_num' => $request->account_num,
            'description' => $request->description,
        ]);

        return $requisite;
    }

    public function single($id)
    {
        return Requisite::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validation =  Validator::make($request->all(), [
            'title' => 'string|min:1|max:64',
            'account_num' => 'string|min:1|max:100',
            'description' => 'string|min:1|max:1000',
            'is_selected' => 'boolean'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'messages' => $validation->errors()
            ], 401);
        }

        $requisite = Requisite::findOrFail($id);
        $requisite->title = $request->title ?? $requisite->title;
        $requisite->account_num = $request->account_num ?? $requisite->account_num;
        $requisite->description = $request->description ?? $requisite->description;
        $requisite->is_selected = $request->is_selected ?? $requisite->is_selected;
        $requisite->save();
        return $requisite;
    }

    public function trashed()
    {
        $requisites = Requisite::onlyTrashed()->get();
        return $requisites;
    }

    public function restore($id)
    {
        $requisite = Requisite::onlyTrashed()->find($id);
        if (!is_null($requisite)) {
            $requisite->restore();
            return $requisite;
        } else {
            return response()->json(['message' => 'Nothing to restore'], 500);
        }
    }

    public function trash($id)
    {
        $requisite = Requisite::find($id);
        $requisite->products()->detach();
        $requisite->delete();
        return response()->json(['mesasage' => 'succesfully deleted'], 200);
    }
}
