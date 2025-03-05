<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WfState;

class WfStatesController extends Controller
{
    public function index(Request $request)
    {
        $query = WfState::where('module_id',6)->orderBy('name');
        if ($request->has('name')) $query = $query->whereName($request->name);
        return $query->get();
    }

    public function show(WfState $wf_state)
    {
        return $wf_state;
    }
}