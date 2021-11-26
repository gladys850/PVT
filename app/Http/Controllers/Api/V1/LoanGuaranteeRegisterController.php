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
    * Registro de Garantía Actualizar o Crear el array de Objeto Registro de Garantía de préstamos
    * @bodyParam affiliate_id integer ID required de afiliado. Example: 9              
    * @bodyParam guarantees[0].id  integer required ID del registro de la tabla loans o prestamos.Example: 1
    * @bodyParam guarantees[0].type string required registro del nombre de las tablas tabla loans,prestamos. Example: prestamos
    * @bodyParam guarantees[0].type_affiliate enum required (lender,guarantor,cosigner) Example:guarantor
    * @bodyParam guarantees[0].quota numeric required cuota del prestamo de los garantes Example: 10000.50
    * @bodyParam guarantees[0].type_adjust enum required (loan_guarantee_register)  Example: loan_guarantee_register
    * @bodyParam guarantees[1].id  integer required ID del registro de la tabla loans,prestamos.Example: 1
    * @bodyParam guarantees[1].type string required registro del nombre de las tablas tabla loans,prestamos. Example: prestamos
    * @bodyParam guarantees[1].type_affiliate enum required (lender,guarantor,cosigner) Example:guarantor
    * @bodyParam guarantees[1].quota numeric required cuota del prestamo de los garantes Example: 10000.50
    * @bodyParam guarantees[1].type_adjust enum required (loan_guarantee_register)  Example: loan_guarantee_register
    
    * @authenticated
    * @responseFile responses/loan_contribution_adjust/updateOrCreateLoanGuaranteeRegister.200.json
    */
    public function updateOrCreateLoanGuaranteeRegister(Request $request) { 
          $request->validate([
            'affiliate_id' => 'required|integer|exists:affiliates,id',
            'role_id' => 'required|integer|exists:roles,id',
            'guarantees' => 'required|array'
          ]);
         $loan_contribution_guarantee_register_ids = collect();
          foreach ($request->guarantees as $loan_contribution_adjust) {
              $adjustable_type = $loan_contribution_adjust['type'];
              $loan_contribution_guarantee_register = new LoanGuaranteeRegister();
              $loan_contribution_guarantee_register->user_id = Auth::id();
              $loan_contribution_guarantee_register->role_id = $request->role_id;
              $loan_contribution_guarantee_register->guarantable_id = $loan_contribution_adjust['id'];
              $loan_contribution_guarantee_register->guarantable_type = $loan_contribution_adjust['type']=="SISMU" ? "prestamos":"loans";
              $loan_contribution_guarantee_register->affiliate_id = $request->affiliate_id;
              $loan_contribution_guarantee_register->amount = $loan_contribution_adjust['quota'];
              $loan_contribution_guarantee_register->loan_code_guarantee = $loan_contribution_adjust['code'];
              $loan_contribution_guarantee_register->period_date = Carbon::now()->format('Y-m-d');
              $loan_contribution_guarantee_register->database_name = $adjustable_type;
              $adjust_contribution = LoanGuaranteeRegister::where('affiliate_id',$request->affiliate_id)
                                                    ->where('guarantable_type',$loan_contribution_guarantee_register->guarantable_type)
                                                    ->where('guarantable_id',$loan_contribution_guarantee_register->guarantable_id)
                                                    ->where('loan_code_guarantee',$loan_contribution_guarantee_register->loan_code_guarantee)
                                                    ->where('period_date',$loan_contribution_guarantee_register->period_date)
                                                    ->where('database_name',$loan_contribution_guarantee_register->database_name)
                                                    ->whereNull('loan_id')->first();  
            //return $adjust_contribution;                           
              if($adjust_contribution){
                  $adjust_contribution->update();
                  $loan_contribution_guarantee_register_ids->push($adjust_contribution->id);
              }else{
                 $loan_contribution_guarantee_register->save();
                 $loan_contribution_guarantee_register_ids->push($loan_contribution_guarantee_register->id);
              }                   
          }
          $loan_contribution_guarantee_register_ids= array('loan_contribution_guarantee_register_ids'=>$loan_contribution_guarantee_register_ids);
          return $loan_contribution_guarantee_register_ids;
      }
}
