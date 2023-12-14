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
        return $this->annual_interest * $parameter / (100 * $numerator);
    }

    public function getDailyPenalInterestAttribute($parameter)
    {
        return $this->penal_interest * (365.25/360)/ (100 * 365.25);
    }

    public function monthly_current_interest($parameter)
    {
        //return round((((pow((1+(($this->annual_interest)/100)),365.25/360))-1)/12),8);
        return ($this->annual_interest * $parameter) / (100 * 12);
    }

    public function getMonthlyPenalInterestAttribute()
    {
        return $this->penal_interest (365.25/360) / (100 * 12);
    }

    public function procedure_modality()
    {
        return $this->belongsTo(ProcedureModality::class);
    }
}
