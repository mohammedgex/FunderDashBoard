<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'start_date',
        'end_date',
        'status',
        'monthly_income',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
