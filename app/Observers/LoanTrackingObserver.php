<?php

namespace App\Observers;

use App\LoanTracking;
use App\Loan;
use App\User;
use App\Record;
use App\Helpers\Util;
use App\LoanTrackingType;

class LoanTrackingObserver
{
    /**
     * Handle the loan tracking "created" event.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return void
     */
    public function created(LoanTracking $loanTracking)
    {
        $loan = Loan::find($loanTracking->loan_id);
        Util::save_record($loan, 'datos-de-un-tramite', 'registró Seguimiento de Mora: '. $loanTracking->loan_tracking_type->name);
    }

    /**
     * Handle the loan tracking "updated" event.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return void
     */
    public function updated(LoanTracking $loanTracking)
    {
        $loan = Loan::find($loanTracking->loan_id);
        $message = 'modificó datos del seguimiento de MORA (creado el ' . $loanTracking->created_at . '): ';

        if($loanTracking->user_id != $loanTracking->getOriginal('user_id')) {
            $id = $loanTracking->getOriginal('user_id');
            $old = User::find($loanTracking->getOriginal('user_id'));
            $message = $message . ' [Usuario] '.($old->username??"Sin usuario").' a '.(optional($loanTracking->user)->username??"Sin usuario").', ';
        }
        if($loanTracking->loan_tracking_type_id != $loanTracking->getOriginal('loan_tracking_type_id')) {
            $id = $loanTracking->getOriginal('loan_tracking_type_id');
            $old = LoanTrackingType::find($loanTracking->getOriginal('loan_tracking_type_id'));
            $message = $message . ' [Tipo de seguimiento] '.($old->name??"Sin tipo de seguimiento").' a '.(optional($loanTracking->loan_tracking_type)->name??"Sin tipo de seguimiento").', ';
        }
        if($loanTracking->tracking_date != $loanTracking->getOriginal('tracking_date')) {
            $message = $message . ' [Fecha de seguimiento] '.($loanTracking->getOriginal('tracking_date')??"Sin fecha de seguimiento").' a '.($loanTracking->tracking_date??"Sin fecha de seguimiento").', ';
        }
        if($loanTracking->description != $loanTracking->getOriginal('description')) {
            $message = $message . '[Descripción del seguimiento],';
        }
        Util::save_record($loan, 'datos-de-un-tramite',  $message);
    }

    /**
     * Handle the loan tracking "deleted" event.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return void
     */
    public function deleted(LoanTracking $loanTracking)
    {
        $loan = Loan::find($loanTracking->loan_id);
        $message = 'eliminó registro de seguimiento de MORA (creado el ' . $loanTracking->created_at . ')';
        Util::save_record($loan, 'datos-de-un-tramite',  $message);
    }

    /**
     * Handle the loan tracking "restored" event.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return void
     */
    public function restored(LoanTracking $loanTracking)
    {
        //
    }

    /**
     * Handle the loan tracking "force deleted" event.
     *
     * @param  \App\LoanTracking  $loanTracking
     * @return void
     */
    public function forceDeleted(LoanTracking $loanTracking)
    {
        //
    }
}
