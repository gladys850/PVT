<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanBorrower extends Model
{
    use Traits\EloquentGetTableNameTrait;
    use Traits\RelationshipsTrait;

    protected $fillable = [
        'loan_id',
        'affiliate_state_id',
        'identity_card',
        'city_identity_card_id',
        'registration',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'surname_husband',
        'gender',
        'phone_number',
        'cell_phone_number',
        'address',
        'pension_entity_id',
        'payment_percentage',
        'payable_liquid_calculated',
        'bonus_calculated',
        'quota_previous',
        'quota_treat',
        'indebtedness_calculated',
        'indebtedness_calculated_previous',
        'liquid_qualification_calculated',
        'contributionable_ids',
        'contributionable_type',
        'type'
      ];
}