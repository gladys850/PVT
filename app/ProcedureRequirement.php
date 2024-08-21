<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcedureRequirement extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        'procedure_modality_id',
        'procedure_document_id',
        'number'
    ];
  
        public function procedure_document()
    {
        return $this->belongsTo(ProcedureDocument::class);
    }

}
