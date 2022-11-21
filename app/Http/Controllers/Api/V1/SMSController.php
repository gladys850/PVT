<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Util;
use App\Loan;

class SMSController extends Controller
{
    public function send_sms_for_contract(Request $request) {
        $loan_id = $request->loan_id;
        $user_id = $request->user_id;
        $message = "Favor apersonarse por las oficinas de MUSERPOL a objeto de firmar el contrato";        

        $with_guarantors = Loan::find($loan_id)->modality->loan_modality_parameter->guarantors;
        if($with_guarantors) {
            $cell_phone_number = Loan::find($loan_id)->borrower->first()->cell_phone_number;
            $cell_phone_number = Util::remove_special_char($cell_phone_number);
            // $cell_phone_number = '65148120';
            if(Util::delegate_shipping($cell_phone_number, $message, $loan_id)) {
                return response()->json([
                    'error' => false,
                    'message' => 'Se envío el SMS correctamente',
                    'data' => []
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Hubo un erro en el envío de SMS',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'error' => false,
                'message' => 'El préstamo no tiene garantes',
                'data' => []
            ]);
        }
    }
}
