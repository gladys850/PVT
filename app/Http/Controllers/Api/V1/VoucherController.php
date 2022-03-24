<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Voucher;
use App\LoanState;
use App\Loan;
use App\LoanPaymentState;
use Illuminate\Http\Request;
use App\Http\Requests\VoucherForm;
use Util;
use Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\V1\LoanController;
use App\Affiliate;
use App\LoanPayment;
use App\Exports\ArchivoPrimarioExport;
use Maatwebsite\Excel\Facades\Excel;

/** @group Tesoreria
* Datos de los registros de cobros
*/
class VoucherController extends Controller
{
    public static function append_data(Voucher $voucher)
    {
        $voucher->payable;
        $voucher->voucher_type = $voucher->voucher_type;
        
        return $voucher;
    }

    /**
    * Listado de cobros
    * Devuelve el listado con los datos paginados
    * @queryParam loan_payment_id Filtro por id de cobro. Example: 2
    * @queryParam loan_payments Filtro por tipo de cobro. Example: loan_payments
    * @queryParam search Parámetro de búsqueda. Example: TRANS000001-2020
    * @queryParam sortBy Vector de ordenamiento. Example: [created_at]
    * @queryParam sortDesc Vector de orden descendente(true) o ascendente(false). Example: [false]
    * @queryParam per_page Número de datos por página. Example: 1
    * @queryParam page Número de página. Example: 1
    * @authenticated
    * @responseFile responses/voucher/index.200.json
    */
    public function index(Request $request)
    {
        $filter = [];
        if ($request->has('loan_payments')) {
            $filter['payable_type'] = "loan_payments";
        }
        if ($request->has('loan_payment_id')) {
            $filter['payable_id'] = $request->loan_payment_id;
            $filter['payable_type'] = "loan_payments";
        }
       
        $data = Util::search_sort(new Voucher(), $request, $filter);
        $data->getCollection()->transform(function ($voucher) {
            return self::append_data($voucher);
        });
        return $data;
    }
    /**
    * Detalle de registro de cobro
    * Devuelve el detalle de un voucher mediante su ID
    * @urlParam voucher required ID de voucher. Example: 1
    * @authenticated
    * @responseFile responses/voucher/show.200.json
    */
    public function show(Voucher $voucher)
    {
        return $voucher;
    }


    /**
    * Editar registro de cobro
    * Edita el Pago realizado.
    * @urlParam voucher required ID del registro de pago. Example: 2
    * @bodyParam voucher_type_id integer required ID de tipo de voucher. Example: 1
    * @bodyParam voucher_number integer número de voucher. Example: 12354121
	* @bodyParam description string Texto de descripción. Example: Penalizacion regularizada
    * @authenticated
    * @responseFile responses/voucher/update.200.json
    */
    public function update(VoucherForm $request, Voucher $voucher)
    {
        if (Auth::user()->can('update-payment')) {
            $update = $request->only('voucher_type_id', 'description', 'voucher_number');
        }
        $voucher->fill($update);
        $voucher->save();
        return  $voucher;
    }

    /**
    * Anular registro de Vaucher
    * @urlParam voucher required ID del pago. Example: 1
    * @authenticated
    * @responseFile responses/voucher/destroy.200.json
    */
    public function destroy(Voucher $voucher)
    {
        $payable_type = Voucher::findOrFail($voucher->id);
        if($payable_type->payable_type = "loan_payments")
        {
            $state_pendiente = LoanPaymentState::whereName('Pendiente de Pago')->first();
            $state_pagado =  LoanPaymentState::whereName('Pagado')->first();
            if($voucher->payable->state_id == $state_pendiente->id){
                $loanPayment = $voucher->payable;
                $loanPayment->state()->associate($state_pendiente);
                $loanPayment->save();
                $voucher->delete();
                }elseif($voucher->payable->state_id = $state_pagado->id){
                    if(Auth::user()->can('delete-voucher-paid')) {
                        $loanPayment = $voucher->payable;
                        $loanPayment->state()->associate($state_pagado);
                        $loanPayment->save(); 
                        $voucher->delete(); 
                        }  else return $message['validate'] = "El usuario no tiene los permisos necesarios para realizar la eliminación" ;
                    }
        }
        return $voucher;
    }
      /**
    * Anular registro de vaucher y registro de cobro
    * @urlParam voucher required ID del vaucher. Example: 1
    * @authenticated
    * @responseFile responses/voucher/delete_voucher_payment.200.json
    */
    public function delete_voucher_payment($id_payment){
        $voucher = Voucher::findOrFail($id_payment);
        if($voucher->payable_type = "loan_payments")
        {
            $state = LoanPaymentState::whereName('Anulado')->first();
            $loan_payment = $voucher->payable;
            $loan_payment->state()->associate($state);
            $loan_payment->save();
            $loan_payment->delete();
        }
        $voucher->delete();
        return $voucher;

    } 
    /** @group Tesoreria
    * Impresión del Voucher de Pago
    * Devuelve un pdf del Voucher acorde a un ID de pago
    * @urlParam voucher required ID del pago. Example: 2
    * @queryParam copies Número de copias del documento. Example: 2
    * @authenticated
    * @responseFile responses/voucher/print_voucher.200.json
    */

    public function print_voucher(Request $request, Voucher $voucher, $standalone = true)
    {
        $loan_payment=LoanPayment::find($voucher->payable_id);
        $loan = Loan::find($loan_payment->loan_id);
        $affiliate = Affiliate::findOrFail($loan_payment->affiliate_id);
        $lenders = [];
        $lenders[] = LoanController::verify_loan_affiliates($affiliate,$loan)->disbursable;
        $data = [
            'header' => [
                'direction' => 'DIRECCIÓN DE ESTRATEGIAS SOCIALES E INVERSIONES',
                'unity' => 'UNIDAD DE INVERSIÓN EN PRÉSTAMOS',
                'table' => [
                    ['Código', $voucher->code],
                    ['Fecha', Carbon::now()->format('d/m/Y')],
                    ['Hora', Carbon::now()->format('h:m:s a')],
                    ['Usuario', Auth::user()->username]
                ]
            ],
            'title' => 'RECIBO OFICIAL',
            'voucher' => $voucher,
            'lenders' => collect($lenders),
            'loan_payment'=>$loan_payment
        ];
        $information= $this->get_information_loan($voucher);
        $file_name = implode('_', ['voucher', $voucher->code]) . '.pdf';
        $view = view()->make('loan.payments.payment_voucher')->with($data)->render();
        if ($standalone) return Util::pdf_to_base64([$view], $file_name, $information, 'letter', $request->copies ?? 1);
        return $view;
    }

    public function get_information_loan(Voucher $voucher)
    {
        $file_name='';
        if($voucher->payable_type == 'loan_payments'){
            $loan = LoanPayment::findOrFail($voucher->payable_id)->loan;
            $lend='';
            foreach ($loan->lenders as $lender) {
                $lenders[] = LoanController::verify_loan_affiliates($lender,$loan)->disbursable;
            }
            foreach ($lenders as $lender) {
                $lend=$lend.'*'.' ' . $lender->full_name;
            }

            $loan_affiliates= $loan->loan_affiliates[0]->first_name;
            $file_name =implode(' ', ['Información:',$loan->code,$loan->modality->name,$lend]);
        }
        return $file_name;
    }

   /** @group Tesoreria
   * Listado de Vouchers con filtros
   * Lista todos los vouchers con opcion a busquedas
   * @queryParam sortDesc Vector de orden descendente(0) o ascendente(1). Example: 0
   * @queryParam trashed_voucher Para filtrar Anulado(true)  o Pagado(false). Example: true
   * @queryParam per_page Número de datos por página. Example: 8
   * @queryParam excel Valor booleano para descargar  el docExcel. Example: true
   * @queryParam code_voucher  Buscar por código de Voucher. Example: TRANS000001-2021
   * @queryParam code_loan_payment  Buscar por registro de cobro. Example: PAY000667-2021
   * @queryParam payment_date_voucher Buscar por fecha de pago. Example: 24/09/2021
   * @queryParam voucher_type_loan_payment  Buscar por tipo de pago. Example: Depósito Bancario
   * @queryParam bank_pay_number_voucher Buscar por nro de depósito bancario. Example: 82851806
   * @queryParam full_name_borrower Buscar por nombre completo del Prestatario. Example: JUAN ISRAEL YAVINCHA CONDORI 
   * @queryParam identity_card_borrower  Buscar por nro de CI del Prestatario. Example: 9257936
   * @queryParam code_loan Buscar por código de Préstamo. Example: PTMO000022-2021
   * @authenticated
   * 
   * @responseFile responses/voucher/index_voucher.200.json    
   */

  public function index_voucher(Request $request)
  {
      // aumenta el tiempo máximo de ejecución de este script a 150 min:
      ini_set('max_execution_time', 9000);
      // aumentar el tamaño de memoria permitido de este script:
      ini_set('memory_limit', '960M');

      if ($request->has('excel')) {
          $excel = $request->boolean('excel');
      } else {
          $excel =false;
      }

      $order = request('sortDesc') ?? '';
      if ($order != '') {
          if ($order) {
              $order_voucher = 'Asc';
          }
          if (!$order) {
              $order_voucher = 'Desc';
          }
      } else {
          $order_voucher = 'Desc';
      }

      if ($request->has('trashed_voucher')) {
         $trashed_voucher = $request->boolean('trashed_voucher');
          if (!$trashed_voucher) {
              $trashed_voucher = false;
          }
          if ($trashed_voucher) {
              $trashed_voucher = true;
          }
      } else {
          $trashed_voucher = false;
      }
      $pagination_rows = request('per_page') ?? 10;
      $conditions = [];
      //filtros
      $code_voucher = request('code_voucher') ?? '';
      $states_loan_payment = request('states_loan_payment') ?? '';

      // filtros borrower
      $identity_card_borrower = request('identity_card_borrower') ?? '';//CI
      $full_name_borrower = request('full_name_borrower') ?? '';//FULL NAME
      //fin filtros borrower

      $code_loan_payment = request('code_loan_payment') ?? '';
      $payment_date_voucher = request('payment_date_voucher') ?? '';
      $voucher_type_loan_payment= request('voucher_type_loan_payment') ?? '';   
      $bank_pay_number_voucher = request('bank_pay_number_voucher') ?? '';
      $total_voucher = request('total_voucher') ?? '';
      $code_loan = request('code_loan') ?? '';//CODE LOAN

              if ($code_voucher != '') {
                  array_push($conditions, array('view_loan_amortizations.code_voucher', 'ilike', "%{$code_voucher}%"));
              }
              if ($states_loan_payment != '') {
                array_push($conditions, array('view_loan_amortizations.states_loan_payment ', 'ilike', "%{$states_loan_payment}%"));
              }

              if ($identity_card_borrower != '') {
                array_push($conditions, array('view_loan_amortizations.identity_card_borrower', 'ilike', "%{$identity_card_borrower}%"));
              }    
              if ($full_name_borrower != '') {
                array_push($conditions, array('view_loan_amortizations.full_name_borrower', 'ilike', "%{$full_name_borrower}%"));
              }

            if ($code_loan_payment != '') {
                array_push($conditions, array('view_loan_amortizations.code_loan_payment', 'ilike', "%{$code_loan_payment}%"));
            }

            if ($payment_date_voucher != '') {
                array_push($conditions, array('view_loan_amortizations.payment_date_voucher', 'ilike', "%{$payment_date_voucher}%"));
            }
            if ($voucher_type_loan_payment != '') {
                array_push($conditions, array('view_loan_amortizations.voucher_type_loan_payment', 'ilike', "%{$voucher_type_loan_payment}%"));
            }
            if ($bank_pay_number_voucher != '') {
                array_push($conditions, array('view_loan_amortizations.bank_pay_number_voucher ', 'ilike', "%{$bank_pay_number_voucher}%"));
            }
            if ($total_voucher != '') {
                array_push($conditions, array('view_loan_amortizations.total_voucher', 'ilike', "%{$total_voucher}%"));
            }
            if ($code_loan != '') {
                array_push($conditions, array('view_loan_amortizations.code_loan', 'ilike', "%{$code_loan}%"));
            }
                       
              if ($trashed_voucher) {
                  array_push($conditions, array('view_loan_amortizations.states_loan_payment', 'like', "Anulado"));
              }else{
                 array_push($conditions, array('view_loan_amortizations.states_loan_payment', '=', "Pagado"));
              }

              $modality_shortened_loan_payment = array_push($conditions, array('view_loan_amortizations.modality_shortened_loan_payment', '=','DIRECTO'));
              
              if ($excel==true) {
                  $list_voucher = DB::table('view_loan_amortizations')
                      ->where($conditions)
                      ->select('*')
                      ->orderBy('code_voucher', $order_voucher)
                      ->get();

                  $File="ListadoVouchers";
                  $data=array(
                      array("CODIGO","CI PRESTATARIO","NOMBRE COMPLETO","REG COBRO","FECHA PAGO", "TIPO PAGO", "NRO DEPOSITO", "TOTAL PAGO", 
                       "COD PRESTAMO" )
                  );
            foreach ($list_voucher as $row){
                 array_push($data, array(
                     $row->code_voucher,
                     $row->identity_card_borrower,
                     $row->full_name_borrower,
                     $row->code_loan_payment,
                     Carbon::parse($row->payment_date_voucher)->format('d/m/Y'),
                     $row->voucher_type_loan_payment,
                     $row->bank_pay_number_voucher,
                     $row->total_voucher,
                     $row->code_loan
                 ));
            }
                  $export = new ArchivoPrimarioExport($data);
                  return Excel::download($export, $File.'.xls');
              } else {
                      $list_voucher = DB::table('view_loan_amortizations')
                      ->where($conditions)
                      ->select('*')
                      ->orderBy('code_voucher', $order_voucher)
                      ->paginate($pagination_rows);
                  return $list_voucher;
              }
          }





}
