<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanProcedure extends Model
{
    public $timestamps = true;
    public $fillable = [
        'description',
        'start_production_date',
        'end_production_date',
    ];
}
