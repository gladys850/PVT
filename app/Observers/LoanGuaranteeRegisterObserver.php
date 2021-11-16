<?php

namespace App\Observers;

use App\LoanGuaranteeRegister;
use App\Helpers\Util;

class LoanGuaranteeRegisterObserver
{
    /**
     * Handle the loan guarantee register "created" event.
     *
     * @param  \App\LoanGuaranteeRegister  $loanGuaranteeRegister
     * @return void
     */
    public function created(LoanGuaranteeRegister $loanGuaranteeRegister)
    {
        Util::save_record($loanGuaranteeRegister, 'datos-de-un-tramite', 'registró : '. $loanGuaranteeRegister->id);
    }

    /**
     * Handle the loan guarantee register "updated" event.
     *
     * @param  \App\LoanGuaranteeRegister  $loanGuaranteeRegister
     * @return void
     */
    public function updated(LoanGuaranteeRegister $loanGuaranteeRegister)
    {
        Util::save_record($loanGuaranteeRegister, 'datos-de-un-tramite', Util::concat_action($loanGuaranteeRegister));
    }

    /**
     * Handle the loan guarantee register "deleted" event.
     *
     * @param  \App\LoanGuaranteeRegister  $loanGuaranteeRegister
     * @return void
     */
    public function deleted(LoanGuaranteeRegister $loanGuaranteeRegister)
    {
        Util::save_record($loanGuaranteeRegister, 'datos-de-un-tramite', 'eliminó : ' . $loanGuaranteeRegister->id);
    }

    /**
     * Handle the loan guarantee register "restored" event.
     *
     * @param  \App\LoanGuaranteeRegister  $loanGuaranteeRegister
     * @return void
     */
    public function restored(LoanGuaranteeRegister $loanGuaranteeRegister)
    {
        //
    }

    /**
     * Handle the loan guarantee register "force deleted" event.
     *
     * @param  \App\LoanGuaranteeRegister  $loanGuaranteeRegister
     * @return void
     */
    public function forceDeleted(LoanGuaranteeRegister $loanGuaranteeRegister)
    {
        //
    }
}
