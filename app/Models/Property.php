<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'images',
        'funded_date',
        'purchase_price',
        'funder_count',
        'rental_income',
        'current_rent',
        'current_evaluation',
        'percent',
        'location_string',
        'location_longitude',
        'location_latitude',
        'property_price_total',
        'property_price',
        'service_charge',
        'status',
        'approved',
        'category_id',
        'estimated_annualised_return',
        'estimated_annual_appreciation',
        'estimated_projected_gross_yield',
        'discount'
    ];
    protected $casts = [
        'images' =>  'array',
        'funded_date' => 'date'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
    public function location()
    {
        return $this->hasOne(Location::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
    public function funders()
    {
        return $this->hasMany(Funder::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
