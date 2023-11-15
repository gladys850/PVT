<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\LoanTracking;
use Illuminate\Http\Request;
use App\LoanTrackingType;
use Carbon;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Util;
use Illuminate\Support\Facades\Auth;
use App\Loan;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArchivoPrimarioExport;

class LoanTrackingController extends Controller
{
    /** @group Seguimiento de mora
    * Listar seguimiento de mora
    * Listar el seguimiento de mora de un préstamo
    * @queryParam page integer página. Example: 1
    * @queryParam per_page integer por página. Example: 2
    * @queryParam loan_id integer required ID del préstamo. Example: 1
    * @responseFile responses/delay_tracking_loan/index.200.json
    */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'required|integer',
            'loan_id' => 'required|integer|exists:loans,id'
        ]);
        $page =  $request->page ?? 1;
        $loan_id = $request->loan_id;
        $pagination = $request->per_page ?? 10;

        $loan_tracking_delays = Loan::find($loan_id)->loan_tracking()->get();
        foreach($loan_tracking_delays->values() as $loan_tracking_delay) {
            $loan_tracking_delay->is_last_loan_tracking = false;
            $user_id = $loan_tracking_delay->user_id;
            $loan_tracking_type_id = $loan_tracking_delay->loan_tracking_type_id;
            $loan_tracking_delay->user = User::find($user_id);
            $loan_tracking_delay->loan_tracking_type = LoanTrackingType::find($loan_tracking_type_id);
        }
        $loan_tracking_delays->values()->last()['is_last_loan_tracking'] = true;

        $loan_tracking_delays_removed = Loan::find($loan_id)->loan_tracking()->onlyTrashed()->get();
        foreach($loan_tracking_delays_removed as $loan_tracking_delay_removed) {
            $user_id = $loan_tracking_delay_removed->user_id;
            $loan_tracking_type_id = $loan_tracking_delay_removed->loan_tracking_type_id;
            $loan_tracking_delay_removed->user = User::find($user_id);
            $loan_tracking_delay_removed->loan_tracking_type = LoanTrackingType::find($loan_tracking_type_id);
        }

        $loan_tracking_delays_removed = new LengthAwarePaginator($loan_tracking_delays_removed->forPage($page, $pagination)->values(), $loan_tracking_delays_removed->count(), $pagination, $page);
        $loan_tracking_delays = new LengthAwarePaginator($loan_tracking_delays->forPage($page, $pagination)->values(), $loan_tracking_delays->count(), $pagination, $page);
        return response()->json([
            'error' => false,
            'message' => 'Listado del seguimiento de un préstamo en mora',
            'data' => [
                'loan_tracking_delays_removed' => $loan_tracking_delays_removed,
                'loan_tracking_delays' => $loan_tracking_delays
            ]
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

    /** @group Seguimiento de mora
    * Creación de un seguimiento de mora
    * Creación de un seguimiento de un préstamo en mora
    * @bodyParam loan_tracking_type_id integer required id del tipo de seguimiento de mora. Example: 1
    * @bodyParam loan_id integer required id préstamo. Example: 1
    * @bodyParam tracking_date date required fecha de seguimiento. Example: '02-02-2023'
    * @bodyParam description date descripción del seguimiento. Example: 'Se realizó la llamada correspondiente'
    * @responseFile responses/delay_tracking_loan/store.201.json
    */
    public function store(Request $request)
    {
        $request->validate([
            'loan_tracking_type_id' => 'required|integer|exists:loan_tracking_types,id',
            'loan_id' => 'required|integer|exists:loans,id',
            'tracking_date' => 'required|date',
            'description' => 'string|min:1'
        ]);

        $user_id = Auth::user()->id;
        $request->merge(['user_id' => $user_id]);
        LoanTracking::create($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Recurso creado correctamente',
            'data' => []
        ], 201);
    }

    /** @group Seguimiento de mora
    * Obtener un registro de seguimiento de mora
    * Obtención de datos de un seguimiento de un préstamo en mora
    * @urlParam loan_tracking_delay required ID del seguimiento de préstamo en mora. Example: 8
    * @responseFile responses/delay_tracking_loan/show.200.json
    */
    public function show(LoanTracking $loan_tracking_delay)
    {
        return response()->json([
            'error' => false,
            'message' => 'Datos de seguimiento de préstamo en mora',
            'data' => [
                'loan_tracking_delay' => $loan_tracking_delay
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanTracking $loan_tracking_delay)
    {
        //
    }

    /** @group Seguimiento de mora
    * Actualización de un seguimiento de mora
    * Actualización de un seguimiento de un préstamo en mora
    * @urlParam loan_tracking_delay required ID del seguimiento de préstamo en mora. Example: 6
    * @bodyParam loan_tracking_type_id required integer id del tipo de seguimiento de mora. Example: 2
    * @bodyParam loan_id integer required id préstamo. Example: 3
    * @bodyParam tracking_date date fecha de seguimiento. Example: '2023-02-03'
    * @bodyParam description date descripción del seguimiento. Example: 'alguna descripción larga'
    * @responseFile responses/delay_tracking_loan/update.200.json
    */
    public function update(Request $request, LoanTracking $loan_tracking_delay)
    {
        $request->validate([
            'loan_tracking_type_id' => 'required|integer|exists:loan_tracking_types,id',
            'loan_id' => 'required|integer|exists:loans,id',
            'tracking_date' => 'required|date',
            'description' => 'string|min:1'
        ]);

        $user_id = Auth::user()->id;
        $request->merge(['user_id' => $user_id]);
        $loan_tracking_delay->fill($request->all());
        $loan_tracking_delay->save();

        return response()->json([
            'error' => false,
            'message' => 'Se actualizó el registro satisfactoriamente',
            'data' => [
                'loan_tracking_delay' => $loan_tracking_delay
            ]
        ]);
    }

    /** @group Seguimiento de mora
     * Eliminar seguimiento mora
     * Eliminar seguimiento de mora de préstamo
     * @urlParam loan_tracking_delay required ID del tipo de seguimiento de préstamo en mora. Example: 6
     * @responseFile responses/delay_tracking_loan/destroy.200.json
    */
    public function destroy(LoanTracking $loan_tracking_delay)
    {
        $loan_tracking_delay->delete();
        return response()->json([
            'error' => false,
            'message' => 'Se eliminó el registro de la tabla',
            'data' => [ 'loan_tracking' => $loan_tracking_delay]
        ]);
    }

    /** @group Seguimiento de mora
     * Obtener los tipos de seguimiento de mora
     * Obtiene los tipos de seguimiento de mora de un préstamo
     * @responseFile responses/delay_tracking_loan/get_loan_trackings_types.200.json
    */
    public function get_loan_trackings_types() {
        $loan_trackings_types = LoanTrackingType::where('is_valid', true)->select('id', 'sequence_number', 'name')->orderBy('sequence_number')->get();
        return response()->json([
            'error' => false,
            'message' => 'Listado de tipos de seguimiento de mora',
            'data' => $loan_trackings_types
        ]);
    }
    /** @group Seguimiento de mora
   * Imprimir seguimiento mora
   * Imprimir seguimiento mora de préstamo
   * @urlParam note required ID de prestamo. Example: 50
   * @authenticated
   * @responseFile responses/delay_tracking_loan/print.200.json
   */
   public function print_delay_tracking(Loan $loan, $standalone = true)
   {
       $file_title = implode('_', ['SEGUIMIENTO MORA','PRESTAMO', $loan->code,Carbon::now()->format('m/d')]);
       $lenders = [];
       $loan_trackings = collect($loan->loan_tracking);
       array_push($lenders, $loan->borrower->first());
       $information_loan= $loan->code;
       $data = [
           'header' => [
               'direction' => 'DIRECCIÓN DE ESTRATEGIAS SOCIALES E INVERSIONES',
               'unity' => 'UNIDAD DE INVERSIÓN EN PRÉSTAMOS',
               'table' => [
                   ['Área', 'COBRANZAS'],
                   ['Modalidad', $loan->modality->shortened],
                   ['Fecha', Carbon::now()->format('d/m/Y')],
                   ['Usuario',Auth::user()->username]
               ]
           ],
           'title' => 'REPORTE DE SEGUIMIENTO DE MORA',
           'loan' => $loan,
           'lenders' => collect($lenders),
           'loan_trackings'=>$loan_trackings,
           'file_title' => $file_title
       ];
       $file_name = implode('_', ['seguimiento', 'mora', $loan->code]) . '.pdf';
       $view = view()->make('loan.tracking.delay_tracking')->with($data)->render();
       if ($standalone) return Util::pdf_to_base64([$view], $file_name,$information_loan, 'letter', $request->copies ?? 1);
       return $view;
   }
   public function download_delay_tracking(Loan $loan, $standalone = true)
   {
        $loan_trackings = collect($loan->loan_tracking);
        $loan_trackings_array = collect([]);
        $loan_tracking_sheets = array(
            array("Nro","Fecha de Acción", "Usuario", "Tipo de seguimiento", "Comentario", "Fecha de registro")
        );
        $c=0;
        foreach($loan_trackings as $loan_tracking){
            $c = $c+1;
            $loan_trackings_array->push([
                $user = User::where('id',$loan_tracking->user_id)->first(),
                $loan_tracking_type = LoanTrackingType::where('id', $loan_tracking->loan_tracking_type_id)->first(),
                "count"=>$c,
                "tracking_date"=>Carbon::parse($loan_tracking->tracking_date)->format('d/m/Y'),
                "user_name"=>$user->username,
                "loan_tracking_type_name"=>$loan_tracking_type->name,
                "description"=>$loan_tracking->description,
                "updated_at"=>Carbon::parse($loan_tracking->updated_at)->format('d/m/Y')
            ]);
        }
        
        $loan_trackings_array = $loan_trackings_array->sortBy('loan_tracking_type_name');

        foreach($loan_trackings_array as $tracking)
        {
            array_push($loan_tracking_sheets,array(
                $tracking['count'],
                $tracking['tracking_date'],
                $tracking['user_name'],
                $tracking['loan_tracking_type_name'],
                $tracking['description'],
                $tracking['updated_at'],
            ));

        }
        $file_name = "Seguimiento de mora";
        $export = new ArchivoPrimarioExport($loan_tracking_sheets);
        return Excel::download($export, $file_name.'.xls');
   }
}
