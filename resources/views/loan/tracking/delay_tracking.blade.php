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
        El Área de Recuperación y Cobranzas procedió con las gestiones de cobro conforme el Reglamento de Préstamo 2022 en su CAPITULO IV (RECUPERACIÓN DE CARTERA DE MORA) de acuerdo al siguiente detalle:
    </div>
</div>
<br>
<div class="block">
        <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS PERSONALES DE{{ $plural ? ' LOS' : 'L' }} TITULAR{{ $plural ? 'ES' : ''}}</div>
</div>
<div class="block">
    @foreach ($lenders as $lender)
        <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td class="w-60">NOMBRE COMPLETO</td>
                <td class="w-20">CI</td>
            </tr>
            <tr> 
                <td class="data-row py-5">{{ $lender->title && $lender->type=="affiliates" ? $lender->title() : '' }} {{ $lender->full_name }}</td>
                <td class="data-row py-5">{{ $lender->identity_card_ext }}</td>
            </tr>
        </table>
    @endforeach
</div>
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
            <td class="data-row py-5">{{ !is_null($loan->last_payment_validated)? Carbon::parse($loan->last_payment_validated->estimated_date)->format('d/m/Y'):'Sin registro'}}</td>
            <td class="data-row py-5">{{ Util::money_format($loan->balance) }} <span class="capitalize">Bs.</span></td>
        </tr>
    </table>
</div>
<div class="block">
    <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DEL SEGUIMIENTO</div>
</div>
@php ($n = 1)
<div class="block">
        <table style="font-size:11px;" class="table-info w-100 uppercase my-10">
            <tr class="bg-grey-darker text-white text-center">
                <td class="w-5">N°</td>
                <td class="w-10">Fecha</td>
                <td class="w-10">Usuario</td>
                <td class="w-30">TIpo de Seguimiento</td>
                <td class="w-45">Detalle</td>
            </tr>
            <tr>
            @foreach ($loan_trackings as $loan_tracking)
                <td class="data-row py-5 text-center">{{$n++}}</td>
                <td class="data-row py-5 text-center">{{Carbon::parse($loan_tracking->tracking_date)->format('d/m/Y')}}</td>
                <td class="data-row py-5 text-center">{{$loan_tracking->user->username}}</td>
                <td class="data-row py-5 text-justify">{{$loan_tracking->loan_tracking_type->name}}</td>
                <td class="data-row py-5 text-justify">{{$loan_tracking->description}}</td>
             </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
