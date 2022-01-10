<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$file_title}}</title>
    <link rel="stylesheet" href="{{ public_path("/css/report-print.min.css") }}" media="all"/>
</head>

<body>
    @php ($n = 1)
    @include('partials.header', $header)
    <div class="block">
        <div class="font-semibold leading-tight text-center m-b-10 text-lg">{{ $title }}</div>
    </div>
    <div class="block">
        <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DEL TRÁMITE</div>
    </div>
    <div class="block">
        <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td class= "w-50">Código Tŕamite</td>
                <td class= "w-50" colspan="2">Modalidad de trámite</td>
            </tr>
            <tr>
                <td class="data-row py-5">{{ $loan->code }}</td>
                <td class="data-row py-5" colspan="2">{{ $loan->modality->name }}</td>
            </tr>
            <tr class="bg-grey-darker text-white">
                <td>Monto solicitado</td>
                <td>Plazo</td>
                <td>Tipo de Desembolso</td>
            </tr>
            <tr>
                <td class="data-row py-5">{{ Util::money_format($loan->amount_approved) }} <span class="capitalize">Bs.</span></td>
                <td class="data-row py-5">{{ $loan->loan_term }} <span class="capitalize">Meses</span></td>
                <td class="data-row py-5">
                    @if($loan->payment_type->name=='Depósito Bancario')
                        <div class="font-bold">{{ $loan->payment_type->name }}</div>
                        <div>Nro. de cuenta: {{ $loan->number_payment_type }}</div>
                    @else
                        {{ $loan->payment_type->name}}
                    @endif
                </td>
            </tr>
            <tr class="bg-grey-darker text-white">
                <td colspan="2">Fecha de Solicitud</td>
                <td colspan="1">Destino del Préstamo</td>
            </tr>
            <tr>
                <td class="data-row py-5" colspan="2">{{ Carbon::parse($loan->request_date)->format('d/m/y')}}</td>
                <td class="data-row py-5" colspan="1">{{ $loan->destiny->name }}</td>
            </tr>
        </table>
    </div>
    <div class="block">
        <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DEL TITULAR</div>
    </div>  
    <div class="block">
        @foreach ($lenders as $lender)
        @php ($disbursable = $lender->disbursable )
        @php ($affiliate = $lender->affiliate )
        <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td class="w-70">Solicitante</td>
                <td class="w-15">CI</td>
                <td class="w-15">Estado</td>
            </tr>
            <tr> 
                <td class="data-row py-5">{{ $disbursable->title ? $disbursable->title : '' }} {{ $disbursable->full_name }}</td>
                <td class="data-row py-5">{{ $disbursable->identity_card_ext }}</td>
                <td class="data-row py-5">{{ $disbursable->affiliate_state ? $disbursable->affiliate_state->affiliate_state_type->name : $disbursable->affiliate->affiliate_state->affiliate_state_type->name }}</td>
            </tr>
            <tr class="bg-grey-darker text-white">
                <td class="w-70">Domicilio actual</td>
                <td class="w-15" colspan="2">Teléfono(s)</td>
            </tr>
            <tr>
                <td class="data-row py-5">{{ $disbursable->address ? $disbursable->address->full_address : '' }}</td>
                <td class="data-row py-5" colspan="2">
                @if ($disbursable->phone_number != "" && $disbursable->phone_number != null)
                    <div>{{ $disbursable->phone_number }}</div>
                @endif
                @if ($disbursable->cell_phone_number != "" && $disbursable->cell_phone_number != null)
                    @foreach(explode(',', $disbursable->cell_phone_number) as $phone)
                        <div>{{ $phone }}</div>
                    @endforeach
                @endif
                </td>
            </tr>
            @php ($pasivo =  $disbursable->affiliate_state ? $disbursable->affiliate_state->affiliate_state_type->name : $disbursable->affiliate->affiliate_state->affiliate_state_type->name )          
            <tr class="bg-grey-darker text-white">  
                @if ($pasivo  != "Pasivo" )
                    <td colspan="2">Unidad</td>
                    <td >Categoría</td>
                @else
                    <td colspan="1">Tipo de Renta</td>
                    <td colspan="2">MATRÍCULA</td>
                @endif
            </tr>
            <tr>
                @if ($pasivo  != "Pasivo")
                    <td class="data-row py-5" colspan="2">{{ $disbursable->full_unit}}</td>
                    <td class="data-row py-5">{{ $disbursable->category ? $disbursable->category->name : '' }}</td>
                @else
                    <td colspan="1" class="data-row py-5">{{ $disbursable->pension_entity ? $disbursable->pension_entity->name : $disbursable->affiliate->pension_entity->name}}</td>
                    <td colspan="2" class="data-row py-5">{{ $disbursable->registration }}</td>
                @endif
               
            </tr>
        </table>
    </div>
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DE BOLETA</div>
        </div>
        @php ($ballot_detail = $loan->ballot_affiliate($affiliate->id))
        
        @php ($ballot_type = $ballot_detail->contribution_type)
    <div class="block">
        <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td class="bg-grey-darker text-white">Periodo</td>
                <td class="bg-grey-darker text-white">Liquido</td>
                <td class="bg-grey-darker text-white">Monto de Ajuste</td>
                @if($ballot_type == "contributions")
                    <td class="bg-grey-darker text-white">Bono Frontera</td>
                    <td class="bg-grey-darker text-white">Bono Cargo</td>
                    <td class="bg-grey-darker text-white">Bono Oriente</td>
                    <td class="bg-grey-darker text-white">Bono Seguridad Ciudadana</td>
                @endif
                @if($ballot_type == "aid_contributions")
                    <td class="bg-grey-darker text-white">Bono Seguridad Ciudadana</td>
                @endif
           </tr>         
            @foreach($ballot_detail->ballot_adjusts as $ballot)
           <tr>
                <td>{{Carbon::parse($ballot['month_year'])->format('d/m/y')}}</td>
                <td> {{Util::money_format($ballot['payable_liquid'])}}</td>
                <td> {{Util::money_format($ballot['mount_adjust'])}}</td>
                @if($ballot_type == "contributions")
                    <td> {{Util::money_format($ballot['border_bonus'])}}</td>
                    <td> {{Util::money_format($ballot['position_bonus'])}}</td>
                    <td> {{Util::money_format($ballot['east_bonus'])}}</td>
                    <td> {{Util::money_format($ballot['public_security_bonus'])}}</td>
                @endif
                @if($ballot_type == "aid_contributions")
                    <td> {{Util::money_format($ballot['dignity_rent'])}}</td>
                @endif                              
           </tr>
            @endforeach
            @foreach($ballot_detail->average_ballot_adjust as $average_ballot)
            <tr>
                @php ($title_total = " ")
                @if($loan->modality->loan_modality_parameter->quantity_ballots >1)
                    @php ($title_total = "PROMEDIO")
                @endif
                @php ($a = $title_total == "PROMEDIO" ? "DE LA":" ")
                <td>Total {{$title_total}}</td>
                <td> {{Util::money_format($average_ballot['average_payable_liquid'])}}</td>
                <td> {{Util::money_format($average_ballot['average_mount_adjust'])}}</td>
                @if($ballot_type == "contributions")
                    <td> {{Util::money_format($average_ballot['average_border_bonus'])}}</td>
                    <td> {{Util::money_format($average_ballot['average_position_bonus'])}}</td>
                    <td> {{Util::money_format($average_ballot['average_east_bonus'])}}</td>
                    <td> {{Util::money_format($average_ballot['average_public_security_bonus'])}}</td>
                @endif
                @if($ballot_type == "aid_contributions")
                    <td> {{Util::money_format($average_ballot['average_dignity_rent'])}}</td>
                @endif
           </tr>
            @endforeach
        </table>
        <table style="font-size:12px;" class="table-info w-100 text-center uppercase my-10"> 
            <tr class="bg-grey-darker text-white">
                @php ($title_average = " ")
                @if($loan->modality->loan_modality_parameter->quantity_ballots >1)
                    @php ($title_average = "PROMEDIO")
                @endif
                    @php ($a = $title_average == "PROMEDIO" ? "DE LA":" ")
                <td colspan="2" class="w-100">{{$title_average }} {{$a}} BOLETA</td>
            </tr>
            <tr >
                <td class="w-50 text-left px-10">TOTAL {{$title_average }} LÍQUIDO PAGABLE</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($affiliate->pivot->payable_liquid_calculated)}} </td>
            </tr>
            <tr >
                <td class="w-50 text-left px-10">TOTAL {{$title_average }} BONOS</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($affiliate->pivot->bonus_calculated)}}</td>
            </tr>
            <tr >
                <td class="w-50 text-left px-10">LÍQUIDO PARA CALIFICACIÓN</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($disbursable->liquid_qualification_calculated) }}</td>     
            </tr>
        </table>
    </div>
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DATOS DE EVALUACIÓN AL PRESTATARIO</div>
        </div>
    <div class="block">
        <table style="font-size:12px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td colspan="2" >PROPUESTA Y APROBACIÓN </td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">NOMBRES</td>
                <td class="w-50 text-left px-10">{{ $disbursable->full_name }}</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">INTERÉS CORRIENTE</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->interest->annual_interest) }} % Anual</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">INTERÉS PENAL</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->interest->penal_interest) }} % Anual</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">LÍQUIDO PARA CALIFICACIÓN</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->liquid_qualification_calculated) }}</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">MONTO DEL PRÉSTAMO AUTORIZADO</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->amount_approved) }}</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">PLAZO EN MESES</td>
                <td class="w-50 text-left px-10">{{ $loan->loan_term }}</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">CUOTA MENSUAL</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->estimated_quota) }}</td>
            </tr>
            <tr  class="w-100">
                <td class="w-50 text-left px-10">ÍNDICE DE ENDEUDAMIENTO</td>
                <td class="w-50 text-left px-10">{{ Util::money_format($loan->indebtedness_calculated) }} %</td>
            </tr>
        </table>
    </div>
        <div class="block">
            <div class="font-semibold leading-tight text-left m-b-10 text-sm">{{ $n++ }}. DOCUMENTOS PRESENTADOS</div>
        </div>
        @endforeach
    <div class="block">
        <table style="font-size:11px;" class="table-info w-100 text-center uppercase my-10">
            <tr class="bg-grey-darker text-white">
                <td colspan="3">Requisitos</td>
            </tr>
            @php ($count_req = 0)
            @foreach ($loan->documents_modality() as $key => $document)
                @if($document->number != 0)
                @php($count_req++)
                <tr>
                    <td class="data-row py-5 w-10">{{ $count_req}}</td>
                    <td class="data-row py-5 w-85">{{ $document->name }}</td>
                    <td class="data-row py-5 w-5">&#10003;</td>
                </tr>
                @endif()
            @endforeach
            @foreach ($loan->documents_modality() as $key => $document)
                @if($document->number === 0)
                @php($count_req++)
                <tr>
                    <td class="data-row py-5 w-10">{{ $count_req}}</td>
                    <td class="data-row py-5 w-85">{{ $document->name }}</td>
                    <td class="data-row py-5 w-5">&#10003;</td>
                </tr>
                @endif()
            @endforeach
            @if ($loan->notes()->count())
            <tr class="bg-grey-darker text-xxs text-white">
                <td colspan="3">Otros</td>
            </tr>
                @foreach ($loan->notes as $key => $note)
                <tr>
                    <td class="data-row py-5">{{ $key + 1 }}</td>
                    <td class="data-row py-5" colspan="2">{{ $note->message }}</td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
    <div class="block">
        <div style="font-size:10px;" class="block  text-justify ">
            <div>
                La presente solicitud se constituye en una <span class="font-bold">DECLARACIÓN JURADA</span>, consignandose los datos como fidedignos por los interesados.
            </div>
            <br>
            <div>
                El suscrito Asistente de Oficina y/o Responsable Regional y/o Atención al Afiliado de la MUSERPOL, CERTIFICA LA AUTENTICIDAD de la documentación presentada y la firma suscrita por el/la Solicitante, dando FÉ de que la misma fue estampada en mi presencia y en forma voluntaria con puño y letra del Solicitante.
            </div>
        </div>
    </div>
        <table style="font-size:11px;">
            <tbody>
                @foreach ($signers->chunk(2) as $chunk)
                <tr class="align-top">
                    @foreach ($chunk as $person)
                        <td width="50%">
                            @include('partials.signature_box', $person)
                        </td>                
                    @endforeach
                @endforeach      
                <td width="50%">
                @php($user = Auth::user())
                @include('partials.signature_box', [
                        'full_name' => $user->full_name,
                        'position' => $user->position,
                        'employee' => true
                    ])
                </td>
                </tr>
            </tbody>
        </table>
            <table style="font-size:11px; border-spacing: 60px ;">
                <tr class="align-top">
                    <th  width="100%" class=" text-center">
                    <hr style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;" width="250px">
                        APROBADO POR
                    </th>
                </tr>
            </table>
    </div>

</body>
</html>