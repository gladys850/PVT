<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$file_title}}</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>
@include('partials.header', $header)
<body>
@php 
    $modality = $loan->modality; 
    $modality_name = $loan->modality->name; 
@endphp
<div class="block">
    <div class="font-semibold leading-tight text-center m-b-10 text-base">
        CONTRATO DE PRÉSTAMO <font style="text-transform: uppercase;">{{ $title }}</font>
        <div>Nº {{ $loan->code }}</div>
    </div>
</div>
<div class="block text-justify">
    <div>
        Conste en el presente contrato de préstamo de {{ $title }}, que al solo reconocimiento de firmas y rúbricas será elevado 
        a Instrumento Público, por lo que las partes que intervienen lo suscriben al tenor y contenido de las siguientes cláusulas 
        y condiciones:
    </div>
    <div>
        <b>PRIMERA.- (DE LAS PARTES):</b> Intervienen en el presente contrato, por una parte la Mutual de Servicios al Policía 
        (MUSERPOL), representada legalmente por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} con C.I. 
        {{ $employees[0]['identity_card'] }} y su {{ $employees[1]['position'] }} {{ $employees[1]['name'] }} con C.I. 
        {{ $employees[1]['identity_card'] }}, que para fines de este contrato en adelante se denominará MUSERPOL o ACREEDOR 
        con domicilio en la Z. Sopocachi, Av. 6 de Agosto Nº 2354 y por otra parte

        @if (count($lenders) == 1)
            @php 
                $lender = $lenders[0];
                $male_female = Util::male_female($lender->gender);
            @endphp
            <span>
                {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra.' }} {{ $lender->full_name }}, con C.I. {{ $lender->identity_card }}, 
                {{ $lender->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $lender->city_birth->name }}, 
                vecin{{ $male_female }} de {{ $lender->address->cityName() }} y con domicilio en {{ $lender->address->full_address }}, 
                en adelante denominad{{ $male_female }} PRESTATARIO.
            </span>
        @endif
    </div>
    <div>
        <b>SEGUNDA.- (DEL OBJETO):</b>  El objeto del presente contrato es el préstamo de dinero que la Mutual de Servicios al 
        Policía MUSERPOL otorga al PRESTATARIO conforme a niveles de aprobación respectivos, en la suma de Bs.
        {{ Util::money_format($loan->amount_approved) }} (<span class="uppercase">{{Util::money_format($loan->amount_approved, true)}} 
            Bolivianos).</span>
    </div>
    <div>
        <b>TERCERA.- (DEL INTERÉS):</b> El préstamo objeto del presente contrato, devengará un interés ordinario del 
        {{ round($loan->interest->annual_interest) }}% anual sobre saldo deudor, el mismo que se recargará con el interés 
        penal en caso de mora de una o más amortizaciones. 
    </div>
    <div>
        <b>CUARTA.- (DEL PLAZO Y LA CUOTA DE AMORTIZACIÓN):</b> El plazo fijo e improrrogable para el cumplimiento de la obligación 
        contraída por el PRESTATARIO en virtud al préstamo otorgado es de {{ $loan->loan_term }} {{ $loan->loan_term == 1 ? 'mes' : 'meses' }} computables a partir de la fecha 
        de desembolso. La cuota de amortización mensual es de Bs.{{ Util::money_format($loan->estimated_quota) }} (<span class="uppercase">
            {{ Util::money_format($loan->estimated_quota, true) }} Bolivianos).</span>
    </div>
    <div>
        Los intereses generados entre la fecha del desembolso del préstamo y la fecha del primer pago serán cobrados con la primera cuota; 
        conforme los establece el Reglamento de Préstamos.
    </div>
    <div>
        <b>QUINTA.- (DEL DESEMBOLSO):</b> El desembolso del préstamo de dinero en la moneda pactada se acredita mediante comprobante 
        escrito en el que conste el abono efectuado a favor del PRESTATARIO, el mismo se efectuará en efectivo, reconociendo ambas partes 
        que al amparo de este procedimiento se cumple satisfactoriamente la exigencia contenida en el artículo 1331 del Código de Comercio.</span>
    </div>
    <div>
        @if($modality_name == 'Anticipo Sector Pasivo AFP' || 
            $modality_name == 'Anticipo Sector Pasivo Gestora Pública')
            <b>SEXTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) 
            el PRESTATARIO, se obliga a cumplir con la cuota de amortización en forma mensual mediante pago directo en la oﬁcina central de la 
            MUSERPOL de la ciudad de La Paz o efectuar el depósito en la cuenta fiscal de la MUSERPOL. Caso contrario el PRESTATARIO se hará 
            pasible al recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída. Consecuentemente se 
            procecerá al descuento al garante personal incluido los intereses penales una vez transcurrido las dos cuotas impagas, sin 
            necesidad de previo aviso.
        @else
            @php
                if($modality_name == 'Anticipo Sector Pasivo SENASIR'){
                    $discount_entity = 'Servicio Nacional del Sistema de Reparto SENASIR';
                    $type_rent='las rentas';
                }else{
                    $discount_entity = 'Comando General de la Policía Boliviana';
                    $type_rent='los haberes';
                }
            @endphp
            <b>SEXTA.- (DE LA FORMA DE PAGO Y OTRAS CONTINGENCIAS):</b> Para el cumplimiento estricto de la obligación (capital e intereses) 
            el PRESTATARIO, autoriza expresamente a la MUSERPOL practicar los descuentos respectivos de {{$type_rent}} que percibe en forma 
            mensual a través del {{ $discount_entity }} conforme al Reglamento de Préstamos.
            <div>
            Si por cualquier motivo la MUSERPOL estuviera imposibilitada de realizar el descuento por el medio señalado, el PRESTATARIO 
            se obliga a cumplir con la cuota de amortización mediante pago directo en la Oficina Central de la MUSERPOL de la ciudad de 
            La Paz o efectuar el depósito bancario en la cuenta fiscal de la MUSERPOL. Caso contrario el PRESTATARIO se hará pasible al 
            recargo correspondiente a los intereses que se generen al día de pago por la deuda contraída.
            </div>
            <div>
            Asimismo, el PRESTATARIO se compromete hacer conocer oportunamente a la MUSERPOL sobre la omisión del descuento mensual que se 
            hubiera dado, sin perjuicio que realice el depósito directo del mes omitido, de acuerdo a lo estipulado en el párrafo precedente.
            </div>
        @endif
    </div>
    <div>
        <b>SÉPTIMA.- (DERECHOS DEL PRESTATARIO):</b> Conforme al Artículo 10 del Reglamento de Préstamos las partes reconocen expresamente 
        como derechos del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a" style="margin:0;">
            <li>Recibir buena atención, trato equitativo y digno por parte de los funcionarios de la MUSERPOL sin discriminación de ninguna 
                naturaleza, asimismo recibir información y orientación precisa, comprensible, oportuna y accesible con relación a requisitos, 
                características y condiciones del préstamo.</li>
            <li>A la confidencialidad, información detallada y precisa concerniente a los préstamos bajo su titularidad en el marco estricto 
                de la normativa legal vigente.</li>
            <li>A presentar queja formal por el servicio recibido si no se ajusta al presente reglamento.</li>
        </ol>
    </div>
    <div>
        <b>OCTAVA.- (OBLIGACIONES DEL PRESTATARIO):</b> Conforme al Artículo 11 del Reglamento de Préstamos, las partes reconocen expresamente 
        como obligaciones del PRESTATARIO, lo siguiente:
    </div>
    <div>
        <ol type="a" style="margin:0;">
            <li>Proporcionar información y documentación veraz y legítima para la correcta tramitación del préstamo.</li>
            <li>Cumplir con los requisitos, condiciones y lineamientos del préstamo.</li>
            <li>Cumplir con el Contrato de Préstamo suscrito entre la MUSERPOL y el Prestatario.</li>
            <li>
                Amortizar mensualmente y/o semestralmente la deuda contraída con la MUSERPOL, hasta cubrir el capital adeudado además de los intereses 
                correspondientes según contrato de préstamo suscrito.
            </li>
        </ol>
    </div>
    <div>
        @if($modality_name == 'Anticipo Sector Pasivo AFP' || 
            $modality_name == 'Anticipo Sector Pasivo Gestora Pública')
            <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO y GARANTE, garantizan el pago de lo adeudado con la generalidad de sus bienes, 
            derechos y acciones habidos y por haber presentes y futuros conforme lo determina el Art. 1335 del Código Civil, ademas el PRESTATARIO, 
            con los beneficios otorgados por la MUSERPOL.
            <br>
            Asimismo, se constituye como garante personal, solidario, mancomunado e indivisible:
            @if (count($guarantors) == 1)
                @php $guarantor = $guarantors[0]; @endphp
                <span>
                    {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }}, con C.I. {{ $guarantor->identity_card }}, 
                    {{ $guarantor->civil_status_gender }}, mayor de edad, hábil por derecho, natural de {{ $guarantor->city_birth->name }}, 
                    vecin{{ Util::male_female($guarantor->gender) }} de {{ $guarantor->address->cityName() }} y con domicilio en {{ $guarantor->address->full_address }}, 
                    quien en amparo del artículo 17 del Reglamento de Préstamos de la MUSERPOL garantiza el cumplimiento de la obligación y en caso 
                    que el PRESTATARIO, incumpliera con el pago de sus obligaciones o se constituyera en mora al incumplimiento de una o más cuotas 
                    de amortización, autoriza el descuento mensual de sus haberes en su calidad de GARANTE, bajo las mismas condiciones en las que 
                    procedería a descontar al PRESTATARIO hasta cubrir el pago total de la obligación pendiente de cumplimiento. Excluyendo a la MUSERPOL 
                    de toda responsabilidad o reclamo posterior, sin perjuicio de que este pueda iniciar las acciones legales correspondientes en contra 
                    del PRESTATARIO.
                </span>
            @endif
        @elseif($modality_name == 'Anticipo Sector Activo' || 
                $modality_name == 'Anticipo en Disponibilidad')
                <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO, garantiza el pago de lo adeudado con la generalidad de sus bienes, 
                derechos y acciones habidos y por haber, presentes y futuros conforme determina el Art. 1335 del Código Civil, asimismo 
                con los beneficios otorgados por la MUSERPOL.
        @elseif($modality_name == 'Anticipo Sector Pasivo AFP' || 
                    $modality_name == 'Anticipo Sector Pasivo SENASIR')
                <b>NOVENA.- (DE LA GARANTÍA):</b>El PRESTATARIO, garantiza el pago de la deuda con la generalidad de sus bienes, derechos 
                y acciones habidos y por haber presentes y futuros conforme establece el Art. 1335 del Código Civil y así como también con 
                su renta de vejez en curso de pago, asimismo este acepta amortizar la deuda con su Complemento Económico.
        @endif
    </div>
    <div>
    
        @if($modality_name == 'Anticipo Sector Pasivo AFP' || 
            $modality_name == 'Anticipo Sector Pasivo SENASIR' || 
            $modality_name == 'Anticipo Sector Pasivo Gestora Pública')
        <div>
            <b>DÉCIMA.- (CONTINGENCIAS POR FALLECIMIENTO):</b> El PRESTATARIO en caso de fallecimiento acepta amortizar para el cumplimiento 
            efectivo de la presente obligación con el beneficio del Complemento Económico en caso de corresponderle; por cuanto la liquidación 
            de dicho beneficio pasará a cubrir el monto total de la obligación que resulte adeudada, más los intereses devengados a la fecha, 
            cobrados a los derechohabientes, previas las formalidades de ley.
        </div>
        @else
            <b>DÉCIMA.- (MODIFICACIÓN DE LA SITUACIÓN DEL PRESTATARIO):</b> El PRESTATARIO, en caso de fallecimiento, retiro voluntario o retiro 
            forzoso garantiza el cumplimiento efectivo de la presente obligación con la totalidad del beneﬁcio de Fondo de Retiro Policial 
            Solidario otorgado por la MUSERPOL; por cuanto la liquidación de dicho beneficio pasará a cubrir el monto total de la obligación 
            que resulte adeudada, más los intereses devengados a la fecha, previas las formalidades de ley.
            <div>
                En caso de que se haya modificado la situación del PRESTATARIO del sector activo al sector pasivo de la Policía Boliviana, 
                teniendo un saldo deudor respecto del préstamo obtenido, acepta amortizar la deuda con su Complemento Económico, en caso de 
                corresponderle.
            </div>
        @endif
    </div>
    <div>
        <b>DÉCIMA PRIMERA.- (DE LA MORA):</b> El PRESTATARIO se constituirá en mora automática sin intimación o requerimiento alguno, de 
        acuerdo a lo establecido por el artículo 341, Núm. 1) del Código Civil, al incumplimiento del pago de cualquier amortización de 
        capital o intereses, sin necesidad de intimación o requerimiento alguno, o acto equivalente por parte de la MUSERPOL.
    </div>
    <div>
        Además del interés acordado contractualmente, el préstamo generará en caso de mora un interés moratorio anual del 
        {{ round($loan->interest->penal_interest) }}%, sobre saldos de capital de las cuotas impagas, aún cuando fuere exigible 
        todo el capital del préstamo.
    </div>
    <div>
        <b>DÉCIMA SEGUNDA.- (DE LOS EFECTOS DEL INCUMPLIMIENTO Y DE LA ACCIÓN EJECUTIVA):</b> El incumplimiento de pago mensual por 
        parte del PRESTATARIO   dará lugar a que la totalidad de la obligación, incluidos los intereses moratorios, se determinen 
        líquidos, exigibles y de plazo vencido quedando la MUSERPOL facultada de iniciar las acciones legales correspondientes al 
        amparo de los artículos 519 y 1465 del Código Civil así como de los artículos 378 y 379, Núm. 2) del Código Procesal Civil, 
        que otorgan a este documento la calidad de Título Ejecutivo, demandando el pago de la totalidad de la obligación contraída, 
        más la cancelación de intereses convencionales y penales, incluyendo los relacionados y emergentes de la cobranza judicial, 
        honorarios, derechos, costas y otros, sin excepción por efecto de la acción legal que la MUSERPOL instaure para lograr el 
        cumplimiento total de la obligación.
    </div>
    <div>
        En caso de incumplimiento de los pagos mensuales estipulados en el presente contrato que generen mora de la obligación, 
        el PRESTATARIO no tendrá derecho a acceder a otro crédito, hasta la cancelación total de la deuda.
    </div>
        @if($modality_name == 'Anticipo Sector Pasivo AFP')
            <div>
                <b>DÉCIMA TERCERA.- (DOMICILIO ESPECIAL):</b> Para efectos legales, incluida la acción judicial u otra, se tendrá 
                como domicilio especial del PRESTATARIO y GARANTE el señalado en la cláusula primera y novena de conformidad al Artículo 
                29 parágrafo II del Código Civil, donde se efectuarán las citaciones y notificaciones judiciales o cualquier otra comunicación, 
                con plena validez legal y sin lugar a posterior observación o recurso alguno.
            </div>
        @else
            <div>
                <b>DÉCIMA TERCERA.- (DOMICILIO ESPECIAL):</b> Para efectos legales, incluida la acción judicial u otra, se tendrá como 
                domicilio especial del PRESTATARIO el señalado en la cláusula primera de conformidad al Artículo 29 parágrafo II del Código 
                Civil, donde se efectuarán las citaciones y notificaciones judiciales o cualquier otra comunicación, con plena validez legal 
                y sin lugar a posterior observación o recurso alguno.
            </div>
        @endif
    <div>
        <b>DÉCIMA CUARTA.- (DE LA CONFORMIDAD Y ACEPTACIÓN):</b> Por una parte en calidad de ACREEDOR la Mutual de Servicios al Policía 
        (MUSERPOL), representada por su {{ $employees[0]['position'] }} {{ $employees[0]['name'] }} y su {{ $employees[1]['position'] }} 
        {{ $employees[1]['name'] }} y por otra parte en calidad de
        @if (count($lenders) == 1)
        <span>
            PRESTATARI{{ $lender->gender == 'M' ? 'O' : 'A' }} {{ $lender->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $lender->full_name }} 
            de generales ya señaladas;
            
            @if($modality_name == 'Anticipo Sector Pasivo AFP' || 
                $modality_name == 'Anticipo Sector Pasivo Gestora Pública')
                asimismo en calidad de garante personal
                @if (count($guarantors) == 1)
                    @php 
                        $guarantor = $guarantors[0];
                        $male_female_guarantor = Util::male_female($guarantor->gender);
                    @endphp
                    <span>
                    {{ $guarantor->gender == 'M' ? 'el Sr.' : 'la Sra' }} {{ $guarantor->full_name }},
                    </span>
                @endif
            @endif
            damos nuestra plena conformidad con todas y cada una de las cláusulas precedentes, obligándonos a su fiel y estricto cumplimiento. 
            En señal de lo cual suscribimos el presente contrato de préstamo de dinero en manifestación de nuestra libre y espontánea voluntad 
            y sin que medie vicio de consentimiento alguno.
        </span>
        @endif
    </div><br><br>
    <div class="text-center">
        <p class="center">
        La Paz, {{ Carbon::now()->isoFormat('LL') }}
        </p>
    </div>
</div>
<div class="block m-t-100">
    <table>
        @if($modality_name == 'Anticipo Sector Pasivo AFP' || 
            $modality_name == 'Anticipo Sector Pasivo Gestora Pública')
                <tr class="align-top">
                    <td width="50%">
                    @include('partials.signature_box', [
                    'full_name' => $lender->full_name,
                    'identity_card' => $lender->identity_card,
                    'position' => 'PRESTATARIO'
                    ])
                    </td>
                    <td width="50%">
                    @include('partials.signature_box', [
                    'full_name' => $guarantor->full_name,
                    'identity_card' => $guarantor->identity_card,
                    'position' => 'GARANTE'
                    ])
                    </td>
                </tr>
            </table>
        @else
            <div>
            @include('partials.signature_box', [
                'full_name' => $lender->full_name,
                'identity_card' => $lender->identity_card,
                'position' => 'PRESTATARIO'
            ])
            </div>
        @endif
        <div>
            <table>
                <tr>
                    @foreach ($employees as $key => $employee)
                    <td>
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
