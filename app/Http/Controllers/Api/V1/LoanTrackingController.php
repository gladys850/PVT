<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\LoanTracking;
use Illuminate\Http\Request;
use App\LoanTrackingType;
use Carbon;
use Illuminate\Support\Facades\Validator;

class LoanTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'required|integer',
        ]);
        if($validator->fails()) {
            $keys = $validator->errors()->keys();
            $errors = [];
            foreach($keys as $key) {
                $errors[$key] = $validator->errors()->get($key);
            }
            return response()->json([
                'error' => true,
                'message' => 'Error en la validación',
                'errors' => $errors,
                'data' => []
            ], 422);
        }
        $pagination = $request->per_page ?? 10;
        $loan_tracking = LoanTracking::withTrashed()->paginate($pagination);
        return response()->json([
            'error' => false,
            'message' => 'Listado del segumiento de un préstamo en mora',
            'data' => $loan_tracking
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_tracking_type_id' => 'required|integer',
            'loan_id' => 'required|integer',
            'tracking_date' => 'required|date',
            'description' => 'required|string|min:1'
        ]);

        if($validator->fails()) {
            $keys = $validator->errors()->keys();
            $errors = [];
            foreach($keys as $key) {
                $errors[$key] = $validator->errors()->get($key);
            }
            return response()->json([
                'error' => true,
                'message' => 'Error en la validación',
                'errors' => $errors,
                'data' => []
            ], 422);
        }

        $loan_tracking_type_id = $request->loan_tracking_type_id;
        $loan_id = $request->loan_id;
        $tracking_date = $request->tracking_date;
        $user_id = auth()->id();
        $description = $request->description;
        LoanTracking::create([
            'loan_id' => $loan_id,
            'user_id' => $user_id,
            'loan_tracking_type_id' => $loan_tracking_type_id,
            'tracking_date' => Carbon::parse($tracking_date),
            'description' => $description
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Recurso creado correctamente',
            'data' => []
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return \Illuminate\Http\Response
     */
    public function show(LoanTracking $loan_tracking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanTracking $loan_tracking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanTracking  $loanTracking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanTracking $loan_tracking)
    {
        $validator = Validator::make($request->all(), [
            'loan_tracking_id' => 'required|integer',
            'loan_tracking_type_id' => 'required|integer',
            'loan_id' => 'required|integer',
            'tracking_date' => 'required|date',
            'description' => 'required|string|min:1'
        ]);

        if($validator->fails()) {
            $keys = $validator->errors()->keys();
            $errors = [];
            foreach($keys as $key) {
                $errors[$key] = $validator->errors()->get($key);
            }
            return response()->json([
                'error' => true,
                'message' => 'Error en la validación',
                'errors' => $errors,
                'data' => []
            ], 422);
        }

        $loan_tracking_id = $request->loan_tracking_id;
        $loan_tracking_type_id = $request->loan_tracking_type_id;
        // $loan_id = $request->loan_id;
        $user_id = auth()->id();
        $tracking_date = $request->tracking_date;
        $description = $request->description;
        $loan_tracking = LoanTracking::find($loan_tracking_type_id);
        $loan_tracking->update([
            'loan_tracking_type_id' => $loan_tracking_type_id,
            'tracking_date' => $tracking_date,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanTracking $loan_tracking)
    {
        $loan_tracking_id = $request->loan_tracking_id;
        // $loan_tracking
    }

    public function get_loan_trackings_types() {
        $loan_trackings_types = LoanTrackingType::where('is_valid', true)->select('id', 'sequence_number', 'name')->orderBy('sequence_number')->get();
        return response()->json([
            'error' => false,
            'message' => 'Listado de tipos de seguimiento de mora',
            'data' => $loan_trackings_types
        ]);
    }
}
