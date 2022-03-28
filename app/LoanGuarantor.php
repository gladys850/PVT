<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    use Traits\EloquentGetTableNameTrait;
    use Traits\RelationshipsTrait;

    protected $fillable = [
        'loan_id',
        'affiliate_id',
        'degree_id',
        'unity_id',
        'category_id',
        'type_affiliate',
        'unit_police_description',
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
        'civil_status',
        'phone_number',
        'cell_phone_number',
        'address_id',
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
