<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanTracking extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    public $guarded = ['id'];
    public $fillable = ['loan_id', 'user_id', 'loan_tracking_type_id', 'tracking_date', 'description'];

    public function loan_tracking_type() {
        return $this->belongsTo(LoanTrackingType::class);
    }

    public function loan() {
        return $this->belongsTo(Loan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
