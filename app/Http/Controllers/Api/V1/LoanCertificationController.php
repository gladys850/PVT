<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Loan;
use App\Helpers\Util;
use Illuminate\Support\Facades\Auth;
use Carbon;
use App\LoanPayment;
use App\Affiliate;
use App\LoanGuarantor;
use App\Spouse;

class LoanCertificationController extends Controller
{
    /** @group Certificado de devolucíón a garante
   * Imprimir certificado de devolución a garante mora
   * Imprimir certificado de devolución a garante mora
   * @urlParam loan_id required ID de prestamo. Example: 3515
   * @urlParam guarantors Array de ids de garantes. Example: [29200, 21292]
   * @authenticated
   * @responseFile responses/warranty_discount_certification/print.200.json
   */
    public function print_warranty_discount_certification(Request $request, Loan $loan, $standalone = true) {
        $file_title = implode('_', ['CERTIFICACIÓN DESCUENTO POR GARANTÍA', 'PRÉSTAMO', $loan->code, Carbon::now()->format('m/d')]);
        $lenders = [];
        array_push($lenders, $loan->borrower->first());
        $information_loan = $loan->code;
        $guarantors = $request->guarantors;
        $payments_guarantors = collect();

        foreach($guarantors as $guarantor) {
            $payments_guarantor = $loan->payments()->whereStateId(4)->wherePaidBy('G')->whereAffiliateId($guarantor)->select('loan_payment_date', 'estimated_quota')->get();
            $guarantor_data = LoanGuarantor::whereLoanId($loan->id)->whereAffiliateId($guarantor)->first();
            logger($guarantor_data);
            $full_name_guarantor = $guarantor_data->full_name;
            $identity_card_guarantor = $guarantor_data->identity_card_ext;
            $payments_guarantors->push(
                [
                    'affiliate_id' => $guarantor,
                    'full_name' => $full_name_guarantor,
                    'identity_card' => $identity_card_guarantor,
                    'payments' => $payments_guarantor
                ]
            );
        }

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
            'title' => 'CERTIFICADO DE DESCUENTOS POR GARANTÍA',
            'loan' => $loan,
            'lenders' => collect($lenders),
            'guarantors_loan_payments' => $payments_guarantors,
            'guarantors_loan_payments_number' => count($payments_guarantors),
            'file_title' => $file_title
        ];
        $file_name = implode('_', ['certificación', 'garantía', $loan->code]) . 'pdf';
        $view = view()->make('loan.certification.loan_certification')->with($data)->render();
        if($standalone) return Util::pdf_to_base64([$view], $file_name, $information_loan, 'letter', $request->copies ?? 1);
        return $view;
    }
}
