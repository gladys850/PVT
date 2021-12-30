<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanCorrelative extends Model
{
    public $guarded = ['id'];
    public $fillable = ['year',
                        'correlative',
                        'type',
                        ];
}
