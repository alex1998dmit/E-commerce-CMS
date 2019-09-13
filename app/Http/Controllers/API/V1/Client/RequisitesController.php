<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Requisite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequisitesController extends Controller
{
    public function index()
    {
        $requisites = Requisite::where('is_selected', '=', true)->get();
        return $requisites;
    }
}
