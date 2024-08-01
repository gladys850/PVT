<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kinship;
use DB;

class KinshipController extends Controller
{
    /**
     * Lista de Parentescos
     * Devuelve el listado de los parentescos
     * @autenticated
     * @responseFile responses/kinship/index.200.json
     */
    public function index()
    {
        return Kinship::where('id','!=', 1)//exclusion titular
        ->orderBy('name')
        ->get();
    }

    /**
    * Detalle de parentesco
    * Devuelve el detalle de una parentesco mediante su ID
    * @urlParam kinship required ID de parentesco. Example: 1
    * @authenticated
    * @responseFile responses/kinship/show.200.json
    */
    public function show(Kinship $kinship)
    {
        return $kinship;
    }
    
}
