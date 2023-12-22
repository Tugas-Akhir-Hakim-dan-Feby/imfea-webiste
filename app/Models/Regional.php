<?php

namespace App\Models;

use App\Http\Facades\Region\City;
use App\Http\Facades\Region\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regional extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'city_id',
        'address',
        'postal_code',
    ];

    public function province()
    {
        return Province::show($this->attributes['province_id']);
    }

    public function city()
    {
        return City::show($this->attributes['city_id']);
    }

    public function korwilAssigns(): HasMany
    {
        return $this->hasMany(KorwilAssign::class, 'regional_id', 'id');
    }
}
