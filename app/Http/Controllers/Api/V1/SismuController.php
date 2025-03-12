<?php

namespace App\Http\Controllers\Api\V1;
use App\Address;
use App\Http\Requests\AddressForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Util;
use Illuminate\Support\Facades\Auth;
use App\Record;
use Carbon;

/** @group Direcciones
* Datos de las direcciones de los afiliados y de aquellas relacionadas con los trámites
*/
class SismuController extends Controller
{
    public function  getLoanSismu(request $request)
    {
        $query = "SELECT 
            CONCAT(TRIM(pa.PadNombres), ' ', TRIM(pa.PadPaterno), ' ', TRIM(pa.PadMaterno)) AS full_name, 
            pa.PadCedulaIdentidad, 
            p.IdPrestamo, 
            p.PresNumero, 
            p.PresFechaDesembolso, 
            p.PresMeses, 
            p.PresCuotaMensual, 
            p.PresSaldoAct, 
            p.PresEstPtmo, 
            p.PresMntDesembolso
            FROM 
                Prestamos p
            JOIN 
                Padron pa ON pa.IdPadron = p.IdPadron
            WHERE 
                p.PresNumero = '$request->code';";
        $sismu_loan = DB::connection('sqlsrv')->select($query);
        return $sismu_loan;
    }

    public function update_balance(Request $request)
    {
        $request->validate([
            'IdPrestamo' => 'required|string',
            'role_id' => 'required|exists:roles,id'
        ]);
        try {
            DB::beginTransaction();
            $id_prestamo = $request->IdPrestamo;
            $username = Auth::user()->username;
            $oldBalance = (float) $request->balance;
            $action = 'Actualizo saldo del préstamo';
            $balance = $balance_prev = 0;
            $query = "SELECT (p.PresMntDesembolso - ISNULL(SUM(a.AmrCap), 0)) AS balance, p.PresMntDesembolso
                    FROM Prestamos p
                    LEFT JOIN Amortizacion a ON p.IdPrestamo = a.IdPrestamo
                    WHERE p.IdPrestamo = $id_prestamo
                    AND a.AmrSts = 'S'
                    GROUP BY p.PresMntDesembolso;";
            $result = DB::connection('sqlsrv')->select($query);
            $balance = $result[0]->balance;
            $balance = $balance > 0 ? $balance : $result[0]->PresMntDesembolso;
            $query = "SELECT (p.PresMntDesembolso - SUM(a.AmrCap)) AS balance_prev
                    FROM Amortizacion a
                    JOIN Prestamos p ON p.IdPrestamo = a.IdPrestamo
                    WHERE a.IdPrestamo = $id_prestamo
                    AND a.AmrSts = 'S'
                    AND a.AmrNroPag <> (SELECT MAX(AmrNroPag) FROM Amortizacion WHERE IdPrestamo = $id_prestamo AND AmrSts = 'S')
                    GROUP BY p.PresMntDesembolso;";
            $result_prev = DB::connection('sqlsrv')->select($query);
            $balance_prev = $result_prev[0]->balance_prev;
            $balance_prev = $balance_prev > 0 ? $balance_prev : $result_prev[0]->PresMntDesembolso;
            $query_update = "UPDATE Prestamos
                            SET PresSaldoAct = $balance, PresSaldoAnt = $balance_prev
                            WHERE IdPrestamo = $id_prestamo;";
            $update = DB::connection('sqlsrv')->update($query_update);
            $date = now()->format('Y-m-d H:i:s');
            $query_record = "INSERT INTO sismu_records
                    ([User], [Action], IdPrestamo, SaldoAnt, SaldoAct, CreatedAt)
                    VALUES('$username', '$action', $id_prestamo, CAST('$oldBalance' AS MONEY), CAST('$balance' AS MONEY), '$date');";
            $sismu_record = DB::connection('sqlsrv')->insert($query_record);
            DB::commit();
            return [
                'balance' => $balance > 0 ? round($balance, 2) : 0,
                'balance_prev' => $balance_prev > 0 ? round($balance_prev, 2) : 0,
                'status' => $query_update ? true : false,
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'No se pudo actualizar el saldo'], 409);
        }
    }

    
    public function update_pending_interest(Request $request)
    {
        $request->validate([
            'IdPrestamo' => 'required|integer',
            'current_role_id' => 'required|exists:roles,id',
            'new_interest_pending' => 'required|numeric|gte:0'
        ]);

        try {
            DB::beginTransaction();

            $id_prestamo = $request->IdPrestamo;
            $username = Auth::user()->username;

            // Obtener préstamo
            $prestamo = DB::connection('sqlsrv')->select("SELECT * FROM Prestamos WHERE IdPrestamo = ?", [$id_prestamo]);

            if (empty($prestamo)) {
                return response()->json(['error' => 'Préstamo no encontrado'], 404);
            }

            $old_interest_pending = (float) $prestamo[0]->PresIntPendientes;

            // Actualizar préstamo
            $update = DB::connection('sqlsrv')->update(
                "UPDATE Prestamos SET PresIntPendientes = ? WHERE IdPrestamo = ?",
                [$request->new_interest_pending, $id_prestamo]
            );

            if (!$update) {
                throw new \Exception('No se pudo actualizar el interés pendiente.');
            }

            // Registrar en sismu_records
            $action = 'Actualizó interés pendiente del préstamo';
            $date = now()->format('Y-m-d H:i:s');

            DB::connection('sqlsrv')->insert(
                "INSERT INTO sismu_records (UserPvt, RoleIdPvt, [Action], IdPrestamo, PresIntPendientesAnt, PresIntPendientesAct, CreatedAt) 
                VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$username, $request->current_role_id, $action, $id_prestamo, $old_interest_pending, $request->new_interest_pending, $date]
            );

            DB::commit();

            return response()->json([
                'new_interest_pending' => $request->new_interest_pending,
                'interest_previous' => $old_interest_pending,
                'status' => true,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 409);
        }
    }
}