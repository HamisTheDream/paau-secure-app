<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    // This tells Laravel these specific columns are safe to auto-fill
    protected $fillable = [
        'reported_by',
        'suspect_id',
        'incident_type',
        'description',
    ];
}