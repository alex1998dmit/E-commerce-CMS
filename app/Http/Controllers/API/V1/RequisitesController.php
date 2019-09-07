<?php

namespace App\Http\Controllers\API\V1;

use App\Requisite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequisitesController extends Controller
{
    public function index()
    {
        $requisites = Requisite::orderBy('created_at', 'desc')->get();
        foreach($requisites as $requisite) {
            $requisite->products;
        }
        return $requisites;
    }

    public function store(Request $request)
    {
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
