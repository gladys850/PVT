<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanGuaranteeRetirementFund extends Model
{
    public $fillable = 
    ['
        id,
        loan_id
        total_retirement_fund
        warranty_coverage'
    ];

    public function loans()
    {
        return $this->hasOne(Loan::class);
    }
}
