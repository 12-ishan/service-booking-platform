<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Documents extends Model
{
     use HasApiTokens;

    protected $table = 'documents';

    public function application()
    {
        return $this->hasMany('App\Models\Admin\Application');
    }

    public function highschoolMarksheet()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'highschool_markssheet_id', 'id');
    }

    public function interMarksheet()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'inter_markssheet_id', 'id');
    }

    public function consolidatedMarksheet()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'consolidated_marksheet_id', 'id');
    }

    public function consolidatedCertificate()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'consolidated_certificate_id', 'id');
    }

    public function aadharCard()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'aadhar_card_id', 'id');
    }

    public function signature()
    {
        return $this->belongsTo('App\Models\Admin\Media', 'signature_id', 'id');
    }
}