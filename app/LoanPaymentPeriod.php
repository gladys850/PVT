<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPaymentPeriod extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    public $guarded = ['id'];
    public $fillable = ['year',
                        'month',
                        'description',
                        'importation',
                        'importation_type'
                        //'import_command',
                        //'import_senasir'
                        ];
}
