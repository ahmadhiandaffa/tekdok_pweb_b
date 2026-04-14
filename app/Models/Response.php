<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = [
        'tinggi_badan',
        'berat_badan',
        'bmi',
        'j1',
        'j2',
        'j3',
        'j4',
        'j5',
        'j6',
        'j7',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'g1',
        'g2',
        'g3',
        'g4',
        'g5',
        'g6',
        'g7',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
    ];

    public function organScores()
    {
        return $this->hasMany(OrganScore::class);
    }
}