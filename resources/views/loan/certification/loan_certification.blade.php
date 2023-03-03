<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$file_title}}</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>
@include('partials.header', $header)
<body>
@php ($plural = count($lenders) > 1)
@php ($n = 1)

<div class="block">
    <div class="font-semibold leading-tight text-center m-b-10 text-lg">{{ $title }}</div>
</div>

<div class="block text-justify">
    <div>
        El Área de Recuperación y Cobranzas de la Mutual de Servicios al Policía -- MUSERPOL, a petición del interesado (a), procedió a la revisión de la información registrada en el Sistema de Préstamos PVT.<br><br>
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">CERTIFICA QUE:</div>
        </div>
        @foreach ($lenders as $lender)
            El Sr. (a) {{$lender->full_name}} con Cédula de Identidad N° {{$lender->identity_card_ext}} registra descuentos a garante(s), de acuerdo al siguiente detalle:<br><br>
        @endforeach
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DEL PRÉSTAMO</div>
        </div>
        <div class="block">
            <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
                <tr class="bg-grey-darker text-white">
                    <td class="w-20">Código Tŕamite</td>
                    <td class="w-20">Fecha de desembolso</td>
                    <td class="w-20">Monto desembolsado</td>
                    <td class="w-20">Fecha Última Amortización</td>
                    <td class="w-20">Saldo a Capital</td>
                </tr>
                <tr>
                    <td class="data-row py-5">{{ $loan->code }}</td>
                    <td class="data-row py-5">{{ Carbon::parse($loan->disbursement_date)->format('d/m/Y')}}</td>
                    <td class="data-row py-5">{{ Util::money_format($loan->amount_approved) }} <span class="capitalize">Bs.</span></td>
                    <td class="data-row py-5">{{ Carbon::parse($loan->last_payment_validated->estimated_date)->format('d/m/Y')}}</td>
                    <td class="data-row py-5">{{ Util::money_format($loan->balance) }} <span class="capitalize">Bs.</span></td>
                </tr>
            </table>
        </div>
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++}}. DATOS DEL DESCUENTO</div>
        </div>
    </div>
</div>
<div style="width: 70%; margin:0 auto">
    <table>
        <tr>
            @php ($n = 1)
            @if ($guarantors_loan_payments_number === 1)
            <td>
                <table style="font-size:11px; margin:0 auto;" class="table-info w-50 text-center uppercase my-10">
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[0]['full_name']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[0]['identity_card']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td class="w-5">N°</td>
                        <td class="w-10">FECHA</td>
                        <td class="w-10">MONTO (Bs.)</td>
                    </tr>
                    <tr>
                    @php ($total = 0)
                    @foreach($guarantors_loan_payments[0]['payments'] as $payment)
                        <td class="data-row py-5">{{ $n++ }}</td>
                        <td class="data-row py-5">{{ Carbon::parse($payment->loan_payment_date)->format('d/m/Y') }}</td>
                        <td class="data-row py-5">{{ $payment->estimated_quota }}</td>
                    </tr>
                    @php ($total = $total + $payment->estimated_quota)
                    @endforeach
                    <tr>
                        <td colspan=2>TOTAL</td>
                        <td>{{ $total }} </td>
                    </tr>
                </table>
            </td>
            @elseif ($guarantors_loan_payments_number > 1) 
            @php ($n = 1)
            <td>
                <table style="font-size:11px; margin:0 auto;" class="table-info w-75 text-center uppercase my-10">
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[0]['full_name']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[0]['identity_card']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td class="w-5">N°</td>
                        <td class="w-10">FECHA</td>
                        <td class="w-10">MONTO (Bs.)</td>
                    </tr>
                    <tr>
                    @php ($total = 0)
                    @foreach($guarantors_loan_payments[0]['payments'] as $payment)
                        <td class="data-row py-5">{{ $n++ }}</td>
                        <td class="data-row py-5">{{ Carbon::parse($payment->loan_payment_date)->format('d/m/Y') }}</td>
                        <td class="data-row py-5">{{ $payment->estimated_quota }}</td>
                    </tr>
                    @php ($total = $total + $payment->estimated_quota)
                    @endforeach
                    <tr>
                        <td colspan=2>TOTAL</td>
                        <td>{{ $total }} </td>
                    </tr>
                </table>
            </td>
            @php ($n = 1)
            <td >
                <table style="font-size:11px; margin:0 auto;" class="table-info w-75 text-center uppercase my-10">
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[1]['full_name']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td colspan=3>{{$guarantors_loan_payments[1]['identity_card']}}</td>
                    </tr>
                    <tr class="bg-grey-darker text-white">
                        <td class="w-5">N°</td>
                        <td class="w-10">FECHA</td>
                        <td class="w-10">MONTO (Bs.)</td>
                    </tr>
                    <tr>
                    @php ($total = 0)
                    @foreach($guarantors_loan_payments[1]['payments'] as $payment)
                        <td class="data-row py-5">{{ $n++ }}</td>
                        <td class="data-row py-5">{{ Carbon::parse($payment->loan_payment_date)->format('d/m/Y') }}</td>
                        <td class="data-row py-5">{{ $payment->estimated_quota }}</td>
                    </tr>
                    @php ($total = $total + $payment->estimated_quota)
                    @endforeach
                    <tr>
                        <td colspan=2>TOTAL</td>
                        <td>{{ $total }} </td>
                    </tr>
                </table>
            </td>
            @endif
        </tr>
    </table>
    <br>
    <span style="font-size: 10px;" class="text-center">Es cuanto se certifica en honor a la verdad para fines consiguientes.</span>

</div>
<br>
</body>
</html>
