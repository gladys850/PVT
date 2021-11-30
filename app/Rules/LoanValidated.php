<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use App\Loan;

class LoanValidated implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::user();
        $user_roles = Auth::user()->roles->pluck('id')->toArray();
        if (in_array($this->loan->role_id,$user_roles)) return true;
        else return false;

       //if ($user_roles->search($this->loan->role_id) === false) return false;
    
       //return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El tramite no esta disponible para su rol';
    }
}
