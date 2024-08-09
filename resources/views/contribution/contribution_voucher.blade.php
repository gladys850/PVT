<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PLATAFORMA VIRTUAL DE TRÁMITES - MUSERPOL </title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>

<body>
    @php ($n = 1)
    @include('partials.header', $header)
    <div class="block">
        
        <div class="font-semibold leading-tight text-center m-b-5 text-2xl"> {{ $title }} </div>
        <div class="font-semibold leading-tight text-center m-b-5"> {{ $subtitle }} </div>
        <br>
        <div class="font-semibold leading-tight text-center m-b-5 text-xl"> Periodo: {{ $period }} </div>
        <br>
        <table>
            <tr>
                <td class="w-100" colspan="3">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>AFILIADO:</b> {{ $affiliate->degree->shortened }} {{ $affiliate->full_name }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-35">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>C.I.:</b> {{ $affiliate->identity_card }}
                    </div>
                </td>
                <td class="w-35">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>NUP:</b> {{ $affiliate->id }}
                    </div>
                </td>
                <td class="w-30">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>CATEGORÍA:</b> {{ $contribution->category->name }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-70" colspan="2">
                    <div class="leading-tight text-left m-b-10 text-xl" >
                        <b>GRADO:</b> {{ $affiliate->degree->name }}
                    </div>
                </td>
                <td class="w-30">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>ESTADO:</b> {{ $contribution->breakdown->name ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="w-100" colspan="3">
                    <div class="leading-tight text-left m-b-10 text-xl">
                        <b>UNIDAD:</b> {{ $contribution->unit->name ?? '' }}
                    </div>
                </td>
            </tr>
        </table>
        
        <table class="table-info border w-100 my-20 text-xl">
            <tr>
                <td class="bg-grey-darker text-white px-5 py-5"> DETALLE </td>
                <td class="bg-grey-darker text-white px-5 py-5"> IMPORTE </td>
            </tr>
            <tr>
                <td class="data-row px-5 py-5 font-semibold">
                    Bono Frontera:
                </td>
                <td class="data-row px-5 py-5" colspan="3">
                    Bs. {{ Util::money_format($contribution->border_bonus) }}
                </td>
            </tr>
            <tr>
                <td class="data-row px-5 py-5 font-semibold">
                    Bono Oriente:
                </td>
               <td class="data-row px-5 py-5" colspan="3">
                    Bs. {{ Util::money_format($contribution->east_bonus) }}
                </td>
            </tr>
            <tr>
                <td class="data-row px-5 py-5 font-semibold">
                    Bono Cargo:
                </td>
               <td class="data-row px-5 py-5" colspan="3">
                    Bs. {{ Util::money_format($contribution->position_bonus) }}
                </td>
            </tr>
            <tr>
                <td class="data-row px-5 py-5 font-semibold">
                    Bono Seguridad Ciudadana:
                </td>
                <td class="data-row px-5 py-5" colspan="3">
                    Bs. {{ Util::money_format($contribution->public_security_bonus) }}
                </td>
            </tr>
            <tr>
                <td class="data-row px-5 py-5 font-semibold w-55">
                    LÍQUIDO PAGABLE
                </td>
                <td class="data-row px-5 py-5 font-semibold w-45" colspan="3">
                    Bs. {{  Util::money_format($contribution->payable_liquid) }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>