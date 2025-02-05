<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Workflow;
use App\ObservationType;
use Util;

/** @group Módulos
* Flujos disponibles en el sistema
*/
class workflowController extends Controller
{
    /**
    * Lista de flujos
    * Devuelve el listado con los flujos paginados
    * @queryParam name Filtro por nombre. Example: prestamos
    * @queryParam sortBy Vector de ordenamiento. Example: [name]
    * @queryParam sortDesc Vector de orden descendente(true) o ascendente(false). Example: [false]
    * @queryParam per_page Número de datos por página. Example: 10
    * @queryParam page Número de página. Example: 1
    * @authenticated
    * @responseFile responses/module/index.200.json
    */
    public function index(Request $request)
    {
        $filter = $request->has('name') ? ['name' => $request->name] : [];
        if (!Auth::user()->hasRole('TE-admin')) {
            $filter['id'] = Auth::user()->modules;
        }
        return Util::search_sort(new Module(), $request, $filter);
    }

    public function show(Workflow $workflow)
    {
        return $workflow;
    }

    /**
    * Roles asociados al módulo
    * Devuelve la lista de roles asociados a un módulo
    * @urlParam module required ID del módulo. Example: 6
    * @authenticated
    * @responseFile responses/module/get_roles.200.json
    */
    public function get_roles(Module $module)
    {
        return $module->roles()->get();
    }

    public function get_workflows(Module $module)
    {
        return $module->procedure_types()->where('name','LIKE', '%Préstamo%')->get();
    }

    /**
    * Tipos de amortizaciones de préstamo asociados al módulo
    * Devuelve la lista de tipos de amortizaciones de préstamo asociados a un módulo
    * @urlParam module required ID del módulo. Example: 6
    * @authenticated
    * @responseFile responses/module/get_amortization_types.200.json
    */
    public function get_amortization_types(Module $module)
    {
        return $module->procedure_types()->where('name','LIKE', '%Amortización%')->get();
    }
}
