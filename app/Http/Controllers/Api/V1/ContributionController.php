<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contribution;
use App\Affiliate;
use App\Degree;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Util;
use Carbon\Carbon;

/** @group Contribuciones de afiliados
* Contribuciones de los afiliados
*/

class ContributionController extends Controller
{
    public static function append_data(Contribution $contribution)
    {
        $contribution->breakdown = $contribution->breakdown;
        return $contribution;
    }
    /**
    * Lista de contribuciones
    * Devuelve el listado con los datos paginados
    * @queryParam search Parámetro de búsqueda. Example: 2020-02-03
    * @queryParam sortBy Vector de ordenamiento. Example: []
    * @queryParam sortDesc Vector de orden descendente(true) o ascendente(false). Example: [false]
    * @queryParam per_page Número de datos por página. Example: 8
    * @queryParam page Número de página. Example: 1
    * @authenticated
    * @responseFile responses/contributions/contributions.200.json
    */
    public function index(Request $request)
    {
        $data=Util::search_sort(new Contribution(), $request);
        $data->getCollection()->transform(function ($contribution) {
            return self::append_data($contribution, true);
        });
        return $data;
    }
    
    /**
    * Lista de contribuciones del affiliado
    * Devuelve el listado con los datos paginados del afiliado
    * @urlParam affiliate required ID de afiliado. Example: 26606
    * @queryParam search Parámetro de búsqueda. Example: 2020-02-03
    * @queryParam sortBy Vector de ordenamiento. Example: []
    * @queryParam sortDesc Vector de orden descendente(true) o ascendente(false). Example: [false]
    * @queryParam per_page Número de datos por página. Example: 8
    * @queryParam page Número de página. Example: 1
    * @authenticated
    * @responseFile responses/contributions/contributions_affiliates.200.json
    */

    public function get_all_contribution_affiliate(Request $request,Affiliate $affiliate)
    {
        $filters = [
            'affiliate_id' => $affiliate->id
        ];
        $data=Util::search_sort(new Contribution(), $request, $filters);
        $data->getCollection()->transform(function ($contribution) {
            return self::append_data($contribution, true);
        });
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function print_contribution(Request $request, Contribution $contribution, $standalone = true)
    {
        $affiliate = Affiliate::find($contribution->affiliate_id);
        $month_year = Carbon::createFromFormat('Y-m-d', $contribution->month_year);
        $period = $month_year->format('m'). "-" .$month_year->format('Y');  

        $data = [
            'header' => [
                'direction' => 'DIRECCIÓN DE ESTRATEGIAS SOCIALES E INVERSIONES',
                'unity' => 'UNIDAD DE INVERSIÓN EN PRÉSTAMOS',
                'table' => [
                    ['Usuario', Auth::user()->username],
                    ['Fecha', Carbon::now()->format('d/m/Y')],
                    ['Hora', Carbon::now()->format('h:m:s a')]
                ]
            ],
            'title' => 'COMPROBANTE DE PAGO',
            'subtitle' => '(SEGÚN IMPORTACIÓN DE PLANILLA DE HABERES - COMANDO GENERAL DE LA POLICÍA BOLIVIANA)',
            'period' => $period,
            'affiliate' => $affiliate,
            'contribution' => $contribution
        ];

        $file_name='';
        $file_name = implode('_', ['BOLETA', $affiliate->id]) . '.pdf';
        $view = view()->make('contribution.contribution_voucher')->with($data)->render();
        if ($standalone) return Util::pdf_to_base64([$view], $file_name, $file_name, 'letter', $request->copies ?? 1);
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
