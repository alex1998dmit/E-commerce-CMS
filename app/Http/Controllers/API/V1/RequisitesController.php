<?php

namespace App\Http\Controllers\API\V1;

use App\Requisite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequisitesController extends Controller
{
    public function index()
    {
        $requisites = Requisite::all();
        foreach($requisites as $requisite) {
            $requisite->products;
        }
        return $requisites;
    }

    public function store(Request $request)
    {
        $requisite = Requisite::create([
            'title' => $request->title,
            'requisite' => $request->requisite,
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
        $requisite->update($request->all());
        return $requisite;
    }

    public function trash($id)
    {
        $requisite = Requisite::find($id);
        $requisite->delete();
        return response()->json(['mesasage' => 'succesfully deleted'], 200);
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
}
