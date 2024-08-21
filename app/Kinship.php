<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kinship extends Model
{
    use Traits\EloquentGetTableNameTrait;

    protected $table = 'kinships';

    protected $fillable = [
        'name',
    ];

    public function personal_references()
    {
        return $this->hasMany(PersonalReference::class, 'kinship_id', 'id');
    }
}
