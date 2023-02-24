<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanTrackingType extends Model
{
    public $timestamps = true;
    public $guarded = ['id'];
    public $fillable = ['sequence_number', 'name', 'is_valid'];

    public function loan_tracking() {
        return $this->hasMany(LoanTracking::class);
    }

}
