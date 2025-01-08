<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $file_title }}</title>
    <link rel="stylesheet" href="{{ public_path('/css/report-print.min.css') }}" media="all" />
</head>
@include('partials.header', $header)

<body>
    <br><br>
    <div class="font-semibold leading-tight text-left m-b-10">{{ $code }}</div>
    <br><br>
    <div class="block text-justify uppercase" style="margin-left: 50%;">
        La {{ $institution }}, en uso de sus atribuciones mediante reglamento de préstamos 2024 le permite:
    </div>
    <br><br>
    <div class="block text-justify">
        <div class="font-semibold leading-tight text-left m-b-10">C E R T I F I C A:</div>
        Que previa revisión y verificación de la base de datos del Sistema de Préstamos de la Entidad
        <span style="text-decoration: underline;">"PVT"</span> de los señores afiliados, se VERIFICÓ que:
    </div>
    <br>
    <div class="font-semibold text-center">
        {{ $affiliate->gender == 'M' ? 'El Sr.' : 'La Sra.' }} {{ $affiliate->full_name }} con C.I.
        {{ $affiliate->identity_card }}
    </div>
    <br>
    <div class="block text-justify">
        @switch($value)
            @case('NO ADEUDO')
                A la fecha de la emisión del presente certificado <b>NO FIGURA COMO DEUDOR</b>, en ninguna de las modalidades de
                préstamos de la {{ $institution }}.
                <br>
                Es cuanto se certifica en honor a la verdad, para los fines consiguientes.
            @break

            @case('REGISTRA DEUDAS')
                A la fecha de la emisión del presente certificado <b>REGISTRA DEUDAS ACTIVAS</b> en alguna(s) de las modalidades
                de préstamos de la {{ $institution }}.
                <br><br>
                El presente certificado se expide para fines consiguientes, dejando constancia de la situación actual en el
                sistema de registro de la entidad.
            @break

            @case('REVISAR BASE DE DATOS')
                <b>INFORMACIÓN NO DISPONIBLE</b>. Se debe revisar la Base de Datos de los otros sistemas.
            @break

            @default
                <b>INFORMACIÓN NO DISPONIBLE</b>. Por favor, verifique el estado del afiliado.
        @endswitch
    </div>
    <br><br>
    <div class="text-right">
        {{ ucwords(strtolower($user->city->name)) }}, {{ Carbon::now()->isoFormat('LL') }}
    </div>
    <br><br><br><br>
    <div>
        @include('partials.signature_box', [
            'full_name' => $user->full_name,
            'position' => $user->position,
            'employee' => true,
        ])
    </div>
</body>

</html>
