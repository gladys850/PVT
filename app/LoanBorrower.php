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

    public function getFullNameAttribute()
    {
      return rtrim($this->first_name.' '.$this->second_name.' '.$this->last_name.' '.$this->mothers_last_name.' '.$this->surname_husband);
    }

    public function getIdentityCardExtAttribute()
    {
        $data = $this->identity_card;
        if ($this->city_identity_card && $this->city_identity_card != 'NINGUNO'){
          $data .= ' ' . $this->city_identity_card->first_shortened;
        } 
        return rtrim($data);
    }

    public function getTitleAttribute()
    {
      $data = "";
      if ($this->degree) $data = $this->degree->shortened;;
      return $data;
    }

    public function loan()
    {
      return $this->belongsTo(Loan::class);
    }

    public function title()
    {
      return $this->loan->affiliate->title;
    }

    public function affiliate_state()
    {
      return $this->belongsTo(AffiliateState::class);
    }

    public function affiliate()
    {
      return $this->hasOneTrough(Affiliate::class, Loan::class, 'loan_id', 'affiliate_id', 'id', 'loan_id');
    }
}