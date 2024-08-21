<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PLATAFORMA VIRTUAL ADMINISTRATIVA - MUSERPOL </title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>
@include('partials.header', $header)
@php
    if($loan->parent_loan_id != null){
        $oficial_loan = 'parent_loan';
        $comodin = '';
    }else{
        $oficial_loan = 'data_loan';
        $comodin = ' SISMU';
    }
@endphp
<body>
<div class="block">
    <div class="font-semibold leading-tight text-center m-b-10 text-base">
        ADENDA AL CONTRATO DE PRÉSTAMO POR REPROGRAMACIÓN AL CONTRATO <font style="text-transform: uppercase;">{{$loan->$oficial_loan->code.$comodin}}</font>
        <div> {{ $title }}</div>
    </div>
</div>
<div class="block text-justify">

    <div>
        Conste por la presente Adenda al Contrato de préstamo de {{ $loan->$oficial_loan->code }}, que al solo reconocimiento 
        de firmas y rubricas será elevado a Instrumento Público, por lo que las partes que intervienen lo suscriben al tenor 
        y contenido de las siguientes cláusulas y condiciones:
    </div>
    <div>
        <b>PRIMERA.- (DE LAS PARTES):</b> Intervienen en el presente contrato, por una parte como acreedor la Mutual de 
        Servicios al Policía (MUSERPOL), representada legalmente por el {{ $employees[0]['position'] }}
        {{ $employees[0]['name'] }} con C.I. {{ $employees[0]['identity_card'] }} y su {{ $employees[1]['position'] }} 
        {{ $employees[1]['name'] }} con C.I. {{ $employees[1]['identity_card'] }}, que para fines de este contrato 
        en adelante se denominará MUSERPOL o ACREEDOR con domicilio en la Z. Sopocachi, Av. 6 de Agosto Nº 2354 y por 
        otra parte como PRESTATARIO
        @if (count($lenders) == 1)
            @php 
                $lender = $lenders[0];
                $male_female = Util::male_female($lender->gender);
            @endphp
            <span>
                {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }}, con C.I. {{ $lender->identity_card }}, 
                {{ $lender->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $lender->city_birth->name }}, 
                vecin{{ $male_female }} de {{ $lender->address->cityName() }} y con domicilio especial en {{ $lender->address->full_address }}, 
                en adelante denominad{{ $male_female }} PRESTATARIO.
            </span>
        @endif
    </div>
    <div>
        <b>SEGUNDA.- (DEL ANTECEDENTE):</b> Mediante contrato de préstamo N° {{ $loan->$oficial_loan->code.$comodin }}
        de fecha {{ Carbon::parse($loan->$oficial_loan->disbursement_date)->isoFormat('LL') }},
        suscrito entre MUSERPOL y el PRESTATARIO, se otorgó un préstamo por la suma de 
        {{ Util::money_format($loan->$oficial_loan->amount_approved) }} (<span class="uppercase">
        {{ Util::money_format($loan->$oficial_loan->amount_approved, true) }}</span> Bolivianos),
        con la generalidad de sus bienes, derechos y acciones habidos y por haber, presentes y futuros, así como la garantía personal,
        @foreach($guarantors as $key => $guarantor)
            <span>
            {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }}, con C.I. {{ $guarantor->identity_card }}, 
            {{ $guarantor->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $guarantor->city_birth->name }}, 
            vecin{{ Util::male_female($guarantor->gender) }} de {{ $guarantor->address->cityName() }} y con domicilio especial en 
            {{ $guarantor->address->full_address }} {{ "(garante Nº ".($key+1).")" }} ,
            </span>
        @endforeach
        programados a un plazo de {{ $loan->$oficial_loan->loan_term}} meses de pago para el cumplimiento de obligación, con una 
        amortización mensual de Bs. {{ Util::money_format($loan->$oficial_loan->estimated_quota) }} (<span class="uppercase">
        {{ Util::money_format($loan->$oficial_loan->estimated_quota, true) }}</span> Bolivianos).
    </div>
    <div>
        <b>TERCERA.- (DEL OBJETO):</b>  El objeto del presente es la suscripción de la adenda modificatoria del contrato señalado en los antecedentes 
        de la cláusula segunda, para lo cual de acuerdo a la solicitud escrita del PRESTATARIO de fecha
        {{ Carbon::parse($loan->request_date)->isoFormat('LL') }}, misma que
        se encuentra respaldada por los documentos adjuntados, la Mutual de Servicios al Policía (MUSERPOL) en estricta sujeción con lo previsto 
        en el art. 67 y 68 del Reglamento de Prestamos, procede a reprogramar el préstamo descrito en la cláusula precedente bajo los siguientes 
        términos y condiciones que se establecen en la presente Adenda.
        <br>
        Consiguientemente el ACREEDOR y la MUSERPOL acuerdan reprogramar y modificar la obligación original, bajo las siguientes condiciones:
        <br>
        <b>3.1.- Se modifica la cláusula (Plazo)</b>.- Se reprograma el plazo de vigencia del préstamo señalado en la cláusula segunda 
        por el plazo de {{ $loan->$oficial_loan->loan_term}} meses.
        <br>
        <b>3.2.- Se modifica la cláusula (Cuota de Amortización)</b>.-  La amortización del pago a capital e intereses mensual y constantes que 
        el prestatario efectuara a partir de la fecha de la suscripción de la presente adenda es de
        Bs. {{ Util::money_format($loan->estimated_quota) }} (<span class="uppercase">{{ Util::money_format($loan->estimated_quota, true) }}</span> Bolivianos). 
    </div>
    <div>
        <b>CUARTA.- (DE LAS CONDICIONES Y CLAUSULAS ACORDADAS):</b> En cuanto a las demás clausulas y condiciones establecidas en el 
        contrato de préstamos señalado en la cláusula segunda de la presente adenda, se mantienen plenamente vigentes y con pleno valor 
        legal siendo de cumplimiento obligatorio para el PRESTATARIO y MUSERPOL, no admitiendo por tanto ningún tipo de sobre entendimiento, 
        conclusiones e interpretaciones contrarias, constituyéndose la presente de única y exclusiva modiﬁcación de los puntos 3.1 y 3.2 
        señalados en la cláusula precedente, por lo que la presente adenda forma parte integrante e indivisible del contrato antes mencionado.
    </div>
    <div>
        <b>QUINTA.- (DE LA CONFORMIDAD Y ACEPTACIÓN):</b> Por una parte en calidad de ACREEDOR a Mutual de Servicios al Policia MUSERPOL, representada por su 
        {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} 
        y por otra parte en calidad de PRESTATARIO
        <span>
            @if (count($lenders) == 1)
                {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }} de generales ya señaladas; asimismo en calidad de garantes personales
            @endif
            @foreach($guarantors as $key => $guarantor)
                <span>
                    {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }}, con C.I. 
                    {{ $guarantor->identity_card }}, {{ $guarantor->civil_status_gender }}, mayor de edad, hábil por derecho, natural de 
                    {{ $guarantor->city_birth->name }}, vecin{{ Util::male_female($guarantor->gender) }} de {{ $guarantor->address->cityName() }} y con 
                    domicilio especial en {{ $guarantor->address->full_address }} {{ "(garante Nº ".($key+1).")" }},
                </span>
            @endforeach
            {{count($guarantors) > 0 ? 'damos nuestra' : 'doy'}}
            plena conformidad con todas y cada una de las cláusulas precedentes, obligándolos a su ﬁel y estricto cumplimiento. 
            En señal de lo cual suscribimos el presente contrato de préstamo de dinero en manifestación de nuestra libre y espontánea voluntad 
            y sin que medie vicio de consentimiento alguno.
        </span>
    </div><br><br>
    <div class="text-center">
        <p class="center">
        La Paz, {{ Carbon::parse($loan->request_date)->isoFormat('LL') }}
        </p>
    </div>
</div>
<div>
    <div>
        @if (count($guarantors) == 1)
        @php $guarantor = $guarantors[0]; @endphp
        <table>
            <tr>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $lender->full_name,
                    'identity_card' => $lender->identity_card,
                    'position' => 'PRESTATARIO'
                ])
                </td>
                <td  with = "50%">
                @include('partials.signature_box', [
                    'full_name' => $guarantor->full_name,
                    'identity_card' => $guarantor->identity_card,
                    'position' => 'GARANTE'
                ])
                </td>
            </tr>
        </table>
        @endif
    </div>
    @if (count($guarantors) == 2)
    <div>
        @include('partials.signature_box', [
            'full_name' => $lender->full_name,
            'identity_card' => $lender->identity_card,
            'position' => 'PRESTATARIO'
        ])
    </div>
    <div class = "no-page-break">
        <div>
            <table>
                <tr>
                    @foreach ($guarantors as $guarantor)
                    <td with = "50%">
                        @include('partials.signature_box', [
                            'full_name' => $guarantor->full_name,
                            'identity_card' => $guarantor->identity_card,
                            'position' => 'GARANTE'
                        ])
                    @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    <div>
        <table>
            <tr>
                @foreach ($employees as $key => $employee)
                <td width="50%">
                    @include('partials.signature_box', [
                        'full_name' => $employee['name'],
                        'identity_card' => $employee['identity_card'],
                        'position' => $employee['position'],
                        'employee' => true
                    ])
                @endforeach
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>