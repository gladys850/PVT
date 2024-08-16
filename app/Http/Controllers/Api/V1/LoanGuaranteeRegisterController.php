<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LoanGuaranteeRegister;
use Carbon;

use Illuminate\Support\Facades\Auth;
class LoanGuaranteeRegisterController extends Controller
{
    /**
    * Registro Crear o Actualizar el array de Objeto Registro de Garantía de préstamos
    * @bodyParam affiliate_id integer ID required de afiliado. Example: 9  
    * @bodyParam role_id integer required rol con el que se realiza el registro Example: 89            
    * @bodyParam guarantees[0].id  integer required ID del registro de la tabla loans o prestamos.Example: 1
    * @bodyParam guarantees[0].type string required registro del nombre de las tablas tabla loans,prestamos. Example: PVT
    * @bodyParam guarantees[0].code string required codigo del prestamo perteneciente a la garantia Example: P-00001
    * @bodyParam guarantees[0].quota numeric required cuota del prestamo de los garantes Example: 10000.50
    * @bodyParam guarantees[1].id  integer required ID del registro de la tabla loans,prestamos.Example: 1
    * @bodyParam guarantees[1].type string required registro del nombre de las tablas tabla loans,prestamos. Example: SISMU
    * @bodyParam guarantees[1].code string required codigo del prestamo perteneciente a la garantia Example: P-00002
    * @bodyParam guarantees[1].quota numeric required cuota del prestamo de los garantes Example: 10000.50

    * @authenticated
    * @responseFile responses/loan_guarantee_register/updateOrCreateLoanGuaranteeRegister.200.json
    */
    public function updateOrCreateLoanGuaranteeRegister(Request $request) { 
          $request->validate([
            'affiliate_id' => 'required|integer|exists:affiliates,id',
            'role_id' => 'required|integer|exists:roles,id',
            'guarantees' => 'required|array'
          ]);
         $loan_guarantee_register_ids = collect();
          foreach ($request->guarantees as $loan_guarantee) {
              $guarantee_type = $loan_guarantee['type'];
              $loan_guarantee_register = new LoanGuaranteeRegister();
              $loan_guarantee_register->user_id = Auth::id();
              $loan_guarantee_register->role_id = $request->role_id;
              $loan_guarantee_register->guarantable_id = $loan_guarantee['id'];
              $loan_guarantee_register->guarantable_type = $loan_guarantee['type']=="SISMU" ? "prestamos":"loans";
              $loan_guarantee_register->affiliate_id = $request->affiliate_id;
              $loan_guarantee_register->amount = $loan_guarantee['eval_quota'];
              $loan_guarantee_register->loan_code_guarantee = $loan_guarantee['code'];
              $loan_guarantee_register->period_date = Carbon::now()->format('Y-m-d');
              $loan_guarantee_register->database_name = $guarantee_type;
              $loan_guarantee_exists = LoanGuaranteeRegister::where('affiliate_id',$request->affiliate_id)
                                                    ->where('guarantable_type',$loan_guarantee_register->guarantable_type)
                                                    ->where('guarantable_id',$loan_guarantee_register->guarantable_id)
                                                    ->where('loan_code_guarantee',$loan_guarantee_register->loan_code_guarantee)
                                                    ->where('period_date',$loan_guarantee_register->period_date)
                                                    ->where('database_name',$loan_guarantee_register->database_name)
                                                    ->whereNull('loan_id')->first();
              if($loan_guarantee_exists){
                $loan_guarantee_register_ids->push($loan_guarantee_exists->id);
              }else{
                 $loan_guarantee_register->save();
                 $loan_guarantee_register_ids->push($loan_guarantee_register->id);
              }                   
          }
          $loan_guarantee_register_ids = array('loan_guarantee_register_ids'=>$loan_guarantee_register_ids);
          return $loan_guarantee_register_ids;
      }
}
