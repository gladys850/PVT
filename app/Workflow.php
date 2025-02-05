<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['id', 'module_id', 'name','shortened'];

    public function module()
    {
        return $this->hasOne(Module::class, 'module_id');
    }

    public static function flow($modality_id, $current_role_id)
    {
        return (object)[
            'current' => $current_role_id,
            'previous' => $this->wf_sequences,
            'next' => self::next_steps($modality_id, $current_role_id)
        ];
    }

    public function wf_sequences()
    {
        return $this->hasMany(WfSequence::class);
    }

    public function next_sequence()
    {
        return $this;
    }
}