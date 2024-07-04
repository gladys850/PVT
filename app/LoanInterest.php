<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProcedureModality;

class LoanInterest extends Model
{
    public $timestamps = true;
    protected $fillable = ['procedure_modality_id', 'annual_interest','penal_interest'];
    public $guarded = ['id'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function daily_current_interest($parameter)
    {
        return $this->annual_interest * $parameter / (100 * 360);
    }

    public function getDailyPenalInterestAttribute($parameter)
    {
        return $this->penal_interest * $parameter/ (100 * 360);
    }

    public function monthly_current_interest($parameter)
    {
        return (($this->annual_interest * $parameter) / 100) / 12;
    }

    public function getMonthlyPenalInterestAttribute($parameter)
    {
        return $this->penal_interest ($parameter) / (100 * 12);
    }

    public function procedure_modality()
    {
        return $this->belongsTo(ProcedureModality::class);
    }
}
