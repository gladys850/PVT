<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetirementFundAverage extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'degree_id',
        'category_id',
        'retirement_fund_average',
        'is_active'
    ];
}
