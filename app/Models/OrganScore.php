<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganScore extends Model
{
    protected $fillable = [
        'response_id',
        'organ_name',
        'raw_score',
        'max_score',
        'percentage',
        'status',
        'bmi_penalty',
    ];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }
}