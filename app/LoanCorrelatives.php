<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class LoanCorrelative extends Model
{
    use SoftDeletes;
    public $guarded = ['id'];
    public $fillable = ['year',
                        'correlative',
                        'type',
                        ];
}
