<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Scholarship extends Model
{
     use HasApiTokens;

    protected $table = 'scholarship';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }

    public function explanationDocument()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'explanation_document_id', 'id');
    }
}