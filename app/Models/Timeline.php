<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'title',
        'description',
        'property_id'
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
