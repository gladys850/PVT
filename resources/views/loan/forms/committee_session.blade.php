<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$file_title}}</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>
@include('partials.header', $header)
<body>
    <div class="block text-xs">
        <div class="font-semibold leading-tight text-center m-b-10">
            <font style="text-transform: uppercase;">{{ $header['direction'] }}</font>
        </div>
        <div class="font-semibold leading-tight text-center m-b-10">
            <font style="text-transform: uppercase;">ACTA DE COMITÉ DE PRÉSTAMOS</font>
        </div>
        <div class="font-semibold leading-tight text-center m-b-10">
            <font style="text-transform: uppercase;">MUSERPOL</font>
        </div>
    </div>
    <table style="font-size:14px;" class="my-5">
            <tr>
                <td class="w-25">
                </td>
                <td class="w-50">
                </td>
                <td class="font-semibold w-25">
                    <div class="font-semibold leading-tight rounded-full text-center text-xxxs">A.C.P./DESI/N°0{{ $code }}/2022 </div>
                </td>
            </tr>
        </table>
    <br>
    <div class="block text-justify  text-xs">
        <div>
        <b>ANTECEDENTES.- </b>Que de acuerdo al decreto supremo 1446 de fecha 19 de diciembre de 2012, se crea la Mutual de Servicios al Policia (MUSERPOL), Habiendose aprobado el Reglamento de Préstamos mediante Resolucion de Directorio N° 07/2019 del 21 de marzo del 2019 y que segun Resolución Administrativa n° 011/2022 de fecha 01 de febrero de 2022, se designo al comité de préstamos, conformado por la Directora de Estrategias Sociales e Inversiones, el jefe de la unidad de Inversion y Prestamos, la profesional Legal de Préstamos, la Responsable de Registro y control y Recuperacion de Préstamos y la profesional de Calificacion de Préstamos.
        Por todo lo expuesto, la Direccion de Estrategias Sociales e Inversiones, procedio a la instalacion de la <b><span class="uppercase">{{ $session }} SESSION DEL COMITÉ DE APROBACIÓN DE PRÉSTAMOS</span></b>, llevado a cabo en fecha {{ Carbon::now()->isoFormat('LL') }}, en oficinas de la MUSERPOL Av. 6 de Agosto entre Rosendo Gutierrez y Belisario Salinas N° 2354, bajo el siguiente orden del día:
        </div>
        <br>
        <div class="text-center">
            <b>1. Solicitud de Préstamo - {{ $loan->code }}</b>
        </div>
        <br>
        <div>
            <b>"CONSIDERACION DE LA SOLICITUD DE PRÉSTAMO {{ $borrower->gender == 'M' ? 'DEL' : 'DE LA' }} {{ $borrower->gender == 'M' ? 'SEÑOR.' : 'SEÑORA' }} {{ $loan->borrower->first()->full_name }}"</b>
        </div>
        <div>
            En atención a solicitud de préstamo realizado por {{ $borrower->gender == 'M' ? 'EL' : 'La' }} {{ $borrower->gender == 'M' ? 'Sr.' : 'Sra' }} {{ $loan->borrower->first()->full_name }} en fecha {{ Carbon::parse($loan->request_date)->isoFormat('LL') }} del año en curso, se se asigno mediante el sistema el {{ $loan->code }} al presente tramite y se califico la suma de Bs. {{ Util::money_format($loan->amount_requested) }} (<span class="uppercase">{{ Util::money_format($loan->amount_requested, true) }} Bolivianos)</span> de acuerdo al Reglamento de Préstamos vigente. A objeto del mismo el Comite de la Direccion de Estrategias Sociales e Inversiones determino que: verificado los documentos presentados
            para la solicitud de préstamo. considerando la capacidad de pago evaluado el caso se concluyo en la <b>APROBACIÓN DEL PRÉSTAMO</b> por la suma de 
            @if($is_refinancing)
                <b>Bs. {{ Util::money_format($loan->amount_approved - $previous_loan_balance) }}</b> (<span class="uppercase">{{ Util::money_format($loan->amount_approved - $previous_loan_balance, true) }} Bolivianos</span>)
            @else
                <b>Bs. {{ Util::money_format($loan->amount_approved) }}</b> (<span class="uppercase">{{ Util::money_format($loan->amount_approved, true) }} Bolivianos)</span>,
            @endif
            @if ($is_refinancing)
                para lo cual el prestatario reconoce de manera expresa el saldo anterior de la deuda correspondiente al préstamo contraido con anterioridad, que asciende a la suma de 
                Bs. {{ Util::money_format($previous_loan_balance) }} (<span class="uppercase">{{ Util::money_format($previous_loan_balance, true) }} Bolivianos)</span>,
                montos que hacen un total efectivo de Bs. {{ Util::money_format($loan->amount_approved) }}, que representa la nueva obligacion contraida sujeta a cumplimiento,
            @endif
            el cual deberá amortizar en un plazo de {{ $loan->loan_term}} meses con una cuota mensual de Bs. {{ Util::money_format($loan->estimated_quota) }} (<span class="uppercase">{{ Util::money_format($loan->estimated_quota, true) }} Bolivianos)</span>.
        </div>
        <br>
        <div>
            Con lo que concluó la sesion, firmando al pie del presente documento las siguientes personas:
        </div>
    </div>
    <br>
    <br>
    <div class="align-top">
        <div class="block text-xxxs">
            <table>
                <tr class="font-semibold leading-tight text-center m-b-10 text-sm">
                    <td class="border-b" >Miembros del Comité</td>
                    <td class="border-b">FIRMA</td>
                </tr>
                @foreach ($employees as  $key => $employee)
                    <tr class="w-10">
                        <td class="font-semibold leading-tight text-center m-b-10 text-xxs border-b height: 100px">
                        {{ $employee['name'] }}
                        </td>
                        <td class="border-b">
                            <div class='text-center m-t-50'>
                                <div>
                                    <hr style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;" width="250px">
                                </div>
                                <div>
                                    {{ $employee['name'] }}
                                </div>
                                <div class="font-bold">
                                    {{ $employee['position'] }}
                                </div>
                                <div>
                                    MUSERPOL
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
        </div>
    </div>
</body>
</html>
