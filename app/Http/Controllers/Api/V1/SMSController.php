<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Util;
use App\Loan;

/** @group Notificaciones
* Datos de los trámites de préstamos y sus relaciones
*/


class SMSController extends Controller
{
    /**
    * Notificación mediante SMS
    * Devuelve una respuesta de confirmación
    * @bodyParam loan_id integer required id del préstamo. Example:4925
    * @bodyParam user_id integer required id del usuario. Example: 876
    * @responseFile responses/notification/sms_contracts.200.json
    */
    public function send_sms_for_contract(Request $request) {
        $loan_id = $request->loan_id;
        $user_id = $request->user_id;
        $message = "Favor apersonarse por las oficinas de MUSERPOL a objeto de firmar el contrato";        

        $cell_phone_number = Loan::find($loan_id)->borrower->first()->cell_phone_number;
        $cell_phone_number = Util::remove_special_char($cell_phone_number);
        $cell_phone_number = '65148120';
        if(Util::delegate_shipping($cell_phone_number, $message, $loan_id, $user_id)) {
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
    }
}
